<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\User as User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Input;
use App\Rules\PasswordStrength;

class LoginController extends AdminBaseController {
    protected $data = [];
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function index(Request $request) {
        
        if (Auth::user()) {
            return redirect()->to(Config::get('app.admin_prefix') . '/dashboard');
        }

        $loginTries = session('login_tries');
        $lastTriedAt = session('last_tried_at');

        $loginTries = (empty($loginTries)) ? 0 : $loginTries;

        if ($loginTries >= 3) {
            return redirect()->to('/')->with('errorMessage', lang('invalid_request'));
        }

        $this->data['message'] = '';
        if ($request->input('user_email')) {

            $inputs = [
                'email' => $request->input('user_email'),
                'password' => $request->input('password'),
                'captcha' => $request->input('g-recaptcha-response'),

            ];
            $rules = [
                'email' => 'required',
                'password' => 'required',
                //'captcha' => 'required|captcha',
                'captcha' => 'required|recaptchav3:login,0.5',
            ];

            $messages = [
                'email.required' => lang('email_required'),
                'password.required' => lang('password_required'),
                'captcha.required' => lang('captcha_required'),
                'captcha.recaptchav3' => lang('invalid_captcha'),
            ];

            $validator = \Validator::make($inputs, $rules, $messages);
            if ($validator->fails()) {
                $request->flash();
                $errors = '<ul class="alert alert-danger">';
                $messages = $validator->messages()->all();
                foreach ($messages as $message) {
                    $errors .= '<li>' . $message . '</li>';
                }
                $errors .= '</ul>';
                $this->data['userMessage'] = $errors;
            } else {

                $credentials = array('username' => $request->input('user_email'), 'password' => $request->input('password'), 'status' => 1);

                if (Auth::attempt($credentials)) {
                    $user = User::where('id', '=', Auth::user()->id)->first();

                    $user->update(['last_logged_in' => \Carbon\Carbon::now()->toDateTimeString()]);

                    return redirect()->to(Config::get('app.admin_prefix') . '/dashboard');
                } else {
                    $loginTries += 1;
                    session(['login_tries' => $loginTries]);
                    session(['last_tried_at' => date('Y-m-d H:i:s')]);
                    $this->data['userMessage'] = $this->custom_message(lang("invalid_username_or_password"), 'error');
                }

            }
        }
        $this->data['pageTitle'] .= "Login";
        if ($loginTries >= 3) {
            return redirect()->to('/')->with('errorMessage', lang('invalid_request'));
        }

        return view('admin.users.login', $this->data);
    }

    public function logout() {
        Auth::logout();
        \Session::flush();
        return redirect()->to(Config::get('app.admin_prefix') . '');
    }

    public function setlanguage(Request $request, $lang) {
        $allowedLangs = ['en', 'ar'];

        Session::put('switchLang', $lang);

        \App::setLocale($lang);
        $this->data['lang'] = $lang;

        $redirectURL = url()->previous();

        \Log::info('Switching lang to:' . \App::getLocale());

        if (strpos($redirectURL, $request->getSchemeAndHttpHost()) !== 0) {
            $redirectURL = null;
        }

        Session::save();
        $redirect = redirect()->to($redirectURL);

        return $redirect;
    }

    public function resetPassword(Request $request) {

        $this->data['pageTitle'] = (!empty($this->data['websiteSettings'])) ? $this->data['websiteSettings']->post_title : '' . ' | ' . lang('change_password');

        $validateCode = $request->input('code');
        $userDetails = User::where('user_validate_code', $validateCode)->first();
        if (empty($userDetails)) {
            return redirect()->to(route('error404'));
        }

        if ($request->isMethod('post')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'password' => ['required', 'confirmed', new PasswordStrength],
                    // 'current_password' => 'required',
                    //'captcha' => 'required|recaptchav3:reset_password,0.5',
                ],
                [
                    'password.required' => lang('password_is_required'),
                    'password.confirmed' => lang('confirm_password_mismatch'),
                    'captcha.required' => lang('captcha_required'),
                    'captcha.recaptchav3' => lang('invalid_captcha'),
                    // 'current_password.required' => lang('current_password_required'),
                ]
            );

            if ($validator->fails()) {
                // $messagesTmp = '<ul class="alert alert-danger">';
                $messages = $validator->messages();
                $messagesTmp = '<ul class="alert-danger">';
                foreach ($messages->all() as $message) {
                    $messagesTmp .= '<li>' . $message . '</li>';
                }
                 $messagesTmp .= '</ul>';
                $this->data['userMessage'] = $messagesTmp;
            } else {
                $password = $request->input('password_confirmation');
                $user = User::find($userDetails->id);
                $redirectToDashboard = false;

                $user->password = \Hash::make($password);
                $user->save();

                $this->custom_message(lang("invalid_username_or_password"), 'error');
                $this->data['userMessage'] = '<div class="alert alert-success">' . lang('password_changed_successfully') . '</div>';

            }
        }
        return view('admin.users.reset_password', $this->data);

    }
}
