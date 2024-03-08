<?php
namespace Pgs\Translator;

use App\Models\Extension\BaseAppModel;
use Cviebrock\EloquentSluggable\Sluggable;
use DB;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\DataTrait;
use \Venturecraft\Revisionable\RevisionableTrait;

class TranslatorModel extends Model {
	//protected $table = 'translator_translations';
	protected $table = 'ltm_translations';

	protected $primaryKey = 'id';

	// use \Waavi\Translation\Traits\Translatable;
	protected $translatableAttributes = ['text'];
	//protected $fillable = ['text', 'locale', 'namespace', 'group', 'item'];
	protected $fillable = ['status', 'locale', 'group', 'key', 'value'];

	function getId() {
		return $this->id;
	}

	/* public function locale(){
		return $this->hasOne('App\Models\Admodels\TranslatorLocaleModel','locale');
	} */
}