<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\Admodels\AuditModel;
use App\User as User;
use Auth;
use Config;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Input;
use Redirect;
use Validator;
use View;

class AuditController extends AdminBaseController {

	public function __construct(Request $request) {
		parent::__construct($request);
		// $this->roleNames = ['Super Admin', 'System Administrator'];
	}

	public function index(Request $request) 
	{
		if (!$this->checkPermission('List')) {
			return $this->returnInvalidPermission($request);
		}

		/* $this->data['auditList'] = AuditModel::with('user')
			->orderBy('created_at', 'desc')
			->paginate(30); */

		$this->data['auditList'] = \OwenIt\Auditing\Models\Audit::with('user')
			->orderBy('created_at', 'desc')                
			->paginate(30);	
			/* ->get();	
			dd($this->data['auditList']->toArray());
 */
		return view::make('admin.audit_logs.list', $this->data);
	}

	public function details($id , Request $request)
	{
		$this->data['audit']= \OwenIt\Auditing\Models\Audit::with('user')
		                      ->orderBy('created_at', 'desc') 
							  ->where('id',$id)->first();
		
		return view::make('admin.audit_logs.details', $this->data)->render();

	}

}