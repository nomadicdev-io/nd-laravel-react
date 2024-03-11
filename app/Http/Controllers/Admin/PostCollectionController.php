<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\Admodels\CategoryModel;
use App\Models\Admodels\PostMediaModel;
use App\Models\Admodels\PostModel;
use App\Models\CountryModel;
use Cache;
use Config;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Validator;

class PostCollectionController extends AdminBaseController {

    protected $postType;
    protected $postDateFormat = 'm/d/Y';

    private $inputs = [];
    private $rules = [];
    private $messages = [];
    private $myValidator = [];
    private $validatorErrorMsgs;
    private $slugText = 'Post';
    private $singlePost = false;
    private $parentType = false;
    private $sorting;
    private $listing;
    private $filters;

    protected $roleName;
    protected $module;
    protected $hasYoutubeGallery = false;
    protected $hasGallery = false;

    public function __construct(Request $request) {

        parent::__construct($request);

        if ($this->requestSlug) {

            $this->_set_post_basic_settings($this->requestSlug, $request);
        }
        $slug = ucwords(str_replace(['_', '-'], ' ', $this->requestSlug)) . ' Manager';

        $this->module = ucwords(str_replace(['_', '-'], ' ', $this->requestSlug));
        $this->roleNames = ['Super Admin', $slug];
        $this->data['countryList'] = CountryModel::active()->get();
    }
    /**
     * form validations
     * @param String $slug
     * @param Object $request
     * @return Object $validator
     */
    private function _set_post_validations($slug, $request) {
        $this->rules = [
            'post.title' => 'required',
        ];

        $this->messages = [
            'post.title.required' => 'Title is required',
            'post.title_arabic.required' => 'Arabic Title is required',
            'post.status.required' => 'Status is required',
        ];

        $slugRules = [];
        $slugMessages = [];

        switch ($slug) {
            case 'events':
                $this->postDateFormat = 'm/d/Y H:i';
                break;
        }

        $this->rules = array_merge($this->rules, $slugRules);
        $this->messages = array_merge($this->rules, $slugMessages);
        return (!empty($this->messages)) ? $request->validate($this->rules, $this->messages) : $request->validate($this->rules);
    }

