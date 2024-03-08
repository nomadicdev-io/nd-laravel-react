<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\AdminBaseController;
use File,Log;

class CustomPostController extends AdminBaseController
{

    public function __construct(Request $request){
		parent::__construct($request);
		$this->module = 'Custom Post';

	}

    public function add(Request $request)
    {

        if($request->post()){
            try{
                 /* $customAdd=$request->input('add_page');
                $customEdit=$request->input('edit_page');  */
               $customAdd=file_get_contents(resource_path('views/admin/custom-post/add.blade.php'));
                $customEdit=file_get_contents(resource_path('views/admin/custom-post/edit.blade.php'));
                $customList=file_get_contents(resource_path('views/admin/custom-post/list.blade.php'));

                $postType=$request->input('form_title');
                $postType=strtolower(str_replace(' ','-',$postType));
                $path=resource_path('views/admin/'.$postType);
                $add=resource_path('views/admin/'.$postType.'/add.blade.php');
                $edit=resource_path('views/admin/'.$postType.'/edit.blade.php');
                $list=resource_path('views/admin/'.$postType.'/list.blade.php');
                mkdir( $path);
                if (!File::exists($add)) {
                    File::put($add,$customAdd);
                }
                if (!File::exists($edit)) {
                    File::put($edit,$customEdit);
                }
                if (!File::exists($list)) {
                File::put($list,$customList);
                }

            } catch (Exception $ex) {
                Log::error($ex->getMessages().' #'.$ex->getLine());
            }

            $userMessage=$this->custom_message('Post Type created','success');
            return redirect()->to(route('post_index',[$postType]))->with('userMessage',$userMessage);
        }
        /*  $this->data['add_page']=file_get_contents(resource_path('views/admin/custom-post/add.blade.php'));
        $this->data['edit_page']=file_get_contents(resource_path('views/admin/custom-post/add.blade.php'));  */
        return view('admin.form_generator.add',$this->data);
    }
    public function tools()
    {



        return view('admin.tools.list',$this->data);
    }



}
