<?php
namespace App\Models\Admodels;

use DB;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use \App\Traits\DataTrait;

class CountryModel extends Model implements AuditableContract {
	use DataTrait;
	use \OwenIt\Auditing\Auditable;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'country';

	protected $primaryKey = 'country_id';

	protected $fillable = ['country_name', 'iso', 'name', 'country_name_arabic', 'iso3', 'numcode', 'phonecode', 'country_status', 'iso_4217', 'currency_name'];
	//protected $fillable = ['test'];

	const CREATED_AT = 'country_created_at';

	const UPDATED_AT = 'country_updated_at';

	public function getTitle() {
		return $this->getData('country_name');
	}

	public function getId() {
		return $this->country_id;
	}
}