    /**
     * post collection basic configurations like action (edit,delete ...) and gallery
     * @param String $slug
     * @param Object $request
     * @return Array
     */
    private function _set_post_basic_settings($slug, $request) {

        if (empty($slug)) {
            return false;
        }

        $this->data['postType'] = $slug;
        $this->data['hasGallery'] = false;
        $this->buttons = ['add' => true, 'edit' => true, 'delete' => false, 'status' => true];
        $this->hasGallery = true;
        $this->singlePost = false;
        $this->hideGalleryLang = false;
        $this->hideGalleryText = false;
        $this->hideGallerySource = false;

        $adminViewSettings = \Config::get('pgsadminviewsettings');

        if ((!empty($adminViewSettings[$slug]))) {

            if (!empty($adminViewSettings[$slug]['buttons'])) {
                foreach ($this->buttons as $key => $value) {
                    if (isset($adminViewSettings[$slug]['buttons'][$key])) {
                        $this->buttons[$key] = $adminViewSettings[$slug]['buttons'][$key];
                    }
                }
            }

            $this->hasGallery = (!empty($adminViewSettings[$slug]['hasGallery'])) ? $adminViewSettings[$slug]['hasGallery'] : false;
            $this->singlePost = (!empty($adminViewSettings[$slug]['singlePost'])) ? $adminViewSettings[$slug]['singlePost'] : false;
            $this->hideGalleryLang = (!empty($adminViewSettings[$slug]['hideGalleryLang'])) ? $adminViewSettings[$slug]['hideGalleryLang'] : false;
            $this->hideGalleryText = (!empty($adminViewSettings[$slug]['hideGalleryText'])) ? $adminViewSettings[$slug]['hideGalleryText'] : false;
            $this->hideGallerySource = (!empty($adminViewSettings[$slug]['hideGallerySource'])) ? $adminViewSettings[$slug]['hideGallerySource'] : false;

            if (!empty($adminViewSettings[$slug]['sorting'])) {
                $this->sorting = $adminViewSettings[$slug]['sorting'];
            }

            if (!empty($adminViewSettings[$slug]['listing'])) {
                $this->listing = $adminViewSettings[$slug]['listing'];
            }

            if (!empty($adminViewSettings[$slug]['filters'])) {
                $this->filters = $adminViewSettings[$slug]['filters'];
            }

        }

        $filterArr = array();
        if (!empty($this->filters)) {
            foreach ($this->filters as $key => $filter) {
                $filterArr[$key]['name'] = $filter['name'];
                $filterArr[$key]['type'] = $filter['type'];
                if (!empty($filter['source'])) {
                    $model = $filter['source']['model']::get();
                    $fieldId = $filter['source']['id'];
                    $fieldName = $filter['source']['name'];
                    foreach ($model as $key1 => $val) {

                        $filterArr[$key]['data'][$key1] = $val->$fieldId;
                        $filterArr[$key]['data'][$key1] = $val->$fieldName;

                    }

                }
            }
        }

        $this->data['hideGalleryLang'] = $this->hideGalleryLang;
        $this->data['hideGalleryText'] = $this->hideGalleryText;
        $this->data['hideGallerySource'] = $this->hideGallerySource;
        $this->data['hasGallery'] = $this->hasGallery;

        $this->data['buttons'] = $this->buttons;
        $this->data['singlePost'] = $this->singlePost;
        $this->data['filters'] = $filterArr;
    }
    /**
     * parent details for post collections
     * @return Array
     */
    private function hasParent() {
        $this->data['categories'] = null;
        if ($this->parentType) {
            $this->data['categories'] = PostModel::where('post_type', $this->parentType)->get();
        }
        return $this->data['categories'];
    }
    /**
     * post collection listing page
     * @param Request $request
     * @param String $string
     * @return Collection $data
     */
    public function index(Request $request, $slug) {
        if (!$this->checkPermission('Manage ' . $this->module)) {

            return redirect()->to(route('admin_dashboard'))->with('userMessage', '<div class="alert alert-danger">Invalid Permission</div>');
        }
        $orderBy = [];
        $orderByMeta = [];
        $searchReq = ['post' => $request->post, 'meta' => $request->meta];

        if ($this->singlePost) {
            $post = PostModel::where('post_type', $slug)->first();

            if ($post) {
                return redirect()->to(route('post_edit', [$slug, $post->post_id]));
            }
            return redirect()->to(route('post_create', [$slug]));
        }

        switch ($slug) {
            case 'news':
                $orderByMeta = ['news_date' => 'DESC'];
                break;
            case 'advisory-boards-members':
                $this->data['board'] = PostModel::where('post_type', 'advisory-boards')->active()->first();
                $orderBy = ['post_priority' => 'ASC'];
                break;
            case 'events':
                $orderByMeta = ['event_date' => 'DESC'];
                break;

            default:
                $orderBy = ['post_priority' => 'ASC'];
                break;
        }
       $postItems = PostModel::where('post_type', '=', $slug)
                     ->when($request->input('post_status'),function($q) use($request){
                        $q->where('post_status',$request->input('post_status'));
                     })
                     ->when($request->input('post_title'),function($q) use($request){
                        $q->where(function ($q) use ($request) {
                            $q->where('post_title', 'LIKE', '%' . $request->input('post_title') . '%')
                                ->orWhere('post_title_arabic', 'LIKE', '%' . $request->input('post_title') . '%');
                        }); 
                     });
        if (!empty($this->filters)) {
            foreach ($this->filters as $filters) {
                $requestName = $filters['name'];
                if (!empty($request->$requestName)) {

                    if (strtolower($filters['operation']) == "like") {

                        foreach ($filters['field'] as $key => $fields) {

                            if ($key == 0) {
                                $postItems->where($fields, $filters['operation'], '%' . $request->$requestName . '%');
                            } else {
                                $postItems->orWhere($fields, $filters['operation'], '%' . $request->$requestName . '%');
                            }
                        }
                    }
                }
            }
        }        
        if (!empty($orderBy)) {
            foreach ($orderBy as $field => $sort) {
                $postItems = $postItems->orderBy($field, $sort);
            }
        }

        if (!empty($orderByMeta)) {
            foreach ($orderByMeta as $field => $sort) {
                $postItems = $postItems->OrderByMeta($field, $sort);
            }
        }

        $postItems = $postItems->paginate(20);

        $this->data['post_items'] = $postItems;

        if (!view()->exists('admin.' . $slug . '.list')) {
            return View('admin.error.errorpage', $this->data);
        }

        return View('admin.' . $slug . '.list', $this->data);

    }
    /**
     * create post page including meta details
     * @param Request $request
     * @param String $slug
     * @return View
     */
    public function create(Request $request, $slug) {

        if (!$this->checkPermission('Add ' . $this->module)) {
            return redirect()->to(route('admin_dashboard'))->with('userMessage', '<div class="alert alert-danger">Invalid Permission</div>');
        }

        if ($this->singlePost) {
            $post = PostModel::where('post_type', $slug)->first();
            if ($post) {
                return redirect()->to(route('post_edit', [$slug, $post->post_id]));
            }
        }

        $this->data['hasPluploader'] = $this->hasPluploader;
        $this->data['hasTextEditor'] = $this->hasTextEditor;
        $this->data['hasPluploader'] = true;
        $this->data['feedDetails'] = '';
        if ($request->input('btnsubmit')) {

            $userInputs = $request->all();
            $this->_set_post_validations($this->requestSlug, $request);

            try {

                $postMetaData = $this->_get_post_meta_data($request);

                DB::beginTransaction();

                $postData = $this->_get_post_data($request);

                $newPost = new PostModel();
                foreach ($postData as $key => $val) {
                    $newPost->{$key} = $val;
                }
                $newPost->save();

                if (!empty($postMetaData)) {
                    $newPost->syncMeta($postMetaData);
                }

                $postMedia = $request->input('postMedia');

                if (!empty($postMedia)) {
                    $updateArr = [];
                    foreach ($postMedia as $key => $media) {
                        $temp = ['pm_post_id' => $newPost->post_id, 'pm_cat' => $key, 'pm_status' => 1];
                        PostMediaModel::whereIn('pm_id', $media)->update($temp);
                    }
                }

                $tags = $request->input('post_tags');
                $finalTags = [];
                if (!empty($tags)) {
                    $tags = array_map('trim', explode(',', $tags));
                    foreach ($tags as $tag) {
                        if (!empty($tag)) {
                            $finalTags[] = $tag;
                        }
                    }
                    $newPost->tag($finalTags);
                }

                //Child posts > Multiple child in one post
                $postChildrens = $request->input('postChild');

                if (!empty($postChildrens)) {
                    $childPostData = $this->_get_child_post_data($request, $newPost->post_id);
                    foreach ($childPostData as $childData) {
                        $childPostArr = $childData['post'];

                        $childPostObj = PostModel::create($childPostArr);
                        if (!empty($childData['postMeta'])) {
                            $childPostObj->syncMeta($childData['postMeta']);
                        }
                    }
                }

                

                DB::commit();

                $this->data['userMessage'] = $this->custom_message($this->slugText . ' saved successfully.', 'success');

            } catch (\Exception$e) {
                $request->flash();
                DB::rollback();
                $message = 'Error occured while saving data.Error : ' . $e->getMessage();
                if ($e->getCode() == 23000) {
                    $message = 'Title already exist, Please enter a different title';
                }
                $this->data['userMessage'] = $this->custom_message($message, 'error');
            }

            $this->clear_cache($slug);

        }

        if (!view()->exists('admin.' . $slug . '.add')) {
            return View('admin.error.errorpage', $this->data);
        }

        if ($slug == 'gallery') {
            $this->data['hasGallery'] = true;
        }

        switch ($slug) {
            case "page-seo":

                $pages = PostModel::select('post_title', 'post_id', 'post_type')
                    ->whereNotIn('post_type', ['menu', 'setting', 'page_seo'])
                    ->active()
                    ->orderBy('post_type', 'asc')
                    ->orderBy('post_title', 'asc')
                    ->get();

                foreach ($pages as $row) {
                    $this->data['pagesArr'][$row->post_type][] = [
                        'id' => $row->post_id,
                        'title' => $row->post_title,
                    ];
                }

                break;
            default:
                //
                break;
        }

        $this->hasParent();
        $this->data['priority'] = PostModel::where('post_type', $slug)->active()->max('post_priority') + 1;
        $this->data['categories'] = CategoryModel::active()->get();

        return View('admin.' . $slug . '.add', $this->data);

    }
    /**
     * post collection edit page with meta details
     * @param Request $request
     * @param String $slug
     * @param Int $editId
     * @return View
     */
    public function edit(Request $request, $slug, $editId) {

        if (!$this->checkPermission('Edit ' . $this->module)) {
            return redirect()->to(route('admin_dashboard'))->with('userMessage', '<div class="alert alert-danger">Invalid Permission</div>');
        }

        $this->data['hasPluploader'] = $this->hasPluploader;
        $this->data['hasTextEditor'] = $this->hasTextEditor;

        if ($request->input('updatebtnsubmit')) {

            $userInputs = $request->all();
            $this->_set_post_validations($this->requestSlug, $request);

            try {

                $postData = $this->_get_post_data($request);

                $postMetaData = $this->_get_post_meta_data($request);

                DB::beginTransaction();
                $postData = $this->_get_post_data($request);
                $postDetails = PostModel::findorfail($editId);

                foreach ($postData as $key => $val) {
                    $postDetails->{$key} = $val;
                }

                $postDetails->save();

                if (!empty($postMetaData)) {
                    $postDetails->syncMeta($postMetaData);
                }

                $postMedia = $request->input('postMedia');

                if (!empty($postMedia)) {

                    $updateArr = [];
                    PostMediaModel::where('pm_post_id', '=', $postDetails->post_id)->update(['pm_status' => 3]);
                    foreach ($postMedia as $key => $media) {

                        $temp = ['pm_post_id' => $postDetails->post_id, 'pm_cat' => $key, 'pm_status' => 1];

                        PostMediaModel::whereIn('pm_id', $media)->update($temp);
                    }
                }

                DB::commit();
                $msg = '';
                $postDetails->refresh();

                if ($postDetails->getMeta('type') == 'private') {
                    $privateUrl = route('workshop_details', ['en', $postDetails->post_slug]) . '?token=' . $postDetails->getMeta('private_token');
                    $msg = '<div class="alert alert-info">Private URL : ' . $privateUrl . '</div>';
                }

                $this->data['userMessage'] = $this->custom_message($this->slugText . ' saved successfully.', 'success') . $msg;

                $this->clear_cache($slug);

                if ($postDetails->post_type == 'setting') {

                    return redirect()->to(apa('post/setting/edit/1'))->with('userMessage', $this->data['userMessage']);
                }

            } catch (\Exception$e) {
                $request->flash();
                DB::rollback();

                $message = '<div class="alert alert-danger">Error occured while saving data.' . $e->getMessage() . '</div>';
                if ($e->getCode() == 23000) {
                    $message = '<div class="alert alert-danger">Title already exist, Please enter a different title</div>';
                }
                $this->data['userMessage'] = $message;
            }

        }

        $this->hasParent();

        if (!view()->exists('admin.' . $slug . '.edit')) {
            return View('admin.error.errorpage', $this->data);
        }

        switch ($slug) {
            case "page-seo":

                $pages = PostModel::select('post_title', 'post_id', 'post_type')
                    ->whereNotIn('post_type', ['menu', 'setting', 'page_seo'])
                    ->active()
                    ->orderBy('post_type', 'asc')
                    ->orderBy('post_title', 'asc')
                    ->get();

                foreach ($pages as $row) {
                    $this->data['pagesArr'][$row->post_type][] = [
                        'id' => $row->post_id,
                        'title' => $row->post_title,
                    ];
                }

                break;
            default:
                //
                break;
        }

        $this->data['postDetails'] = Postmodel::find($editId);

        if (empty($this->data['postDetails'])) {
            return redirect()->to(adminPrefix() . 'post_collection/' . $slug)->with('userMessage', 'Invalid Request.');
        }
        $this->data['categories'] = CategoryModel::active()->get();
        return View('admin.' . $slug . '.edit', $this->data);
    }
    /**
     * change post status
     * @param Request $request
     * @param String $slug
     * @param Int $postId
     * @param Int $currentStatus
     * @return status
     */
    public function changestatus(Request $request, $slug, $postID, $currentStatus) {
        if (!$this->checkPermission('Edit ' . $this->module)) {
            return redirect()->to(route('admin_dashboard'))->with('userMessage', '<div class="alert alert-danger">Invalid Permission</div>');
        }
        $currentStatus = ($currentStatus == 1) ? 2 : 1;
        $currentStatusdatas = array('post_status' => $currentStatus);
        $postObj = PostModel::where('post_id', '=', $postID)->first();
        $postObj->update($currentStatusdatas);
        $this->clear_cache($slug);
        $message = '<div class="alert alert-success">Status changed successfully</div>';

        return redirect()->back()->with('userMessage', $message);
    }
    /**
     * post file upload options
     * @param Request $request
     * @return Json
     */
    public function fileupload(Request $request) {

        if (!$request->file('file')) {
            return response()->json(array('status' => false, 'message' => 'Invalid Request'));
        }

        $file = $request->file('file');
        $slug = $request->input('slug');
        $type = $request->input('controlName');
        if (!empty($this->imageDimensions[$slug]) && $type == "image") {
            $fileName = $this->resize_and_crop_image('file', 'public/post/', $this->imageDimensions[$slug]);
            return response()->json(array('status' => true, 'uploadDetails' => ['fileName' => $fileName]));
        } else {

            list($fileName, $filePath) = $this->store_file('file', 'public/post/');
            return response()->json(array('status' => true, 'uploadDetails' => ['fileName' => $fileName]));
        }

        return response()->json(array('status' => false, 'message' => 'Invalid Request'));
    }

