<?php
namespace App\Models\Admodels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App;
use App\Models\CountryModel;
use App\Models\EventScheduleModel;
use App\Models\Extension\BaseAppModel;
use App\Traits\DataTrait;
use App\Traits\MenuTrait;
use App\Traits\PGSMediaTrait;
use App\Traits\PGSMetable;
use Cviebrock\EloquentSluggable\Sluggable;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use \Venturecraft\Revisionable\RevisionableTrait;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PostModel extends Model implements AuditableContract {

	use HasFactory,Sluggable, \OwenIt\Auditing\Auditable;
	use RevisionableTrait, MenuTrait;
	use PGSMetable, DataTrait, PGSMediaTrait, SoftDeletes;

	protected $table = 'posts';

	protected $primaryKey = 'post_id';

	protected $with = ['meta'];

	protected $revisionEnabled = true;

	protected $revisionCreationsEnabled = true;

	protected $historyLimit = 50;

	protected $fillable = [
		'post_slug',
		'post_type',
		'post_parent_id',
		'post_category_id',
		'post_sub_category_id',
		'post_title',
		'post_title_arabic',
		'post_image',
		'post_image_arabic',
		'post_priority',
		'post_set_as_banner',
		'post_created_by',
		'post_updated_by',
		'post_status',
		'post_lang',
		'deleted_at',
	];

	const CREATED_AT = 'post_created_at';

	const UPDATED_AT = 'post_updated_at';

	public function sluggable(): array {
		return [
			'post_slug' => [
				'source' => 'slugname',
			],
		];
	}
	public function getSlugnameAttribute(): string {
		$post_title = "";
		$post_title_arabic = "";
		if ($this->post_slug) {
			$this->post_slug = strip_tags($this->post_slug);
			$this->post_slug = SlugService::createSlug(PostModel::class, 'post_slug', $this->post_slug);
		}
		if ($this->post_title) {
			$post_title = strip_tags($this->post_title);
			$post_title = SlugService::createSlug(PostModel::class, 'post_slug', $post_title);
		}

		if ($this->post_title_arabic) {
			$post_title_arabic = strip_tags($this->post_title_arabic);
			$post_title_arabic = SlugService::createSlug(PostModel::class, 'post_slug', $post_title_arabic);
		}

		$newSlug = !empty(strip_tags($this->post_slug)) ? strip_tags($this->post_slug) :
		((!empty(strip_tags($post_title)) && strlen(strip_tags($post_title)) > 2) ? strip_tags($post_title) : strip_tags($post_title_arabic));

		return (empty($newSlug)) ? md5(now()) : $newSlug;

	}
	public function getRemoveTagsAttribute() {
		return strip_tags($this->post_title);
	}

	public function scopeMenu($query) {
		return $query->where('post_type', 'menu');
	}

	public function scopeActive($query) {
		return $query->where('post_status', 1);
	}

	public function scopeInActive($query) {
		return $query->where('post_status', 2);
	}

	public static function boot() {
		parent::boot();
	}

	function isActive() {
		return ($this->post_status == 1);
	}

	public function category() {
		return $this->hasOne('App\Models\Admodels\CategoryModel', 'category_id', 'post_category_id');
	}

	public function parentPost() {
		return $this->hasOne('\App\Models\Admodels\PostModel', 'post_id', 'post_parent_id');
	}

	public function childPosts() {
		return $this->hasMany('\App\Models\Admodels\PostModel', 'post_parent_id', 'post_id');
	}
	public function subMenu() {
		return $this->hasMany('\App\Models\Admodels\PostModel', 'post_parent_id', 'post_id')->active()->where('post_type','menu')->orderBy('post_priority', 'asc');
	}
	
	


	public function childPostsById($postId) {
		return $this->childPosts->where('post_parent_id', '=', $postId);
	}

	public function imageGallery() {
		$lang = (App::getLocale() == "en") ? 'ar' : 'en';

		$tmp = $this->hasMany('\App\Models\Admodels\PostMediaModel', 'pm_post_id', 'post_id')
			->whereNotNull('pm_post_id')
			->where('pm_cat', '=', 'gallery_file');

		if (!empty(\Auth::user()) && \Auth::user()->isAdmin()) {

		} else {
			$tmp = $tmp->where(function ($q) use ($lang) {
				$q->where('pm_lang', '!=', $lang);
				$q->orWhereNull('pm_lang');
			});
		}

		return $tmp->where('pm_status', '=', 1)
			->orderBy('pm_priority', 'ASC');
	}

	public function videoGallery() {
		$lang = (App::getLocale() == "en") ? 'ar' : 'en';

		$tmp = $this->hasMany('\App\Models\Admodels\PostMediaModel', 'pm_post_id', 'post_id')
			->whereNotNull('pm_post_id')
			->where('pm_cat', '=', 'video');
		if (!empty(\Auth::user()) && \Auth::user()->isAdmin()) {
		} else {
			$tmp = $tmp->where(function ($q) use ($lang) {
				$q->where('pm_lang', '!=', $lang);
				$q->orWhereNull('pm_lang');
			});
		}

		return $tmp->where('pm_status', '=', 1)
			->orderBy('pm_priority', 'ASC');
	}

	public function media() {

		$lang = (App::getLocale() == "en") ? 'ar' : 'en';

		$tmp = $this->hasMany('\App\Models\Admodels\PostMediaModel', 'pm_post_id', 'post_id')->whereIn('pm_cat', ['gallery_file', 'video']);

		if (!empty(\Auth::user()) && \Auth::user()->isAdmin()) {
		} else {
			$tmp = $tmp->where(function ($q) use ($lang) {
				$q->where('pm_lang', '!=', $lang);
				$q->orWhereNull('pm_lang');
			});
		}
		return $tmp->where('pm_status', '=', 1)
			->orderBy('pm_priority', 'ASC');
	}
	

	function getTitle() {
		return $this->getData('post_title');
	}

	function getSlug() {
		return $this->post_slug;
	}

	function getId() {
		return $this->post_id;
	}

	function getPostFilePath($field = 'none.file') {
		$path = null;
		if (\File::exists(storage_path('app/public/post/') . $field)) {
			$path = storage_path('app/public/post/') . $field;
		}
		return $path;
	}

	

	

	function seoData(){
		return $this->hasOne('\App\Models\Admodels\PostModel','post_seo_parent_id','post_id')
		            ->where('post_type','page-seo')
					->active();
	}
	function getSeo()
	{
		
		if(!empty($this->seoData)){
			$this->data['page_seo']=$this->seoData;
			$seoTags = view('frontend.partials.seo', $this->data)->render();						
			return $seoTags;
		}	
	}
	public function getmedia() {
		return $this->belongsTo('\App\Models\Admodels\PostMediaModel','post_id' ,'pm_post_id');
	}
}