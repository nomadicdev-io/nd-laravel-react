<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Swift_SmtpTransport;
class WebInstaller 
{

	protected $viewData = [];

	protected $installerConfig;
	public function __construct(Request $request) 
	{
		$this->installerConfig = config('web-installer');
	}

	public function index(Request $request) 
	{
		if(Storage::disk('local')->exists('installed')){
			return redirect()->to(route('home'));	
		}
		$this->viewData['config'] = $this->installerConfig;
		return view('installer.install_stepper', $this->viewData);
	}

	private function checkPHPVersion(Request $request)
	{
		$supported = false; 
		$minVersion = $this->installerConfig['requirements']['minPhpVersion'];
		$currentVersionFull = PHP_VERSION;
        preg_match("#^\d+(\.\d+)*#", $currentVersionFull, $filtered);
        $currentPhpVersion = $filtered[0];
        if (version_compare($currentPhpVersion, $minVersion) >= 0) {
            $supported = true;
        }
        return ['status'=>$supported,'currentPhpVersion'=>$currentVersionFull];
	}

	private function checkPHPExtensions(Request $request)
	{
		$requiredExtensions = $this->installerConfig['requirements']['php'];
		$supported = true; 
		$missingExtensions = [];
		$availableExtensions = [];
		foreach($requiredExtensions as $extension){
			if (! extension_loaded($extension)) {
				$supported = false;
				$missingExtensions[] = $extension;
			}else{
				$availableExtensions[] = $extension;
			}
		}
		return ['status'=>$supported, 'missingExtensions'=>$missingExtensions, 'availableExtensions'=>$availableExtensions];
	}

	private function checkApacheModules(Request $request)
	{
		$supported = true; 
		$missingModules = [];
		$availableModules = [];
		$requiredApacheModules = $this->installerConfig['requirements']['apache'];
		if (function_exists('apache_get_modules')) {
			$existingApacheModules = apache_get_modules();
			foreach($requiredApacheModules as $apacheModule){
				if (! in_array($apacheModule, $existingApacheModules)) {
					$missingModules[] = $apacheModule;
					$supported = false; 
				}else{
					$availableModules[] = $apacheModule;
				}
			}
		}
		return ['status'=>$supported, 'missingModules'=>$missingModules, 'availableModules'=>$availableModules];
	}

	private function checkStoragePermissions(Request $request)
	{
		$storagePermissions = (int) substr(sprintf('%o',fileperms( storage_path() )),-3);
		$supported = false;
		if($storagePermissions >= 755){
			$supported = true;
		}
		return ['status'=>$supported,'currentPermissions'=>$storagePermissions];
	}

	public function checkPrerequisites(Request $request)
	{
		$phpVersionCheck = $this->checkPHPVersion($request);
		$phpExtesionChecks = $this->checkPHPExtensions($request);
		$apacheModules =  $this->checkApacheModules($request);
		$storagePermissions = $this->checkStoragePermissions($request);
		$this->checkingResults = [];
		$status = true;		
		if(!$phpVersionCheck['status'] || !$phpExtesionChecks['status'] || !$apacheModules['status'] || !$storagePermissions['status']){
			$status = false;
		}
		return response()->json(['status'=>$status, 'php'=>['version'=>$phpVersionCheck,'extensions'=>$phpExtesionChecks], 'apache'=>$apacheModules, 'storage'=>$storagePermissions,'csrfToken'=>csrf_token()]);
	}


	public function checkDatabaseSettings(Request $request)
	{
		$supported = true; 
		if ($request->isMethod('post') && $request->ajax()) {
			$mysqlHost = $request->input('mysql_host');
			$mysqlPort = $request->input('mysql_port');
			$dbName = $request->input('db_name');
			$dbUsername = $request->input('db_username');
			$dbPassword = $request->input('db_password');
			try{
				$connection = @mysqli_connect($mysqlHost, $dbUsername, $dbPassword, $dbName, $mysqlPort);
				$message = lang('mysql_connection_ok');
				if (mysqli_connect_errno()){
				  $supported = false;	
			      $message =  lang('mysql_connection_failed').': '. mysqli_connect_error();
			   	}  	
		   	}catch(\Exception $ex){
				$supported = false;	
		   		$message =  lang('mysql_connection_failed').': '.$ex->getMessage();
		   	}		
			return response()->json(['status'=>$supported,'message'=>$message,'csrfToken'=>csrf_token()]);			
		}
		return response()->redirect('/');
	}

