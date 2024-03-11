<?php 
namespace App\Traits\Admin;
use App;


trait ModelFilterTrait{
	
	function scopefilter($mainQueryObj, $request = null,$callBackFilter = null){
		
		$userFilters = self::$filters['filters'];
		
		foreach($userFilters as $userFilter){
			
			$searchTerm = (!empty($userFilter['inputName']))?$request->input($userFilter['inputName']):$request->input($userFilter['field']);
			
			$searchTerm = (strtolower($userFilter['operation'])=='like')? '%'.$searchTerm.'%':$searchTerm;
			
			if(!empty($searchTerm)){
			
				if(!empty($userFilter['relation'])){
					$mainQueryObj->whereHas($userFilter['relation'],function ($query) use ($userFilter , $searchTerm) {
						$query->where($userFilter['field'],$userFilter['operation'],$searchTerm);
					});
				}elseif($userFilter['type'] == 'date'){
					$mainQueryObj->whereRaw(' DATE('.$userFilter['field'].') '.$userFilter['operation']. '"'.$searchTerm.'"' );
				}elseif($userFilter['type'] == 'datetime'){
					$mainQueryObj->whereRaw(' '.$userFilter['field'].' '.$userFilter['operation']. '"'.$searchTerm.'"' );
				}else{
					$mainQueryObj->where($userFilter['field'],$userFilter['operation'],$searchTerm);
				}
			}
			
			
		}
		
	}
	
	public static function getModelFilterDom($request){
		$userFilters = self::$filters['filters'];
		
		$domFilters = [];
		
		foreach($userFilters as $userFilter){
			// $field = (!empty($userFilter['inputName']))?$request->input($userFilter['inputName']):$request->input($userFilter['field']);
			
			
			
			if(!empty($userFilter['dataManager'])){
				$modelName = (!empty($userFilter['dataManager']['source']))?$userFilter['dataManager']['source']:false;

				$domFilters[$userFilter['inputName']] =   [
											'type'=> $userFilter['type'],											
											'key' => 	(!empty($userFilter['dataManager']['key']))?$userFilter['dataManager']['key']:null,
											'value' => 	(!empty($userFilter['dataManager']['value']))?$userFilter['dataManager']['value']:null,
											'title' => 	(!empty($userFilter['dataManager']['title']))?$userFilter['dataManager']['title']:null,
											'class' => 	(!empty($userFilter['dataManager']['class']))?$userFilter['dataManager']['class']:'',
										];
				if($modelName){
					if(is_array($modelName)){ //if custom array data is passed
						$domFilters[$userFilter['inputName']]['data'] = array_to_object($modelName);
					}
					else{
						
						$domFilters[$userFilter['inputName']]['data'] = $modelName::all();
						
					}
				}	
				$modelName = null;
			}
		}
		$data['filters'] = $domFilters;
		$data['resetURL'] = self::$filters['resetURL'];
		
		
		return view('admin.common.model_filter_dom',$data)->render();
	}
	
}