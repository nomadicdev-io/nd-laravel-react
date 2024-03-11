<?php
namespace App\Models\Admodels;

use DB;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
class PostTagModel extends Model implements AuditableContract {
		
		use \OwenIt\Auditing\Auditable;
        
		
		/**
		 * The database table used by the model.
		 *
		 * @var string
		 */
		// protected $parent = 'post_category_id';
        
        
		protected $table = 'tagging_tagged';

        protected $primaryKey = 'id';
        
      
        
      
       // protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
      

		protected $fillable =  [ 
                                    'taggable_id',
                                    'taggable_type',
                                    'tag_name',
                                    'tag_slug'
                                ];

        public $timestamps = false;
        
       public function tagPost(){
			return $this->belongsTo('\App\Models\Admodels\PostModel','taggable_id','post_id');
		}

}