<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Session;
use App\Models\Admodels\PostModel;
use App\Models\User;
use Carbon\Carbon as Carbon;
use CNST;
use File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Image;
use Storage;
use View;

class AdminBaseController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $module;

    protected $data = [];

    protected $requestSlug;

    protected $postDateFormat = 'd/m/Y';

    protected $databaseDateFormat = 'Y-m-d';

    protected $buttons;

    protected $hasTextEditor;

    protected $hasPluploader;

    protected $imageDimensions;
    protected $postData;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {

        $this->postData = $request;
        $config = \HTMLPurifier_Config::createDefault();
        $config->set("HTML.Allowed", "");
        $this->data['HTMLTextOnlyPurifier'] = new \HTMLPurifier($config);
        $this->data['currentURI'] = $request->fullUrl();

        $this->data['pageTitle'] = 'Admin';
        $routeParams = (!empty(\Route::current())) ? \Route::current()->parameters() : [];
        $this->requestSlug = (!empty($routeParams['slug'])) ? $routeParams['slug'] : false;

        $this->_set_page_title($this->requestSlug);

        $this->buttons = ['add' => true, 'edit' => true, 'delete' => true, 'status' => true];
        $this->data['buttons'] = $this->buttons;
        $this->data['hasPluploader'] = $this->hasPluploader;
        $this->data['hasTextEditor'] = $this->hasTextEditor;

        $this->middleware(function ($request, $next) {
            if (!Storage::disk('local')->exists('installed')) {
                return redirect()->to(route('web-installer'));
            }

            if (\Auth::user()) {
                $userID = \Auth::user()->id;
                $this->data['userObj'] = User::findOrFail($userID);
                $this->userObj = $this->data['userObj'];

                $this->data['canUserDeleteRecord'] = \Auth::user()->hasAnyRole(['Super Admin', 'System Administrator']);

            }

            $this->data['userMessage'] = \Session::get('userMessage');
            $this->data['errorMessage'] = \Session::get('errorMessage');

            $this->data['targetUpdateUserMessage'] = \Session::get('targetUpdateUserMessage');
            $this->data['targetUserMessage'] = \Session::get('targetUserMessage');
            $this->data['attachmentUserMessage'] = \Session::get('attachmentUserMessage');
            $this->data['kpiUpdateUserMessage'] = \Session::get('kpiUpdateUserMessage');
            $this->data['kpiUserMessage'] = \Session::get('kpiUserMessage');
            $this->data['focusAreaUserMessage'] = \Session::get('focusAreaUserMessage');
            $this->data['strategicPriorityUserMessage'] = \Session::get('strategicPriorityUserMessage');

            $this->data['topMessage'] = \Session::get('topMessage');

            $this->data['hasTextEditor'] = false;

            $this->data['hasPluploader'] = false;

            $this->get_website_settings();

            $this->data['menuPosition'] = (!empty($this->data['websiteSettings'])) ? $this->data['websiteSettings']->getMeta('admin_menu_position') : 'left';

            $this->data['activeTab'] = false;

            $this->data['lang'] = 'en';

            \App::setLocale($this->data['lang']);
            \Session::put('lang', $this->data['lang']);

            if (\Session::has('switchLang')) {
                session()->put('lang', \Session::get('switchLang'));
                $this->data['lang'] = \Session::get('switchLang');
                \App::setLocale($this->data['lang']);
                \Log::info('switched lang stored in session');
            }

            return $next($request);

        });

    }
    /**
     * Display a Invalid Permission message.
     *
     * @return \Illuminate\Http\Response
     */
    protected function returnInvalidPermission($request) {
        $responseText = '<div class="alert alert-danger">' . lang('invalid_permission') . '</div>';
        if ($request->ajax()) {
            return response()->json(['status' => false, 'userMessage' => $responseText]);
        } else {
            return Redirect(route('admin_dashboard'))->with('userMessage', $responseText);
        }
    }
    /**
     * check permission.
     * @param string $action
     * @return bool
     */
    protected function checkPermission($action) {
        $permissionName = $action;

        return ($this->userObj->can($permissionName) || Auth::user()->is_super_admin == 1 || Auth::user()->hasAnyRole(['Super Admin'])
        ) ? true : false;
    }
    /**
     * creating child post data.
     * @param Illuminate\Http\Request $request
     * @param int $parentId
     * @return Array  $postArr
     */
    protected function _get_child_post_data($request, $parentId) {
        $postArr = [];

        if (empty($request->postChild) || !isset($request->postChild)) {
            return false;
        }

        foreach ($request->postChild['title'] as $key => $postData) {
            if (!empty($request->postChild['title'][$key])) {
                $temp = [];
                $temp['post']['post_title'] = $request->postChild['title'][$key];
                $temp['post']['post_title_arabic'] = $request->postChild['title_arabic'][$key];
                $temp['post']['post_type'] = $request->post['type'] . '_child';
                $temp['post']['post_parent_id'] = $parentId;
                $temp['post']['post_created_by'] = auth()->user()->id;
                $temp['post']['post_updated_by'] = auth()->user()->id;
                $temp['post']['post_status'] = 1;

                $temp['postMeta'] = $this->_get_child_post_meta_data($request, $key);
                $postArr[] = $temp;
            }
        }

        return $postArr;
    }
    /**
     * creating child post meta data.
     * @param Illuminate\Http\Request $request
     * @param string $arrIndex
     * @return Array  $postMetaArrResult
     */
    private function _get_child_post_meta_data($request, $arrIndex) {

        $postMetaArr = [];
        $postMetaArrResult = [];
        $arrayKeys = [];
        if (empty($request->postChild['meta']) || !isset($request->postChild['meta'])) {
            return false;
        }

        foreach ($request->postChild['meta'] as $key => $postData) {

            if ($key == 'date') {

                foreach ($postData as $key1 => &$val1) {
                    $val1 = Carbon::parse($val1)->format($this->postDateFormat);
                    $postData[$key1] = $this->_getCarbonObject($val1, $this->postDateFormat);
                }

            }

            $postMetaArr[] = $postData;
        }

        $postMetaArr = Arr::collapse($postMetaArr);

        $array_keys = array_keys($postMetaArr);

        foreach ($array_keys as $metaKey) {
            if (!empty($postMetaArr[$metaKey][$arrIndex])) {
                $postMetaArrResult[$arrIndex][$metaKey] = $postMetaArr[$metaKey][$arrIndex];
            }

        }

        return Arr::collapse($postMetaArrResult);
    }
    /**
     * creating post  data.
     * @param Illuminate\Http\Request $request
     * @return Array  $postArr
     */
    protected function _get_post_data($request) {
        $postArr = [];
        if (empty($request->post) || !isset($request->post)) {
            return false;
        }
       // dd($request->post);
        foreach ($request->post as $key => $postData) {
           
            if($key=="publish_date"){
                $date=Carbon::parse($postData)->format($this->postDateFormat);
                $dateObj=$this->_getCarbonObject($date, $this->postDateFormat);
                $postArr['post_' . $key] =  $dateObj->format('Y-m-d');
            }else{
                $postArr['post_' . $key] = $postData;
            }
            
        }
        $postArr['post_created_by'] = auth()->user()->id;
        $postArr['post_updated_by'] = auth()->user()->id;
   
        return $postArr;
    }
    /**
     * creating post meta data.
     * @param Illuminate\Http\Request $request
     * @return Array  $postMetaArr
     */
    protected function _get_post_meta_data($request) {

        $postMetaArr = [];
        if (empty($request->meta) || !isset($request->meta)) {
            return false;
        }

        foreach ($request->meta as $key => $postData) {

            if ($key == 'date') {
                foreach ($postData as $key1 => &$val1) {

                    $val1 = Carbon::parse($val1)->format($this->postDateFormat);
                    $postData[$key1] = $this->_getCarbonObject($val1, $this->postDateFormat);

                }
            }
            $postMetaArr[] = $postData; //laravel helper
        }

        return Arr::collapse($postMetaArr);
    }
    /**
     * creating CarbonObject.
     * @param String $dateStr
     * @param String $sourceFormat
     * @return object  $dateObj
     */
    private function _getCarbonObject($dateStr, $sourceFormat) {

        $dateObj = Carbon::createFromFormat($sourceFormat, $dateStr);

        if (!$dateObj) {
            return false;
        }

        return $dateObj;
    }

    private function _convertDate($dateStr, $sourceFormat, $targetFormat) {
        $dateObj = DateTime::createFromFormat($sourceFormat, $dateStr);
        if (!$dateObj) {
            return false;
        }

        return $dateObj->format($targetFormat);
    }

    private function _set_page_title($slug) {

        $this->data['pageTitle'] = ucwords(str_replace("-", " ", $slug));

    }

    protected function get_days_from_interval($fromDate, $toDate, $resultFormat = 'Y-m-d') {
        try {
            $intervalDays = new \DatePeriod(
                new \DateTime($fromDate),
                new \DateInterval('P1D'),
                new \DateTime($toDate)
            );

            $res = array();
            foreach ($intervalDays as $day) {
                $res[] = $day->format($resultFormat);
            }
        } catch (\Exception$ex) {
            return false;
        }
        return $res;
    }

    protected function custom_message($userMessage, $type = 'error') {

        if (is_object($userMessage)) {
            $string = '<ol>';
            $messages = $userMessage->messages();
            foreach ($messages->all() as $message) {
                $string .= '<li>' . $message . '</li>';
            }
            $string .= '</ol>';
            $userMessage = $string;
        }
        return view('admin.common.alerts.' . $type, ['userMessage' => $userMessage])->render();
    }

    protected function store_file($controlName, $path) {
        $file = request()->file($controlName);
        if (!$file) {
            return false;
        }

        $fileName = $file->hashName();
        $fileNameWithPath = $file->store($path);
        return array($fileName, $fileNameWithPath);
    }

    protected function resize_and_crop_image($controlName, $destinationPath, $dimensions = array(), $oldFileName = '') {

        if (empty($destinationPath)) {
            return false;
        }

        if (empty($controlName)) {
            return false;
        }

        if (!request()->hasFile($controlName)) {
            return false;
        }
        // check whether file is uploaded

        if (!request()->file($controlName)->isValid()) {
            return false;
        }
        // chek whether file is valid`

        $destinationPath = storage_path('app/') . $destinationPath;

        $file = Input::file($controlName);

        $extension = $file->getClientOriginalExtension();
        $filename = md5(microtime()) . '.' . $extension;

        $imageUpload = Input::file($controlName)->move($destinationPath, $filename);

        $sourceImage = $destinationPath . DIRECTORY_SEPARATOR . $filename;
        if (!empty($dimensions)) {
            foreach ($dimensions as $dim) {

                if (!File::isDirectory($destinationPath . '/' . $dim['folder'] . "/")) {
                    File::makeDirectory($destinationPath . '/' . $dim['folder']);
                }

                Image::make($sourceImage)
                    ->fit($dim['width'], $dim['height'])
                    ->save($destinationPath . '/' . $dim['folder'] . '/' . $filename)
                    ->destroy();
            }
        }
        if (!empty($oldFileName) && File::exists($destinationPath . '/' . $oldFileName)) {
            File::delete($destinationPath . '/' . $oldFileName);
            if (!empty($dimensions)) {
                foreach ($dimensions as $dim) {
                    File::delete($destinationPath . '/' . $dim['folder'] . '/' . $oldFileName);
                }
            }
        }

        return $filename;

    }

    protected function resize_image($fileName, $filePath, $dimensions = array(), $crop = true, $oldFileName = '') {

        if (empty($fileName)) {
            return false;
        }

        if (empty($filePath)) {
            return false;
        }
        $fileObject = $this->postData->file('file');

        try {
            $sourcePath = storage_path('app/') . $filePath . DIRECTORY_SEPARATOR;
            $sourceImage = $sourcePath . $fileName;
            $ext = pathinfo($sourceImage, PATHINFO_EXTENSION);

            if (!empty($dimensions)) {
                foreach ($dimensions as $key => $dim) {
                    $crop = (isset($dim['crop'])) ? $dim['crop'] : $crop;
                    if (!File::isDirectory($sourcePath . '/' . $key . "/")) {
                        File::makeDirectory($sourcePath . '/' . $key, 0777, true);
                    }

                    if ($crop) {
                        Image::make($sourceImage)
                            ->fit($dim['width'], $dim['height'])
                            ->interlace()
                            ->save($sourcePath . '/' . $key . '/' . $fileName)
                            ->destroy();
                    } else {
										
                        Image::make($sourceImage)
                            ->resize($dim['width'], $dim['height'], function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })
                            ->interlace()
                            ->save($sourcePath . '/' . $key . '/' . $fileName)
                            ->destroy();

                    }
                    if ($ext == 'webp') {
                        $jpgFileName = str_replace('.' . $ext, '.jpg', $fileName);
                        $pngFileName = str_replace('.' . $ext, '.png', $fileName);
                        Image::make($sourcePath . '/' . $key . '/' . $fileName)->interlace()->save($sourcePath . '/' . $key . '/' . $jpgFileName);
                        Image::make($sourcePath . '/' . $key . '/' . $fileName)->interlace()->save($sourcePath . '/' . $key . '/' . $pngFileName);
                    }
                    try {
                        $webpfile = explode('.', $fileName);
                        $webpfileName = $webpfile[0] . '.webp';
                        $mimeType = \File::mimeType($sourceImage);
                        $filePath = $sourcePath . $key . DIRECTORY_SEPARATOR . $fileName;
                        $fileObjectwebp = new UploadedFile(
                            $filePath,
                            $fileName,
                            $mimeType,
                            1234,
                            false,
                            true
                        );
                        \Webp::make($fileObjectwebp)->save($sourcePath . '/' . $webpfileName);
                        \Webp::make($fileObjectwebp)->save($sourcePath . '/' . $key . '/' . $webpfileName);
                    } catch (\Exception$ex) {
                        //log error
                    }
                    try {
                        $avif = explode('.', $fileName);
                        $aviffileName = $avif[0] . '.avif';
                        $mimeType = \File::mimeType($sourceImage);
                        $filePath = $sourcePath . $key . DIRECTORY_SEPARATOR . $fileName;
                       
                        \Spatie\Image\Image::load($filePath)->save($sourcePath . '/' . $key . '/' .$aviffileName);
                        \Spatie\Image\Image::load($filePath)->save($sourcePath . '/' . $aviffileName);
                        
                    } catch (\Exception$ex) {
                        //log error
                    }
                }
            }

            if (!empty($oldFileName) && File::exists($sourcePath . '/' . $oldFileName)) {
                File::delete($sourcePath . '/' . $oldFileName);
                if (!empty($dimensions)) {
                    foreach ($dimensions as $key => $dim) {
                        File::delete($sourcePath . '/' . $key . '/' . $oldFileName);
                    }
                }
            }
        } catch (Exception $ex) {
            return false;
        }

        return true;
    }

    protected function deleteFile($fileName = null, $request) {
        $postBasePath = storage_path('/app/public/post/');
        if (!empty($fileName) && File::exists($postBasePath . $fileName)) {

            DB::table('meta')->where('value', '=', $fileName)->delete();

            if (File::exists($postBasePath . $fileName)) {
                File::delete($postBasePath . $fileName);
            }
            if (File::exists(storage_path('app/post/uploads/recommended/') . $fileName)) {
                File::delete(storage_path('app/post/uploads/recommended/') . $fileName);
            }
            if (File::exists(storage_path('app/post/uploads/large/') . $fileName)) {
                File::delete(storage_path('app/post/uploads/large/') . $fileName);
            }
            if (File::exists(storage_path('app/post/uploads/small/') . $fileName)) {
                File::delete(storage_path('app/post/uploads/small/') . $fileName);
            }

            return \Response::json(array('status' => true, 'message' => 'File Deleted.', 'msgClass' => "sticky-success"));
        } else {
            return \Response::json(array('status' => false, 'message' => 'No such file found.', 'msgClass' => "sticky-important"));
        }

        return \Response::json(array('status' => false, 'message' => 'Invalid Request', 'msgClass' => "sticky-important"));
    }

    protected function downloadFile($fileName = null, $request) {
        if (!empty($fileName) && File::exists($postBasePath . $fileName)) {
            $fileDetails = DB::table('post_details_text')->where('pdt_value', '=', $fileName)->first();
            return response()->download(storage_path('app/public/post/' . $fileName));
        } else {
            return \Response::json(array('status' => false, 'message' => 'No such file found.', 'msgClass' => "sticky-important"));
        }

        return \Response::json(array('status' => false, 'message' => 'Invalid Request', 'msgClass' => "sticky-important"));
    }
    protected function buildTree($elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {

            if ($element->page_parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->page_id);

                if ($children) {
                    $element->childrens = $children;
                }

                $branch[] = $element;
            }
        }

        return $branch;
    }
    protected function get_website_settings() {
        $this->data['websiteSettings'] = \Cache::remember('setting', 10080, function () {
            return PostModel::where('post_type', 'setting')->first();
        });
        $this->data['pageTitle'] = '';
    }

    protected function generateRandomPassword($length = 16) {
        $alphabets = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $pass = [];
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, strlen($alphabets) - 1);
            $pass[] = $alphabets[$n];
        }
        return implode($pass);
    }

    protected function sendMail($mailObj) {
        extract($mailObj);
        $response = false;

        try {
            $mailPostTemplate = PostModel::where('post_type', 'mail-templates')
                ->where('post_title', $mail_template)
                ->first();

            if (empty($mailPostTemplate)) {
                return false;
            }

            $mailDescription = $mailPostTemplate->getData('description');

            foreach ($fieldsToReplace as $key => $value) {
                $mailDescription = str_replace($key, $value, $mailDescription);
            }

            $mailData['mailContent'] = $mailDescription;

            \Mail::send('frontend.email_template.mail_template_' . $lang, $mailData, function ($message) use ($mailData) {
                $message->to($mailData['to'])->subject($mailData['subject']);
            });
            $response = true;
        } catch (\Exception$ex) {
            \Log::info("Error while sending email: " . $ex->getMessage() . " LINE: " . $ex->getLine());
            $response = false;
        }

        return $response;
    }

    protected function getInnerTabToRedirect($targetType) {
        return $targetType == CNST::TIME_BASED_PROJECT ? "time-based-tab" : "target-based-tab";
    }
    protected function _get_post_child($post, $parentId,$slug) {
        $postArr = [];

        if (empty($post) || !isset($post)) {
            return false;
        }

        foreach ($post['title'] as $key => $postData) {
            if (!empty($post['title'][$key])) {
                $temp = [];
                $temp['post']['post_title'] =$post['title'][$key];
                 $temp['post']['post_title_arabic'] = $post['title_arabic'][$key];
                $temp['post']['post_type'] = $slug . '_child';
                $temp['post']['post_parent_id'] = $parentId;
                $temp['post']['post_entity_id'] = (!empty($post['entity_id']) && $post['entity_id'][$key])?$post['entity_id'][$key]:null;
                $temp['post']['post_room_type'] = (!empty($post['room_type']) && $post['room_type'][$key])?$post['room_type'][$key]:null;
                $temp['post']['post_created_by'] = auth()->user()->id;
                $temp['post']['post_updated_by'] = auth()->user()->id;
                $temp['post']['post_status'] = 1;

                $temp['postMeta'] = $this->_get_child_meta_data($post, $key);
                $postArr[] = $temp;
            }
        }

        return $postArr;
    }
    /**
     * creating child post meta data.
     * @param Illuminate\Http\Request $request
     * @param string $arrIndex
     * @return Array  $postMetaArrResult
     */
    private function _get_child_meta_data($post, $arrIndex) {

        $postMetaArr = [];
        $postMetaArrResult = [];
        $arrayKeys = [];
        if (empty($post['meta']) || !isset($post['meta'])) {
            return false;
        }

        foreach ($post['meta'] as $key => $postData) {

            if ($key == 'date') {

                foreach ($postData as $key1 => &$val1) {
                    $val1 = Carbon::parse($val1)->format($this->postDateFormat);
                    $postData[$key1] = $this->_getCarbonObject($val1, $this->postDateFormat);
                }

            }

            $postMetaArr[] = $postData;
        }

        $postMetaArr = Arr::collapse($postMetaArr);

        $array_keys = array_keys($postMetaArr);

        foreach ($array_keys as $metaKey) {
            if (isset($postMetaArr[$metaKey][$arrIndex])) {
                $postMetaArrResult[$arrIndex][$metaKey] = $postMetaArr[$metaKey][$arrIndex];
            }

        }

        return Arr::collapse($postMetaArrResult);
    }
}