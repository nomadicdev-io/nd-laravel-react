<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\Admodels\PostModel;
use App\Models\User as User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Input;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuController extends PostCollectionController {

	protected $postType = 'menu';
	
	protected $flatTree = null;

	public function __construct(Request $request) {
		$this->requestSlug = $this->postType;
		$this->data['postType'] =$this->postType;
		parent::__construct($request);
	}

	public function index(Request $request, $slug = '') {
		$postModel = new PostModel();
		$menuItems = $postModel->with(['childPosts' => function ($q) {
			$q->orderBy('post_priority', 'asc');
		}])
			->where('post_type', 'menu')
			->where(function ($q) {
				$q->where('post_parent_id', null)
					->orWhere('post_parent_id', 0);
			})
			->orderBy('post_priority', 'asc')
			->get();

		$this->data['menuHTML'] = $postModel->createNestableDom($menuItems)->CloseTags();

		return parent::index($request, $this->postType);
	}

	public function create(Request $request, $slug = '') {
		$postModel = new PostModel();
		$menuItems = $postModel->where('post_type', 'menu')
			->where('post_status', 1)
			->where('post_parent_id', null)
			->get();

		$this->data['menuDropdown'] = $postModel->createMenuDropdown($menuItems)->CloseTags();

		return parent::create($request, $this->postType);
	}

	public function edit(Request $request, $id, $slug = '') {
		$postModel = new PostModel();
		$menuItems = $postModel->where('post_type', 'menu')
			->where('post_status', 1)
			->where('post_parent_id', null)
			->get();

		$this->data['menuDropdown'] = $postModel->createMenuDropdown($menuItems, $id)->CloseTags();
		if ($request->input('updatebtnsubmit')) {
			$all = $request->all();
			if (isset($all['post']['parent_id']) && $all['post']['parent_id'] == '') {
				$all['post']['parent_id'] = null;
				$request->merge($all);
			}
		}

		return parent::edit($request, $this->postType, $id);
	}

	public function delete(Request $request, $id, $slug = '') {

		return parent::delete($request, $this->postType, $id);
	}

	 public function sort_menu(Request $request){

        try{
			if($request->input('menu')){
				$menuList = $request->input('menu');
				
				$menuByParent = $this->flatten_array('', $menuList);
				
				if(!empty($menuByParent)){
					foreach($menuByParent as $parent => $menus){
						$parentToUpdate = ($parent) ? $parent : null;
							PostModel::where('post_type',$this->postType)
								->whereIn('post_id',$menus)
								->update(['post_parent_id'=>$parentToUpdate]);
					}
					
					

					foreach($menuByParent as $parent => $menus){
						foreach($menus as $prio=>$val){
							PostModel::where('post_type',$this->postType)
							->where('post_id',$val)
							->update(['post_priority'=>$prio]);

						}
					}
					
				}
				
			}
  
			return response()->json(['status'=>true,'Menu saved']);
        }catch(Exception $e){
            return response()->json(['status'=>false,'Error']);
        }
    }

	private function flatten_array($parent = '', &$array) {
		foreach ($array as $key => $item) {

			if (!empty($item['children'])) {
				$this->flatTree[$parent][] = $item['id'];
				$this->flatten_array($item['id'], $item['children']);

			} else {
				$this->flatTree[$parent][] = $item['id'];
			}
		}

		return $this->flatTree;

	}
}