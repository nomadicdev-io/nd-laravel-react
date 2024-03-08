<?php
namespace App\Traits;
use App;
use App\Models\Admodels\PostModel;
use Jenssegers\Agent\Agent;

trait MenuTrait {

	protected $data = [];
	protected $dom = '';
	protected $elementsTotal = 0;

	protected $frontendConfig;
	protected $activeMenu;

	// public function __construct(){
	// 	$this->data['agent'] = new Agent();
	// }
	/*
	* ADMIN MENU DROPDOWN
	* Creates a <select> tag with menu items
	* @args Object
	* @return $this
	*/
	public function createMenuDropdown($menuItems, $editingItem = null) {

		foreach ($menuItems as $menu) {

			$this->dom .= $this->generateDropDom($menu, $editingItem);
			if ($menu->childPosts && $menu->childPosts->count() > 0) {
				$this->elementsTotal += 1;
				$this->createMenuDropdown($menu->childPosts);
			}
		}
		return $this;
	}

	/*
		* ADMIN MENU DROPDOWN
		* Creates a <option> tags with menu items
		* @args Object
		* @return String
	*/
	private function generateDropDom($menu, $editingItem) {
		$this->data['elementsTotal'] = $this->elementsTotal;
		$this->data['menu'] = $menu;
		$this->data['dom'] = $this->dom;
		$this->data['editing_item'] = $editingItem;

		return View('admin.menu.partials.dropdown', $this->data)->render();
	}

	/*
		* ADMIN MENU DRAG N DROP
		* Creates a <ol> tags with menu items
		* @args Object
		* @return $this
	*/

	public function createNestableDom($menuItems) {

		foreach ($menuItems as $menu) {

			$this->dom .= $this->generateNestableDom($menu);
			if ($menu->childPosts && $menu->childPosts->count() > 0) {
				$this->elementsTotal += 1;
				$this->dom .= '<ol class="dd-list">';
				$this->createNestableDom($menu->childPosts);
				$this->dom .= '</ol>';
			}
		}

		return $this;
	}

	/*
		* ADMIN MENU DRAG N DROP
		* Creates a <ul><li> tags with menu items
		* @args Object
		* @return String
	*/
	private function generateNestableDom($menu) {
		$this->data['elementsTotal'] = $this->elementsTotal;
		$this->data['menu'] = $menu;
		$this->data['dom'] = $this->dom;
		return View('admin.menu.partials.nestable', $this->data)->render();
	}

	/*
		* FRONTEND MENU
		* Creates a <ul><li> tags with menu items
		* @args Object
		* @return MenuTrait::class
	*/
	function createFrontendMenu($menuItems) {

		foreach ($menuItems as $menu) {

			$this->dom .= $this->generateBootstrapDom($menu);
			if ($menu->childPosts && $menu->childPosts->count() > 0) {
				$this->elementsTotal += 1;
				$this->createFrontendMenu($menu->childPosts);
				
			}
		}
		$this->injectStaticMenus($menuItems);
		return $this;
	}

	/*
		* fetch menu items from DB and render createFrontendMenu()
		* This is a shorthand for createFrontendMenu
		* @args null
		& @return MenuTrait::class
	*/
	function setFrontendMenu() {
		$menuItems = \Cache::rememberForEver('frontend_menu', function () {
			return PostModel::where('post_type', 'menu')->where('post_status', 1)->orderBy('post_priority')->get();
		});

		return $this->createFrontendMenu($menuItems);
	}
	/*
		* Inject any static mobile menus
		* This is a shorthand for createFrontendMenu
		* @args Request $request
		& @return MenuTrait::class
	*/
	function injectStaticMenus($request) {
		$lang = \App::getLocale();
		//$lang = 'en';
		$displayLang=($lang == "en") ? "ع" : "EN" ;
		$switchLang  = ($lang == 'en') ? 'ar' : 'en' ; 
		$this->dom .= '<li class="no_hide">
          <a class="lang_ " href="'. route("set_language" , $switchLang ) .'"  title=""><span>'.$displayLang.'</span></a>
        </li>';
		
		
		

		return $this;
	}

	public function setFrontendConfig($data) {
		$this->frontendConfig = $data;
		return $this;
	}

	public function setActive($item) {
		$this->activeMenu = $item;
		return $this;
	}

	/*
		* FRONTEND MENU
		* Creates DOM with menu items
		* @args Object
		* @return String
	*/
	private function generateBootstrapDom($menu) {
		$this->data['elementsTotal'] = $this->elementsTotal;
		$this->data['menu'] = $menu;
		$this->data['dom'] = $this->dom;
		$this->data['config'] = $this->frontendConfig;
		$this->data['active'] = $this->activeMenu;
		return View('frontend.menu.partials.menu', $this->data)->render();
	}

	/*
		* render the whole html with all the closing tags
		* using php tidy extension
	*/
	public function closeTags() {
		try {
			$return = $this->dom;
			if (!empty($this->dom)) {
				$x = new \DOMDocument;
				@$x->loadHTML(mb_convert_encoding($this->dom, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
				$return = ($x->saveXML($x->documentElement));
			}
			return $return;
		} catch (Exception $e) {
			die('DOMDocument');
		}
	}
}
?>
