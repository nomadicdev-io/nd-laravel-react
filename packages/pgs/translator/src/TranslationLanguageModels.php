<?php
namespace Pgs\Translator;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Extension\BaseAppModel;
use Cviebrock\EloquentSluggable\Sluggable;
use \Venturecraft\Revisionable\RevisionableTrait;
use \App\Traits\DataTrait;	
	
class TranslationLanguageModels extends Model
{
	protected $table = 'translator_languages';

	protected $primaryKey = 'id';
	

	protected $fillable = ['locale','name','created_at','updated_at'];
	
	function getId(){
		return $this->id;
	}

}