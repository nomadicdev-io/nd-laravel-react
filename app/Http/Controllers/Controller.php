<?php

namespace App\Http\Controllers;

use App\Models\Admodels\PostModel;
use App\Models\MailTemplateModel;
use App\Traits\LangSwitcherTrait;
use App\Traits\SegmentLangTrait;
use Auth;
use Cache;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use MacsiDigital\Zoom\Facades\Zoom;

class Controller extends BaseController {

	protected $data = [];

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	use LangSwitcherTrait, SegmentLangTrait;
	public function __construct() {

		$this->middleware(function ($request, $next) {

			//dd($this->data);

			$this->data['websiteSettings'] = Cache::rememberForEver('setting', function () {
				return PostModel::where('post_type', 'setting')->first();
			});
			$this->data['userMessages'] = \Session::get('userMessages');
			$this->data['errorMessages'] = \Session::get('errorMessages');
			//$this->postModel = new PostModel;
			$this->data['styleSheet'] = 'page';
			if (Auth::user()) {
				$this->data['userObj'] = Auth::user();

				/* // Api user token
				if (!Auth::user()->api_token) {
					$token = \App\Http\Controllers\ApiTokenController::update($request);
				} */
			}
			
			return $next($request);
		});

	}
	/**
	 * helper function for post data fetching
	 * @param String $postType
	 * @param String $limit
	 * @param int $paginateCount
	 * @return Collection
	 */
	public function getPost($postType, $limit = "", $paginateCount = 0) {
		$post = PostModel::where('post_type', $postType)->active();
		switch ($limit) {
		case "first":
			return $post->first();
			break;
		case "paginate":
			return $post->orderBy('post_priority', 'asc')->paginate($paginateCount);
			break;
		default:
			return $post->orderBy('post_priority', 'asc')->get();
			break;

		}

	}
	public function getMenu($slug) {
		$postModel = new PostModel();
		
		$menuItems = Cache::rememberForEver('menu', function () use ($postModel) {
			return PostModel::with(['subMenu'])
				->where('post_type', 'menu')
				->where(function ($q) {
					$q->where('post_parent_id', null)
						->orWhere('post_parent_id', 0);
				})
				->active()
				->where('post_status', 1)
				->orderBy('post_priority', 'asc')
				->get();
		});
				  
		$slug = (!empty($slug)) ? $slug : "home";
		
	    $menuhtml =$postModel->setActive($slug)->createFrontendMenu($menuItems)->CloseTags();
		
		return $menuhtml;
	}

	public function adminEnquiryEmails() {
		$adminEmail = $this->data['websiteSettings']->getData('enquiry_send_email');
		$adminEmails = explode(',', $adminEmail);
		foreach ($adminEmails as &$row) {
			$row = trim($row);
		}
		return $adminEmails;

	}
	/**
	 * Sanitize variable
	 * @param String $var
	 * @return String
	 */ 
	protected function _sanitizeVariable($var) {

		return strip_tags($var);
	}
	protected function sendMail($mailObj) {
		extract($mailObj);
		$response = false;

		try {
			$mailPostTemplate = MailTemplateModel::where('mt_slug', $mail_template)
				->first();

			if (empty($mailPostTemplate)) {
				return false;
			}

			$mailDescription = $mailPostTemplate->getData('mt_template');

			foreach ($fieldsToReplace as $key => $value) {
				$mailDescription = str_replace($key, $value, $mailDescription);
			}
           
			$mailData['mailContent'] = $mailDescription;
			$mailData['subject'] =$mailPostTemplate->getData('mt_subject');
			\Mail::send('frontend.email_template.mail_template_' . $lang, $mailData, function ($message) use ($mailData) {
				$message->to($mailData['to'])->subject($mailData['subject']);
			});
			$response = true;
		} catch (\Exception $ex) {
			
			\Log::info("Error while sending email: " . $ex->getMessage() . " LINE: " . $ex->getLine());
			$response = false;
		}

		return $response;
	}
	
}
