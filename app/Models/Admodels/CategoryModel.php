<?php

namespace App\Models\Admodels;
use App\Traits\DataTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use \Venturecraft\Revisionable\RevisionableTrait;

class CategoryModel extends Model implements AuditableContract {

	use DataTrait, Sluggable, RevisionableTrait, \OwenIt\Auditing\Auditable;

	use SoftDeletes;

	protected $table = 'category_master';

	protected $primaryKey = 'category_id';

	protected $parent = 'category_parent_id';

	protected $dates = ['deleted_at'];

	protected $with = [];

	protected $fillable = [
		'category_parent_id',
		'category_title',
		'category_title_arabic',
		'category_slug',
		'category_created_at',
		'category_updated_at',
		'category_created_by',
		'category_updated_by',
		'category_status',
		'category_priority',
	];

	const CREATED_AT = 'category_created_at';

	const UPDATED_AT = 'category_updated_at';

	public function sluggable(): array {
		return [
			'category_slug' => [
				'source' => 'category_title',
			],
		];
	}
    public function getId() {
		return $this->getData('category_id');
	}
	public function getTitle() {
		return $this->getData('category_title');
	}

	public function scopeActive($query) {
		return $query->where('category_status', 1);
	}
	public function councilMember()
	{
		return $this->hasMany('\App\Models\Admodels\PostModel', 'post_category_id', 'category_id')->where('post_type','council-members')->orderBy('post_priority','asc');
	}
	public function parentCategory()
	{
		return $this->hasOne('\App\Models\Admodels\CategoryModel', 'category_id', 'category_parent_id');
	}

	public function scopeInActive($query) {
		return $query->where('category_status', 2);
	}

}