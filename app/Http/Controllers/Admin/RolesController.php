<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\User;
use Config;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Validator;

class RolesController extends AdminBaseController {

	protected $roleName;

	public function __construct(Request $request) {
		parent::__construct($request);
		$this->module = 'Role';
	}

	public function index(Request $request) {
		if (!$this->checkPermission('List')) {
			return $this->returnInvalidPermission($request);
		}

		$this->data['roles'] = Role::when($request->input('name'), function ($q) use ($request) {
			$q->where('name', 'LIKE', '%' . $request->input('name') . '%');
		})
			->orderBy('name', 'asc')
			->get();

		return view('admin.roles.index', $this->data);
	}

	private function validateFormFields(Request $request) {
		// $userType = ['sm_type' => $request->input('sm_type')];
		$inputs = [
			'name' => $request->input('rolename'),
		];

		$rules = [
			'name' => 'required',
		];

		$messages = [
			'name.required' => lang('role_name_required'),
		];

		$validator = Validator::make($inputs, $rules, $messages);
		return [$validator, $inputs, $rules, $messages];
	}

	/**
	 * Show the form for creating new Role.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		if (!$this->checkPermission('Add')) {
			return $this->returnInvalidPermission($request);
		}

		if ($request->input('createbtnsubmit')) {

			$userMessages = "";

			list($validator, $inputs, $rules, $messages) = $this->validateFormFields($request);

			if ($validator->fails()) {
				$request->flash();
				$messages = $validator->messages();
				$errors = [];
				foreach ($messages->all() as $message) {
					$errors[] = $message;
				}
				$this->data['errors'] = $errors;
			} else {
				DB::beginTransaction();
				try {
					$newSector = Role::create($inputs);
					$userMessages = lang('role_created');
					$this->data['userMessage'] = $userMessages;
					DB::commit();
				} catch (\Illuminate\Database\QueryException $e) {
					DB::rollBack();
					\Log::info('Exception while creating a role: ' . $e->getMessage());
					$userMessages = $e->getMessage();
					$this->data['errors'][] = $userMessages;
				}
			}
		}
		// $this->data['permissions'] = Permission::get()->pluck('name', 'name');
		return view('admin.roles.create', $this->data);
	}

	/**
	 * Show the form for editing Role.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id, Request $request) {
		if (!$this->checkPermission('Edit')) {
			return $this->returnInvalidPermission($request);
		}

		$role = Role::findOrFail($id);

		if ($request->input('updatebtnsubmit')) {

			$userMessages = "";

			list($validator, $inputs, $rules, $messages) = $this->validateFormFields($request);

			if ($validator->fails()) {
				$request->flash();
				$messages = $validator->messages();
				$errors = [];
				foreach ($messages->all() as $message) {
					$errors[] = $message;
				}
				$this->data['errors'] = $errors;
			} else {
				DB::beginTransaction();
				try {
					$role->fill($inputs)->save();

					$permissions = $request->input('permission') ? $request->input('permission') : [];
					$role->syncPermissions($permissions);

					$userMessages = lang('role_updated');
					$this->data['userMessage'] = $userMessages;
					DB::commit();
				} catch (\Illuminate\Database\QueryException $e) {
					DB::rollBack();
					\Log::info('Exception while editing a role: ' . $e->getMessage());
					$userMessages = $e->getMessage();
					$this->data['errors'][] = $userMessages;
				}
			}
		}

		//Get user with specified id
		$this->data['user'] = User::find(\Auth::user()->id);
		$this->data['permissions'] = Permission::get()->pluck('name', 'name')->toArray();
		$this->data['role'] = $role;

		$rolePermissions = $this->data['role']->permissions()->pluck('name', 'name');
		$this->data['rolePermissions'] = array('-1');

		foreach ($rolePermissions as $role) {
			$this->data['rolePermissions'][] = $role;
		}

		natsort($this->data['rolePermissions']);
		natsort($this->data['permissions']);

		return view('admin.roles.edit', $this->data);
	}

	/**
	 * Remove Role from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete(Request $request, $id) {
		if (!$this->checkPermission('Delete')) {
			return $this->returnInvalidPermission($request);
		}

		$role = Role::findOrFail($id);

		if (empty($role)) {
			return redirect()->to(route('roles-index'))->with('errors', [lang('this_role_does_not_exist')]);
		}

		$role->delete();

		$message = lang('role_deleted');
		return redirect()->to(route('roles-index'))->with('userMessage', $message);
	}

}
