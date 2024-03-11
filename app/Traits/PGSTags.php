<?php
namespace App\Traits;
use App;
use \Conner\Tagging\Taggable as Taggable;     
trait PGSTags {
	use Taggable {
        Taggable::withAnyTag as parentWithAnyTag;
    }
	
	
}