	public function checkMailSettings(Request $request)
	{
		$supported = true; 
		$message = lang('mail_configuration_is_successfull');
		if ($request->isMethod('post') && $request->ajax()) {
			$mailDriver = $request->input('mail_driver');
			$mailHost = $request->input('mail_host');
			$mailPort = $request->input('mail_port');
			$mailEncryption = $request->input('mail_encryption');
			$mailUsername = $request->input('mail_username');
			$mailPassword = $request->input('mail_password');
			$mailFromAddress = $request->input('mail_from_address');
			$mailFromName = $request->input('mail_from_name');
			/*try{
				if($mailDriver == 'smtp'){
					$transport = new \Swift_SmtpTransport($mailHost, $mailPort, $mailEncryption);
					
					//dd($transport);
					
	                $transport->setUsername($mailUsername)
	                ->setPassword($mailPassword);
				}else if($mailDriver == 'sendmail'){
					$transport = new \Swift_SendmailTransport();					
				}					
			        $mailer = new \Swift_Mailer($transport);
			        $html = view('installer.partials.mail_test_message')->render();

			        $mailMessage  = (new \Swift_Message('Test'))
			             ->setFrom([$mailFromAddress])
			             ->setTo([$mailFromAddress])
			             ->setBody($html, 'text/html');
	             	$result = $mailer->send($mailMessage);
	             	if(!$result){
	             		 $supported = false; 
	             		 $message = lang('mail_sending_failed');
	             	}
			}catch (\Swift_TransportException $ex) {
				$supported = false;
			    $message = $ex->getMessage();

			} catch (\Exception $ex) {
				$supported = false;
			    $message = $ex->getMessage();
			}*/
			return response()->json(['status'=>$supported,'message'=>$message,'csrfToken'=>csrf_token()]);
		}
	}


	public function createEnv(Request $request, $mode='development')
	{
		if ($request->isMethod('post') && $request->ajax()) {
			$envFileData =
            '#APP'.PHP_EOL.
			'APP_NAME="'.$request->input('app_name').'"'.PHP_EOL.
			'APP_ENV='.$mode.PHP_EOL.
			'APP_KEY=base64:'.base64_encode(Str::random(32)).PHP_EOL.
			'APP_DEBUG=true'.PHP_EOL. 
			'ADMIN_PREFIX="'.$request->input('admin_prefix').'"'.PHP_EOL.
			'APP_URL="'.$request->input('app_url').'"'.PHP_EOL.PHP_EOL.

			'#SESSION'.PHP_EOL.
			'BROADCAST_DRIVER="log"'.PHP_EOL.
			'CACHE_DRIVER=file'.PHP_EOL.
			'QUEUE_CONNECTION=sync'.PHP_EOL.
			'SESSION_DRIVER=file'.PHP_EOL. 
			'SESSION_LIFETIME=120'.PHP_EOL.
			'SESSION_SECURE_COOKIE=false'.PHP_EOL.PHP_EOL.

			'#NOCAPTCHA'.PHP_EOL.
			'NOCAPTCHA_SITEKEY="'.$request->input('recaptcha_sitekey').'"'.PHP_EOL.
			'NOCAPTCHA_SECRET="'.$request->input('recaptcha_secret').'"'.PHP_EOL.PHP_EOL.

			'#DATABASE'.PHP_EOL.
			'DB_CONNECTION=mysql'.PHP_EOL.
			'DB_HOST='. $request->input('mysql_host').PHP_EOL.
			'DB_PORT='. $request->input('mysql_port').PHP_EOL.
			'DB_DATABASE="'.$request->input('db_name').'"'.PHP_EOL.
			'DB_USERNAME="'.$request->input('db_username').'"'.PHP_EOL.
			'DB_PASSWORD="'.$request->input('db_password').'"'.PHP_EOL.PHP_EOL.

			'#MAIL'.PHP_EOL.
			'MAIL_DRIVER="'.$request->input('mail_driver').'"'.PHP_EOL.
			'MAIL_HOST='.$request->input('mail_host').PHP_EOL.
			'MAIL_PORT='.$request->input('mail_port').PHP_EOL.
			'MAIL_USERNAME="'.$request->input('mail_username').'"'.PHP_EOL.
			'MAIL_PASSWORD="'.$request->input('mail_password').'"'.PHP_EOL.
			'MAIL_FROM_ADDRESS="'.$request->input('mail_from_address').'"'.PHP_EOL.
			'MAIL_FROM_NAME="'.$request->input('mail_from_name').'"'.PHP_EOL.
			'MAIL_ENCRYPTION='.$request->input('mail_encryption');

            $envPath = base_path('.env');
            if(\File::exists('../.env')){
            	rename($envPath, $envPath.time());	
            }           
            try {
	            file_put_contents($envPath, $envFileData);
	            $outputLog = new BufferedOutput;
	            Artisan::call('config:clear', [], $outputLog);
	            Artisan::call('route:clear', [], $outputLog);
	            Artisan::call('view:clear', [], $outputLog);
	            Artisan::call('cache:clear', [], $outputLog);
	            //Artisan::call('debugbar:clear', [], $outputLog);                
		       	return response()->json(['status'=>true,'message'=>lang('configuration_file_created'),'bufferLog'=>$outputLog,'csrfToken'=>csrf_token()]);
	        } catch (Exception $e) {
	        	return response()->json(['status'=>false,'message'=>$e->getMessage(),'csrfToken'=>csrf_token()]);
	        }
		}
	}
	
