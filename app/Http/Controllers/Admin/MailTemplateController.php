<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\MailTemplateModel;
use Config;
use DB;
use Illuminate\Http\Request;
use Input;
use Redirect;
use View;

class MailTemplateController extends AdminBaseController {

	protected $roleName;
	public function __construct(Request $request) {
		parent::__construct($request);
		$this->roleNames = ['Super Admin'];
	}

	public function index() {

		if (!$this->userObj->hasAnyRole($this->roleNames)) {
			return Redirect(route('admin_dashboard'))->with('userMessage', 'Invalid Permission');
		} /**/

		$this->data['MailTemplateList'] = MailTemplateModel::orderBy('mt_id', 'desc')
			->paginate(50);
		return View::make('admin.mailtemplate.list', $this->data);
	}

	public function create(Request $request) {

		if (!$this->checkPermission('Manage Mail Template')) {
			return Redirect(route('admin_dashboard'))->with('userMessage', 'Invalid Permission');
		}

		$this->data['messages'] = '';
		if ($request->input('createbtnsubmit')) {

			$insertDatas = array();
			$insertDatas = array(
				'mt_title' => $request->input('mt_title'),
				'mt_subject' => $request->input('mt_subject'),
				'mt_subject_arabic' => $request->input('mt_subject_arabic'),
				'mt_template' => $request->input('mt_template'),
				'mt_template_arabic' => $request->input('mt_template_arabic'),
			);

			MailTemplateModel::create($insertDatas);
			$this->data['userMessage'] = $this->custom_message('Mail Template Added Successfully', 'success');
		}

		return View::make('admin.mailtemplate.add', $this->data);
	}

	public function update($editID, Request $request) {

		if (!$this->checkPermission('Manage Mail Template')) {
			return Redirect(route('admin_dashboard'))->with('userMessage', 'Invalid Permission');
		}

		if (empty($editID)) {
			return redirect()->to(Config::get('app.admin_prefix') . '/mailtemplate');
		}
		$this->data['messages'] = '';
		if ($request->input('updatebtnsubmit')) {

			$this->datasupdate = array(
				'mt_title' => $request->input('mt_title'),
				'mt_subject' => $request->input('mt_subject'),
				'mt_subject_arabic' => $request->input('mt_subject_arabic'),
				'mt_template' => $request->input('mt_template'),
				'mt_template_arabic' => $request->input('mt_template_arabic'),
			);

			$mailtemplate = MailTemplateModel::where('mt_id', '=', $editID)->first();
			$mailtemplate->update($this->datasupdate);
			$this->data['userMessage'] = $this->custom_message('Mail Template updated successfully', 'success');
		}

		$this->data['mailTemplateDetails'] = DB::table('mail_templates')->where('mt_id', '=', $editID)->first();
		return View::make('admin.mailtemplate.edit', $this->data);
	}



	public function delete($deleteID) {

		if (!$this->checkPermission('Manage Mail Template')) {
			return Redirect(route('admin_dashboard'))->with('userMessage', 'Invalid Permission');
		}



		if (empty($deleteID)) {
			return redirect()->to(Config::get('app.admin_prefix') . '/mailtemplate');
		}
		$mailtemplate = MailTemplateModel::where('mt_id', '=', $deleteID)->first();
		$mailtemplate->delete();
		$this->data['messages'] = $this->custom_message('Deleted Successfully', 'success');
		return redirect()->to(Config::get('app.admin_prefix') . '/mail-templates')->with('flash_error', 'deleted');
	}

	public function testMailTemplate(Request $request, $id) {
		$lang = $request->input('langSelected');

		\App::setLocale($lang);

		$template = 'frontend.email_template.mail_template_' . $lang;
		$mailData['to'] = $request->input('emailAddress');

		$mailTemplateContent = MailTemplateModel::where('mt_id', '=', $id)->first();

		if (!empty($mailTemplateContent)) {
			try {
				$subject = $mailTemplateContent->getSubject();
				$mailData['subject'] = $subject;
				$mailData['mailContent'] = $mailTemplateContent->getTemplate();

				\Mail::send($template, $mailData, function ($message) use ($mailData) {
					$message->to($mailData['to'])->subject($mailData['subject']);
				});
				$status = true;
				$message = "Mail sent. Please check your email";

			} catch (\Exception $ex) {
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
}
