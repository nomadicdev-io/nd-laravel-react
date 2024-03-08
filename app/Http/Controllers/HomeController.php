<?php
namespace App\Http\Controllers;

use App;
use App\Models\Admodels\CategoryModel;
use App\Models\Admodels\PostModel;
use App\Models\CountryModel;
use App\Models\EmiratesModel;
use App\Models\Admodels\PostMediaModel;
use App\Models\ContactModel;
use App\Rules\WordCount;
use App\Traits\FormTrait;
use App\Traits\LangSwitcherTrait;
use App\Traits\SegmentLangTrait;
use App\User;
use Cache;
use CNST;
use Illuminate\Http\Request;
use Lang;

class HomeController extends Controller {

	use LangSwitcherTrait, SegmentLangTrait;

	protected $breadcrumbs;
	/**
	 * $data holds all the needed information to display the home screen
	 * @param Array $data
	 */

	/**
	 * Create a new controller instance and inside the middleware sets the application language
	 * either from request url or from session.
	 * @return void
	 */

	public function __construct() {
		parent::__construct();
		$this->_SegmentLangTrait();
	}
	/**
	 * Accept root  or language specific URL of the website and server the home screen
	 *
	 * @param  object  $request
	 * @param  String  $lang
	 * @return View
	 */
	public function index(Request $request, $lang = 'en') 
	{
		
		$this->data['page_title'] = ((!empty($this->data['websiteSettings']))?$this->data['websiteSettings']->getData('post_title'):"" ). ' | ' . lang('home');
		
		$this->data['isMain'] = true;
		$this->data['menuHTML'] = $this->getMenu('home');

		
		$this->data['body_class']="home__page __index";
		return view('frontend.index', $this->data);
	}
   
	/**
	 * 404 page
	 * @param string $lang
	 * @param Request $request
	 * @return view
	 */
	public function pageNotFound(Request $request, $lang = 'en') 
	{
		$this->data['page_title'] = '404 | ' . lang('page_not_found');
		$this->data['body_class'] = "inner__page __page_not_found";
		$this->data['menuHTML'] = $this->getMenu('404');
		return view('frontend.errorPages.error404', $this->data);
	}
	/**
	 * terms conditions page
	 * @param string $lang
	 * @param Request $request
	 * @return view
	 */
	public function terms_conditions(Request $request, $lang = 'en') 
	{
		$this->data['page_title'] = ((!empty($this->data['websiteSettings']))?$this->data['websiteSettings']->getData('post_title'):"") . ' | ' . lang('terms_conditions');
		$this->data['body_class'] = "inner__page __page_not_found";
		$this->data['menuHTML'] = $this->getMenu('terms-conditions');
		$this->data['terms_conditions'] =PostModel::where('post_type','terms-conditions')->active()->first();
		if(!empty($this->data['terms_conditions'])){
			$this->data['seo_content']=$this->data['terms_conditions']->getSeo();
		}
		return view('frontend.home.terms_conditions', $this->data);
	}
	/**
	 * terms conditions page
	 * @param string $lang
	 * @param Request $request
	 * @return view
	 */
	public function privacy_policy(Request $request, $lang = 'en') 
	{
		$this->data['page_title'] = ((!empty($this->data['websiteSettings']))?$this->data['websiteSettings']->getData('post_title'):"") . ' | ' . lang('privacy_policy');
		$this->data['body_class'] = "inner__page __privacy";
		$this->data['menuHTML'] = $this->getMenu('privacy-policy');
		$this->data['privacy_policy'] =PostModel::where('post_type','privacy-policy')->active()->first();
		if(!empty($this->data['privacy_policy'])){
			$this->data['seo_content']=$this->data['privacy_policy']->getSeo();
		}
		return view('frontend.home.privacy_policy', $this->data);
	}

		
}