	public function runMigrations(Request $request)
	{		
		$outputLog = new BufferedOutput;
		try {
            Artisan::call('migrate', ['--force'=> true], $outputLog);
            Artisan::call('db:seed', ['--force' => true], $outputLog);
            return response()->json(['status'=>true,'message'=>lang('db_migrations_completed'),'csrfToken'=>csrf_token()]);
        } catch (Exception $e) {
        	return response()->json(['status'=>false,'message'=>$e->getMessage(),'bufferLog'=>$outputLog->fetch(),'csrfToken'=>csrf_token()]);
        }
	}
    
    public function checkAdminSettings(Request $request){
        if ($request->isMethod('post') && $request->ajax()) {
			$adminFullName = $request->input('admin_fullname');
			$adminEmail = $request->input('admin_email');
			$adminPhone = $request->input('admin_phone');
			$adminUsername = $request->input('admin_username');
			$adminPassword = $request->input('password');
			try{
                
                // $rules['password'] = ['required', 'regex:/^(?=.[A-Za-z])(?=.\d)(?=.[@$!%#?&])[A-Za-z\d@$!%*#?&]{8,}$/'];
                $inputs = $request->all();
                $rules = [
                    'admin_fullname' => 'required',
                    'admin_email' => ['required','email'],
                    'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', 
                    
                ];
                $messages = [
                                'admin_fullname.required' => lang('name_required'),
                                'admin_email.required' => lang('email_required'),
                                'admin_email.email' => lang('invalid_email'),
                                'password.required' => lang('password_required'),
                                'password.regex' => 'Password should have at least eight characters which include one uppercase letter, lowercase letter, special character and numbers',
                            ];

                $validator = Validator::make($inputs, $rules, $messages);
                if($validator->fails()){
                    $messages = $validator->messages();
					$validMessage = '';
					foreach ($messages->all() as $message) {
						$validMessage  .= $message;
					}					
                    
                    return response()->json(['status'=>false,'message'=>$validMessage,'csrfToken'=>csrf_token()]);
                }else{
                    return response()->json(['status'=>true,'message'=>'','csrfToken'=>csrf_token()]);
                }
            } catch (Exception $e) {
				return response()->json(['status'=>false,'message'=>$e->getMessage(),'csrfToken'=>csrf_token()]);
        	}
        }
        
        return response()->json(['status'=>false,'message'=>lang('invalid_request'),'csrfToken'=>csrf_token()]);
    }
    
