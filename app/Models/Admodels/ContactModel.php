<?php
namespace App\Models\Admodels;

use App;
use App\Traits\DataTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Storage;
use \Venturecraft\Revisionable\RevisionableTrait;
use App\Traits\Admin\FilterTrait;
use Carbon\Carbon;

class ContactModel extends Model implements AuditableContract {

	use  DataTrait,FilterTrait, \OwenIt\Auditing\Auditable;

	protected $table = 'contact_master';

	protected $primaryKey = 'contact_id';

	protected $with = [];

	protected $revisionEnabled = true;

	protected $revisionCreationsEnabled = true;

	protected $historyLimit = 50;

	protected $fillable = [
		'contact_first_name' ,
		'contact_last_name',
		'contact_user_email',
		'contact_number' ,
		'contact_country',
		'contact_type',
		'contact_organization_name',
		'contact_program_interested',
		'contact_subject',
		'contact_message',
	];

	const CREATED_AT = 'contact_created_at';
	const UPDATED_AT = 'contact_updated_at';

	private static $filters = [
		
		'filter_contact_first_name' => ['q' => 'like', 'type' => 'text', 'title' => 'first_name'],
		'filter_contact_last_name' => ['q' => 'like', 'type' => 'text', 'title' => 'last_name'],
		'filter_contact_user_email' => ['q' => 'like', 'type' => 'text', 'title' => 'email'],
		'filter_contact_number' => ['q' => '=', 'type' => 'text', 'title' => 'phone_number'],
		'filter_contact_organization_name' => ['q' => '=', 'type' => 'text', 'title' => 'organization_name'],
		'filter_contact_created_at' => ['q' => 'date_range', 'type' => 'date_range', 'title' => 'date'],
		  
		'filter_getProgramInterested' => [
			'q' => '=',
			'type' => 'select',
			'title' => 'program_interested',
			'model' => [
				'src' => '\App\Models\Admodels\PostModel',
				'title_key' => 'post_title',
				'em_id' => 'main',
				'foreign' => true,
				'sortOrder' => 'asc',
                'post_collection'=>'programs'
			],
        ],
		'filter_getCountry' => [
			'q' => '=',
			'type' => 'select',
			'title' => 'country',
			'model' => [
				'src' => 'App\Models\Admodels\CountryModel',
				'title_key' => 'country_name',
				'em_id' => 'main',
				'foreign' => true,
				'sortOrder' => 'asc',
			],
        ],
		
	];

	public static function boot() {
		parent::boot();
	}

	
	//Getters
	public function getId() {
		return $this->contact_id;
	}

	public function getName() {
		return $this->contact_first_name. " ".$this->contact_last_name;
	}
	public function getEmail() {
		return $this->contact_user_email;
	}
	public function getPhoneNumber() {
		return $this->contact_number;
	}
	
	public function getMessage() {
		return $this->contact_message;
	}
	function getSubject()
	{
		return $this->contact_subject;
	}
	function getCountry()
	{
		return $this->belongsTo('\App\Models\Admodels\CountryModel','contact_country','country_id');
	}
	function getCountryName()
	{
		return (!empty($this->getCountry))?$this->getCountry->country_name:'NIL';
	}
	function getType()
	{
		 return $this->belongsTo('\App\Models\Admodels\PostModel','contact_type','post_id');
	}
	function getTypeTitle()
	{
		return (!empty($this->getType))?$this->getType->post_title:'NIL';
	}
	function getOrganizationName()
	{
		return $this->contact_organization_name;
	}
	function getProgramInterested()
	{
		return $this->belongsTo('\App\Models\Admodels\PostModel','contact_program_interested','post_id');
	}
    function getProgramTitle()
	{
		return (!empty($this->getProgramInterested))?$this->getProgramInterested->post_title:'NIL';
	}
	public function getCreatedAt() {
		return $this->contact_created_at;
	}
	public function getDepartment() {
		return ucwords(str_replace('-',' ',$this->contact_department));
	}

	public function getLastUpdatedAt() {
		return $this->contact_updated_at;
	}
    public function submittedAt() {
		return Carbon::parse($this->contact_created_at)->format('d M Y h:i A');
	}
	public function getHumanReadableCreatedAt() {
		return $this->contact_created_at->diffForHumans(\Carbon\Carbon::now());
	}

	public function getHumanReadableLastUpdatedAt() {
		return $this->contact_updated_at->diffForHumans(\Carbon\Carbon::now());
	}
}