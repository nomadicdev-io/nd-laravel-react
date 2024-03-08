<?php
namespace App\Traits;

use App;
use Carbon\Carbon;
trait DataTrait
{
    protected $workshopRegistrationCount = 0;
    function getData($field)
    {
		
        $data = '';
        try {
            $dataDefault = $this->$field;
            if (empty($dataDefault)) {
                $dataDefault = $this->getMeta($field);
            }
            switch (App::getLocale()) {
                case 'en':
                    $data = $this->$field;
                    if (empty($data)) {
                        $data = $this->getMeta($field);
                    }
                    break;
                
                case 'ar':
                    $field = str_replace(['_ar','_en','_arabic','_english'], '', $field);
                    
                    $data = isset($this->{$field.'_arabic'}) ? $this->{$field.'_arabic'} : (isset($this->{$field.'_ar'}) ? $this->{$field.'_ar'} : ((isset($this->{$field})?$this->{$field}:'')));
                    
                    if (empty($data)) {
                        $data = ($this->hasMeta($field.'_arabic')) ? $this->getMeta($field.'_arabic') : (($this->hasMeta($field.'_ar')) ? $this->getMeta($field.'_ar') : '');
                    }
                    break;
            }
        } catch (\Exception $e) {
        }
         return (empty($data)) ? trim($dataDefault) : trim($data);
    
    }
    
    
    function formatDate($field, $format = 'M d Y')
    {
		
		return Carbon::parse($this->getData($field))->format($format);
		
    }
	
    function formatTime($field)
    {
       if($this->getData($field)){
			$timeWithoutDN =  date('h:i',strtotime($this->getData($field)));
			$amPm =  date('A',strtotime($this->getData($field)));
			return $timeWithoutDN.' '.trans('messages.'.$amPm);
		}
    }
    
    function getAvatar($field)
    {

        return (empty($this->$field)) ? asset('assets/frontend/images/user-avatar.svg/') : asset('storage/app/public/uploads/user_avatar/'.$this->$field);
    }
    
    
    function getPostImage($field, $sub = '')
    {
        $image=(!empty($this->getData($field)))?$this->getData($field):'default_image.jpg';
        return asset('storage/app/public/post/'.((!empty($sub))?$sub.'/':$sub).$image);
    }
    
    function getGalImage($field, $sub = '')
    {
        $image=(!empty($this->getData($field)))?$this->getData($field):'default_image.jpg';
        return asset('storage/app/public/uploads/gallery/'.((!empty($sub))?$sub.'/':$sub).$image);
    }
	
	/*
	|*----------------------------------Application Specific methods 
	|*----------------------------------Will be removed without notice
	*/
	
	
	/*
	* Function to get Icon Class based on workshop format
	* @arg String
	* @return String
	*/
	function getIconClass($format)
	{
		$icon = '';
		if(!empty($format))
		{
			
			switch($format){
				case 'presentation':
					$icon = 'icon-icon-presentation';
				break;
				case 'workshop':
					$icon = 'icon icon-icon-workshop';
				break;
				case 'panel':
					$icon = 'icon icon-icon-panel';
				break;
				default :
					$icon = 'icon-icon-presentation';
				break;
			}
		}
		return $icon;
	}	
	
	/*
	* Function to check if a user can register or not
	* return Boolean
	*/
	function canRegister()
	{
		$register = true;

		if($this->getData('registration_status') == 2 || $this->getData('type') == 'walkin')
		{
			$register = false;
		}
		else if($this->getData('type') == 'private' && (request()->input('token') != $this->getMeta('private_token')) )
		{
			$register = false;
		}
		else
		{
			$totalAllowedReg = (int)$this->getData('original_capacity') + (int)$this->getData('waitinglist_capacity') ;
			$register =  ($this->getWorkshopRegistrationCount() < $totalAllowedReg) ? true : false;
		}
		
		return $register;
	}
	
	/*
	* Function to return total workshop registration count
	* return Int
	*/
	function getWorkshopRegistrationCount(){
		return ($this->workshopRegistrationCount) ? $this->workshopRegistrationCount : $this->workshopRegistration()->count();
	}
	
	/*
	* Function to return Workshop Language
	* return String
	*/
	function getLanguage(){
		if($this->getData('language') == 'both'){
			$lang = trans('messages.english').', '.trans('messages.arabic');
		}else{
			$lang = trans('messages.'.$this->getData('language'));
		}
		return $lang;
	}
	
	/*
	* Function to return Workshop Dates
	* return String
	*/
	function getFormattedDate(){
		 return $this->formatDate('date_from').' '.( ($this->getMeta('date_to')) ? ' - '.$this->formatDate('date_to') : '' );
	}
	
	/*
	* Function to return Workshop Timings
	* return String
	*/
	function getFormattedTime(){
		 return $this->formatTime('start_time').' '.( ($this->formatTime('end_time')) ? ' - '.$this->formatTime('end_time') : '');
	}
}