	public function createAdmin(Request $request)
	{

		if ($request->isMethod('post') && $request->ajax()) {
			
			$adminFullName = $request->input('admin_fullname');
			$adminEmail = $request->input('admin_email');
			$adminPhone = $request->input('admin_phone');
			$adminUsername = $request->input('admin_username');
			$adminPassword = $request->input('password');
			try{
				
                
                //$rules['password'] = ['required', 'regex:/^(?=.[A-Za-z])(?=.\d)(?=.[@$!%#?&])[A-Za-z\d@$!%*#?&]{8,}$/'];
                $inputs = $request->all();
				
                $rules = [
                    'admin_fullname' => 'required',
                    'admin_email' => 'required|email',                   
                    'password' => 'confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
                ];
                $messages = [
                                'admin_fullname.required' => lang('name_required'),
                                'admin_email.required' => lang('email_required'),
                                'admin_email.email' => lang('invalid_email'),
                                'password.required' => lang('password_required'),
                                'password.regex' => 'Password should have at least eight characters which include one uppercase letter, lowercase letter, special character and numbers',
                            ];

                $validator = Validator::make($inputs, $rules, $messages);
                if($validator->fails()){
                    $messages = $validator->messages();
					$validMessage = '';
					foreach ($messages->all() as $message) {
						$validMessage  .= $message;
					}					
                    
                    return response()->json(['status'=>false,'message'=>$validMessage,'csrfToken'=>csrf_token()]);
                }
                
				$data = [
					'name'=>$adminFullName,
					'email'=>$adminEmail,
					'phone_number'=>$adminPhone,
					'username' => $adminUsername,
					'password' => \Hash::make($adminPassword),
					'status'=>1,
					'is_admin'=>1,
					'is_super_admin'=>1,
					'is_backend_user'=>1,
					'is_system_account'=>1,					
					
					'created_at'=>date('Y-m-d H:i:s'),
				];
				
				\DB::table('users')->insert($data);
				
				$user = User::find(1);
				$user->assignRole('Super Admin');				
				return response()->json(['status'=>true,'message'=>lang('admin_account_created'),'csrfToken'=>csrf_token()]);
			} catch (Exception $e) {
				return response()->json(['status'=>false,'message'=>$e->getMessage(),'csrfToken'=>csrf_token()]);
        	}		
		
		}
	}

	public function getCSRF()
	{
		return response()->json(['status'=>true,'message'=>lang('csrf_token_updated'),'csrfToken'=>csrf_token()]);
	}

	public function linkStorage(Request $request)
	{
		$outputLog = new BufferedOutput;
		if ($request->isMethod('post') && $request->ajax()){
			try {
	            Artisan::call('storage:link', ['--force'=> true], $outputLog);
	            return response()->json(['status'=>true,'message'=>lang('storage_linked'),'csrfToken'=>csrf_token()]);
	        } catch (Exception $e) {
	        	return response()->json(['status'=>false,'message'=>$e->getMessage(),'bufferLog'=>$outputLog->fetch(),'csrfToken'=>csrf_token()]);
	        }
		}
	}


	public function finalizeInstallation(Request $request)
	{
		$outputLog = new BufferedOutput;
		if ($request->isMethod('post') && $request->ajax()){
			try {
				$this->createEnv($request,'development');
				Artisan::call('key:generate', ['--force'=> true], $outputLog);
                Artisan::call('translations:export {group}', ['group'=>'messages']);
	            Storage::put('installed', 'finished');
	            return response()->json(['status'=>true,'message'=>lang('installation_finished_redirecting_in_a_moment'), 'redirectURL'=>route('home')]);
	        } catch (Exception $e) {
	        	return response()->json(['status'=>false,'message'=>$e->getMessage(),'bufferLog'=>$outputLog->fetch(),'csrfToken'=>csrf_token()]);
	        }
		}
	}
}