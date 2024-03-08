<?php
namespace App\Models\Admodels;

use DB;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use \App\Traits\DataTrait;

class AuditModel extends Model implements AuditableContract {

	use DataTrait;
	use \OwenIt\Auditing\Auditable;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'audits';

	protected $primaryKey = 'id';

	public function user() {
		return $this->hasOne('\App\User', 'id', 'user_id');
	}

}