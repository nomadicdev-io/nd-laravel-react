<?php
namespace App\Traits;
use Illuminate\Support\Facades\Log;
use App;

trait LoggerTrait
{
	/**
     * Used to log request data to the log file, 
	 * Make sure the channel : 'request' is created in config/logging.php
     *
     * @param null
     * @return null
    */
	private function logRequest(){
		try
		{
			Log::channel('request')->info(request()->all()); 
		}
		catch(\Exception $e)
		{
			Log::channel('daily')->info(request()->all()); 
		}
	}
}