    /**
     * file delete options
     * @param Request $request
     * @return Json
     */
    public function general_filedelete(Request $request, $fileName) {

        return parent::deleteFile($fileName, $request);
    }
    /**
     * file download options
     * @param Request $request
     * @return Json
     */
    public function general_filedownload(Request $request, $fileName) {

        return parent::downloadFile($fileName, $request);
    }
    /**
     * file download options
     * @param Request $request
     * @param String $slug
     * @param Int $id
     * @return redirect
     */
    public function delete(Request $request, $slug, $id) {

        if (!$this->checkPermission('Delete ' . $this->module)) {
            return redirect()->to(route('admin_dashboard'))->with('userMessage', '<div class="alert alert-danger">Invalid Permission</div>');
        }

        if (in_array($slug, ['banner'])) {
            //return redirect()->to(adminPrefix() . 'dashboard')->with('userMessage', 'Invalid Request.');
        }

        $post = PostModel::find($id);

        $message = $this->custom_message('Error deleting ' . $slug, 'error');
        if (!empty($post)) {
            try {
                DB::beginTransaction();
                if ($slug == 'gallery') {
                    $galleryData = DB::table('gallery_images')
                        ->where('gallery_image_type', '=', 1)
                        ->where('gallery_post_id', '=', $post->post_id)
                        ->get();
                    foreach ($galleryData as $galImage) {
                        if (!empty($galImage->gallery_image_name) && File::exists('storage/app/public/uploads/gallery/' . $galImage->gallery_image_name)) {

                            File::delete('storage/app/public/uploads/gallery/' . $galImage->gallery_image_name);
                            File::delete('storage/app/public/uploads/gallery/thumb/' . $galImage->gallery_image_name);
                            File::delete('storage/app/public/uploads/gallery/small/' . $galImage->gallery_image_name);
                            File::delete('storage/app/public/uploads/gallery/large/' . $galImage->gallery_image_name);

                        }
                    }
                }
                $post->delete();
                DB::commit();
                $message = $this->custom_message($this->slugText . ' deleted Successfully', 'success');
            } catch (\Exception$e) {
                DB::rollback();
                $message = $this->custom_message('Error deleting ' . $this->slugText, 'error');
            }
            $this->clear_cache($slug);

            return redirect()->back()->with('userMessage', $message);
        }
        return redirect()->back()->with('userMessage', $message);
    }
    /**
     * Email template
     * @param Request $request
     * @param Int $id
     * @return Json
     */
    public function testMailTemplate(Request $request, $id) {
        $lang = $request->input('langSelected');

        \App::setLocale($lang);

        $template = 'frontend.email_template.mail_template_' . $lang;
        $mailData['to'] = $request->input('emailAddress');

        $mailTemplateContent = PostModel::where('post_type', 'mail-templates')
            ->where('post_id', $id)
            ->first();

        if (!empty($mailTemplateContent)) {
            try {
                $subject = $mailTemplateContent->getData('subject');
                $mailData['subject'] = $subject;
                $mailData['mailContent'] = $mailTemplateContent->getData('description');

                \Mail::send($template, $mailData, function ($message) use ($mailData) {
                    $message->to($mailData['to'])->subject($mailData['subject']);
                });
                $status = true;
                $message = "Mail sent. Please check your email";

            } catch (\Exception$ex) {
                \Log::info('Error while testing email: ' . $ex->getMessage());
                $status = false;
                $message = "Error while testing email";
            }
        } else {
            $status = false;
            $message = "This template does not exist.";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    protected function clear_cache($slug) {
        Cache::forget($slug);
    }
 protected function updateChildData($request,$postId,$dataType)
    {
         $requestData = $request->input($dataType);
         
         $chiledPostType= $dataType.'_child';
         PostModel::where('post_type',$chiledPostType)
                              ->where('post_parent_id',$postId)
                              ->delete();
         if (!empty($requestData)) {
             $postData = $this->_get_post_child($requestData, $postId,$dataType);
             
             foreach ($postData as $childData) {
                 $childPostArr = $childData['post'];

                 $childPostObj = PostModel::create($childPostArr);
                 if (!empty($childData['postMeta'])) {
                     $childPostObj->syncMeta($childData['postMeta']);
                 }
             }
         }

    }
    public function getChild(Request $request, $type)
    {
        $this->data['postid'] ="post".rand();

        switch($type){

            case 'unit_type':
               
                $this->data['room_types']=PostModel::select('post_title', 'post_id', 'post_type')
                                                    ->where('post_type','room-type')
                                                    ->active()
                                                    ->orderBy('post_title', 'asc')
                                                    ->get();
                $child = View('admin.projects.unit_type_tr', $this->data)->render();                        
            break;
            case 'virtual_tour':
                $child = View('admin.projects.virtual_tour_tr', $this->data)->render();                        
            break;
            default:
               $child = View('admin.common.child', $this->data)->render();
            break;
        }
       
        return response()->json([
            'status' => true,
            'child' => $child,
        ]);
    }
    public function sort_post($slug,Request $request){

        try{	
            $postIds=$request->input('ids');
            
            if(!empty($postIds)){
                
                foreach($postIds as $key=>$val){
                    $prio =++$key;
                    PostModel::where('post_type',$slug)
                    ->where('post_id',$val)
                    ->update(['post_priority'=>$prio]);

                }
              
                
            }
            $this->clear_cache($slug);
			return response()->json(['status'=>true,'Menu saved']);
        }catch(Exception $e){
            return response()->json(['status'=>false,'Error']);
        }
    }

}