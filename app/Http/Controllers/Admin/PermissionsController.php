<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\AdminBaseController;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Gate;
// use App\Http\Controllers\Controller;
// use App\Http\Requests\Admin\StorePermissionsRequest;
// use App\Http\Requests\Admin\UpdatePermissionsRequest;
use Config; // Date formatting class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Admodels\PostModel;

class PermissionsController extends AdminBaseController {
	/**
	 * Display a listing of Permission.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __construct(Request $request) {

		parent::__construct($request);
		$this->module = 'Permission';
	}

	public function index(Request $request) {

		if (!$this->checkPermission('List')) {
			return $this->returnInvalidPermission($request);
		}
		$this->data['permissions'] = Permission::when($request->input('name'), function ($q) use ($request) {
			$q->where('name', 'LIKE', '%' . $request->input('name') . '%');
		})
			->orderBy('name', 'ASC')
			->paginate(100);

		return view('admin.permissions.index', $this->data);
	}

	/**
	 * Show the form for creating new Permission.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		if (!$this->checkPermission('Add')) {
			return $this->returnInvalidPermission($request);
		}
		if ($request->isMethod('post')) {
			try {
				Permission::create($request->all());
				$message = '<div class="alert alert-success">' . lang('permission_created') . '</div>';
			} catch (PermissionAlreadyExists $e) {
				$message = '<div class="alert alert-danger">' . lang('cant_create_permission_already_exists') . '</div>';
			}
			return Redirect(apa('permissions/create'))->with('userMessage', $message);
		}

		return view('admin.permissions.create', $this->data);
	}

	/**
	 * Show the form for editing Permission.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id, Request $request) {
		if (!$this->checkPermission('Edit')) {
			return $this->returnInvalidPermission($request);
		}
		if ($request->isMethod('post')) {
			try {
				
				$permission = Permission::findOrFail($id);
				$permission->update($request->all());
				$message = lang('permission_updated');
			} catch (PermissionAlreadyExists $e) {
				$message = '<div class="alert alert-danger">' . lang('cant_save_permission_already_exists') . '</div>';
			}
			return Redirect(apa('permissions/edit/' . $id))->with('userMessage', $message);
		}

		$this->data['permission'] = Permission::findOrFail($id);

		return view('admin.permissions.edit', $this->data);
	}

	/**
	 * Update Permission in storage.
	 *
	 * @param  \App\Http\Requests\UpdatePermissionsRequest  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	// public function update($id, Request $request) {
	// 	if (!$this->checkPermission('Edit')) {
	// 		return $this->returnInvalidPermission($request);
	// 	}
	// 	$permission = Permission::findOrFail($id);
	// 	$permission->update($request->all());

	// 	return redirect()->to(Config::get('app.admin_prefix') . '/permissions/edit/' . $id)->with('userMessage', 'Permission deleted');
	// }

	/**
	 * Remove Permission from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete(Request $request, $id) {
		//       if(!$this->checkPermission('Delete')){
		// 	return $this->returnInvalidPermission($request);
		// }
		$permission = Permission::findOrFail($id);
		$permission->delete();
		$userMessage = '<div class="alert alert-success">' . lang('permission_deleted') . '</div>';
		return redirect()->to(Config::get('app.admin_prefix') . '/permissions')->with('userMessage', $userMessage);
	}

	/**
	 * Delete all selected Permission at once.
	 *
	 * @param Request $request
	 */
	private function massDestroy(Request $request) {
		/* if (! Gate::allows('Manage Permissions')) {
			            return redirect()->to(Config::get('app.admin_prefix').'/dashboard')->with('errorMessage','Invalid request. Insufficient privileges');
		*/

		if ($request->input('ids')) {
			$entries = Permission::whereIn('id', $request->input('ids'))->get();

			foreach ($entries as $entry) {
				$entry->delete();
			}
		}
	}
	public function generate_permissions(){
        $posts=PostModel::distinct('post_type')->select('post_type')->get();
		$data=[];
		foreach($posts as $post){
			$module= str_replace('-',' ',$post->post_type);
			$module= ucwords(str_replace('_',' ',$module));
			$list=[
				['name'=>'Manage '.$module],
				['name'=>'Add '.$module],
				['name'=>'Edit '.$module],
				['name'=>'Delete '.$module]
			];
			foreach($list as $item){
				
				try {
					Permission::create($item);
				} catch (PermissionAlreadyExists $e) {
					//
				}
			}
			
		}
		$userMessage=$this->custom_message('Permission Generated','success');
		return redirect()->back()->with('userMessage', $userMessage);
	}

}
