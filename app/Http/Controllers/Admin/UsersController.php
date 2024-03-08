<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\Admodels\PostModel;
use App\Models\CountryModel;
use App\Models\MailTemplateModel;
use App\Models\User as User;
use App\Rules\PasswordStrength;
use App\Rules\SameOldPassword;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Lang;
use Route;
use Spatie\Permission\Models\Role;

class UsersController extends AdminBaseController {
    protected $roleNames;
    protected $rolesObj;

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->data['websiteSettings'] = PostModel::where('post_type', 'setting')->first();
        $this->module = 'User';
        $this->data['postType'] = $this->module;
    }

    public function index(Request $request) {
        if (!$this->checkPermission('List')) {
            return $this->returnInvalidPermission($request);
        }

        $users = User::when($request->input('name'), function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->input('name') . '%');
        })
            ->when($request->input('email'), function ($q) use ($request) {
                $q->where('email', '=', $request->input('email'));
            })
            ->when($request->input('status'), function ($q) use ($request) {
                $q->where('status', '=', $request->input('status'));
            })
            ->when($request->input('entity_id'), function ($q) use ($request) {
                $q->where('entity_id', '=', $request->input('entity_id'));
            })
        // ->where('is_admin', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(Request::capture()->except('page'));

        $this->data['userStatuses'] = [
            1 => lang('active'),
            2 => lang('inactive'),
        ];

        $this->data['users'] = $users;
        $this->data['countryList'] = CountryModel::where('country_status', '=', 1)->get();
        $this->data['filterDOM'] = User::getFilterDom($request);
        return view('admin.users.list', $this->data);
    }

    public function dashboard(Request $request) {
        $this->data['isDashBoard'] = true;

        $this->data['pageTitle'] = ((!empty($this->data['websiteSettings'])) ? (!empty($this->data['websiteSettings'])) ? $this->data['websiteSettings']->post_title : '' : '') . ' | ' . lang("dashboard");
        $wishingArr = \Config::get('dashboard_wishing');
        if(!empty($wishingArr)){
            $this->data['wishing']=\Arr::random($wishingArr, 1);
        }
        return view('admin.dashboard.dashboard', $this->data);
    }

    private function validateFormFields(Request $request, $type = "") {

        $inputs = [
            'first_name' => strip_tags($request->input('first_name')),
            'last_name' => strip_tags($request->input('last_name')),
            'email' => strip_tags($request->input('email')),
            'status' => strip_tags($request->input('status')),
            'entity_id' => strip_tags($request->input('entity_id')),
            'is_backend_user' => strip_tags($request->input('is_backend_user')),
            'phone_number' => strip_tags($request->input('phone_number')),
            'designation' => strip_tags($request->input('designation')),
            'description' => strip_tags($request->input('description')),
            'user_avatar' => strip_tags($request->input('user_avatar')),
            'force_password_change' => $request->input('force_password_change'),
            "user_emirate" => $request->input('user_emirate'),
            "member_type" => $request->input('member_type'),
            "emirates_id_number" => $request->input('emriates_id_number'),
        ];

        $rules = [
            //'name' => 'required',
            //'email' => ($type != "edit") ? 'required|email|unique:users,email' : 'required|email',
            'email' => ($type != "edit") ? 'required|email|unique:users,email,NULL,id,deleted_at,NULL' : 'required|email',
            //'status' => 'required',
            //'is_backend_user' => 'required',
            //'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            //'designation' => 'required',
            //'user_avatar' => 'required',
            //'entity_id' => 'required',
            //'force_password_change' => 'required',
            //"user_emirate" => "required",
            //"member_type" => "required",
            //"emirates_id_number" => "required",
        ];

        $messages = [
            'name.required' => lang('name_is_required'),
            'email.required' => lang('email_is_required'),
            'email.email' => lang('please_provide_a_valid_email_address'),
            'email.unique' => lang('this_user_exists'),
            'status.required' => lang('status_is_required'),
            'is_backend_user.required' => lang('please_determine_if_this_is_a_backend_user'),
            'phone_number.required' => lang('phone_number_is_required'),
            'phone_number.regex' => lang('invalid_phone_number'),
            'phone_number.min' => trans('messages.phone_number_must_be_atleast_x_digits', ['X' => 9]),
            'designation.required' => lang('designation_is_required'),
            'user_avatar.required' => lang('user_avatar_is_required'),
            'entity_id.required' => lang('please_select_an_entity'),
            'force_password_change.required' => lang('do_you_want_the_user_to_change_their_password'),

            "sector_id.required" => lang("sector_required"),
            "user_emirate.required" => lang("required"),
            "member_type.required" => lang("required"),
            "emirates_id_number.required" => lang("required"),
        ];

        if ($type == 'edit') {
            $inputs['current_admin_pass'] = $request->input('current_admin_pass');
            $rules['current_admin_pass'] = 'required';
            $messages['current_admin_pass.required'] = lang('current_admin_password_is_required');
        }
        $validator = \Validator::make($inputs, $rules, $messages);
        return [$validator, $inputs, $rules, $messages];
    }

    public function create(Request $request) {

        if (!$this->checkPermission('Add')) {
            return $this->returnInvalidPermission($request);
        }

        if ($request->input('createbtnsubmit')) {
            $userMessages = "";
            $roles = $request->input('roles');

            list($validator, $inputs, $rules, $messages) = $this->validateFormFields($request);

            if ($validator->fails()) {
                $request->flash();
                $messages = $validator->messages();
                $errors = [];
                foreach ($messages->all() as $message) {
                    $errors[] = $message;
                }
                $this->data['errors'] = $errors;
            } else {
                DB::beginTransaction();
                try {

                    $userPass = $this->generateRandomPassword();
                    $inputs['password'] = \Hash::make($userPass);
                    $inputs['username'] = $inputs['email'];
                    $inputs['name'] = $inputs['first_name'] . ' ' . $inputs['last_name'];
                    $loginLink = "#";

                    if ($this->_isRoleSelected('Super Admin', $request)) {
                        $inputs['is_super_admin'] = 1;
                    } else {
                        $input['is_super_admin'] = 2;
                    }
                    $sendEmail = $request->input('send_email');

                    $user = User::create($inputs);
                    if (isset($roles)) {
                        $user->roles()->sync($roles);
                    } else {
                        $user->roles()->detach();
                    }
                    if ($sendEmail == 1) {
                        $mailData = [
                            'name' => $user->getName(),
                            'to' => $user->getEmailAddress(),
                            'email_address' => $user->getEmailAddress(),
                            'userPass' => $userPass,
                            'subject' => "User Creation",
                        ];
                        try {
                            \Mail::send('frontend.email_template.user_register_en', $mailData, function ($message) use ($mailData) {
                                $message->to($mailData['to'])->subject($mailData['subject']);
                            });

                        } catch (\Exception$ex) {

                        }
                    }

                    // $userMessages = lang('user_account_created') . ': ' . $userPass;
                    $userMessages = $this->custom_message(lang('user_account_created'), 'success');
                    DB::commit();
                } catch (\Exception$e) {
                    DB::rollBack();
                    $this->data['errors'] = [lang('error_occurred') . $e->getMessage()];
                }

                $this->data['userMessage'] = $userMessages;
            }
        }

        $this->data['roles'] = Role::whereNotIn('id', [1])->get();

        return view('admin.users.add', $this->data);
    }

    public function edit($editID, Request $request) {

        if (!$this->checkPermission('Edit')) {
            return $this->returnInvalidPermission($request);
        }

        if (empty($editID)) {
            return redirect()->to(apa('users'));
        }

        $user = User::findOrFail($editID);

        if (empty($user)) {
            return redirect()->to(apa('users'));
        }

        if ($user->hasRole('Super Admin') && !Auth::user()->hasRole('Super Admin')) {
            return Redirect(route('admin_dashboard'))->with('userMessage', lang('invalid_permission'));
        }

        $this->data['messages'] = '';

        if ($request->input('updatebtnsubmit')) {

            list($validator, $inputs, $rules, $messages) = $this->validateFormFields($request, "edit");

            if ($validator->fails()) {
                $request->flash();
                $messages = $validator->messages();
                $errors = [];
                foreach ($messages->all() as $message) {
                    $errors[] = $message;
                }
                $this->data['errors'] = $errors;
            } else {
                // DB::beginTransaction();

                $input['is_super_admin'] = 2;
                $inputs['name'] = $inputs['first_name'] . ' ' . $inputs['last_name'];

                // Enable super admin -- if that option has been selected.
                if ($this->_isRoleSelected('Super Admin', $request)) {
                    $inputs['is_super_admin'] = 1;
                } else {
                    $inputs['is_super_admin'] = 2;
                }

                if (!\Hash::check($inputs['current_admin_pass'], Auth::user()->password)) {
                    $userMessages = $this->custom_message(lang('current_password_mismatch'), 'error');
                    $this->data['userMessage'] = $userMessages;
                } else {
                    // DB::beginTransaction();
                    try {
                        if ($request->input('password')) {
                            $inputs['password'] = \Hash::make($request->input('password'));
                        }

                        unset($inputs['current_admin_pass']);

                        if ($user->is_system_account == 1) {
                            unset($inputs['status']);
                        }
                        unset($inputs['email']);
                        $user->fill($inputs)->save();

                        $roles = $request['roles'];

                        // User's current roles
                        $currentUserRoles = $user->roles->pluck('id')->toArray();

                        if (isset($roles)) {
                            $user->roles()->sync($roles);
                        } else {
                            if(!$user->hasAnyRole(['Super Admin', 'System Administrator'])){
                                $user->roles()->detach();
                            }
                        }

                        $userMessages = lang('user_updated_successfully');
                        $this->data['userMessage'] = $this->custom_message($userMessages, 'success');

                        return redirect()->to(route('user-edit', ['id' => $user->id]))->with('userMessage', $this->data['userMessage']);
                        // DB::commit();
                    } catch (\Exception$e) {
                        // DB::rollBack();
                        // $errorInfo = $e->errorInfo;
                        // $this->data['errors'] = [$e->getMessage()];
                        $this->data['errors'] = [lang('error_occurred') . $e->getMessage()];
                    }

                }

            }
        }

        $this->data['user'] = User::findOrFail($editID);

        // Collect roles if it's editing an admin
        // $this->data['roles'] = Role::whereNotIn('id', [6, 7, 8])->get();
        $this->data['roles'] = Role::whereNotIn('id', [1])->get();
        $userRoleIDs = array('-1');

        foreach ($user->roles as $role) {
            $userRoleIDs[] = $role->id;
        }

        $this->data['userRoleIDs'] = $userRoleIDs;
        return view('admin.users.edit', $this->data);
    }

    public function admin_errorpage() {
        return view('admin.error.errorpage', $this->data);
    }

    public function changestatus(Request $request, $statusID, $currentStatus) {
        if (!$this->checkPermission('Edit')) {
            return $this->returnInvalidPermission($request);
        }
        $userOrRegistrations = Route::currentRouteName() != "users" ? route('registrations', ['formType' => 'user-registrations']) : route('users');
        $currentStatus = ($currentStatus == 2) ? 1 : 2;
        $currentStatusdatas = array("status" => $currentStatus);
        $userObj = User::where('id', '=', $statusID)->first();
        $userObj->update($currentStatusdatas);
        return redirect()->to($userOrRegistrations)->with('userMessage', $this->custom_message(lang('status_changed'), 'success'));
    }

    public function changeRegistrantStatus(Request $request, $userID, $currentStatus) {
        if (!$this->checkPermission('Edit')) {
            return $this->returnInvalidPermission($request);
        }
        $userOrRegistrations = 'users';
        $currentStatusdatas = array("user_approved" => $currentStatus);
        $userObj = User::where('id', '=', $userID)->first();
        // $userObj->update($currentStatusdatas);/

        $messages = [
            1 => "This user is approved",
            2 => "This user is rejected",
        ];

        // if the user is approved, send an email
        if ($currentStatus == 1) {

            $mailTemplateContent = MailTemplateModel::where('mt_title', '=', "Registration Approved")->first();

            if (!empty($mailTemplateContent)) {
                $subject = $mailTemplateContent->getSubject();
            }

            $mailData = [
                'name' => $userObj->getName(),
                'subject' => $subject,
                'mailContent' => str_replace('{contact_name}', $userObj->getName(), $mailTemplateContent->getTemplate()),
            ];

            $settings = [
                'to' => $userObj->getEmailAddress(),
                'subject' => "Your registration is approved.",
            ];

            $pdfTemplate = 'frontend.certificates.approval-certificate';

            $pdfFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'certificates' . DIRECTORY_SEPARATOR . $userObj->getId() . "-certificate-" . '-' . date('Y-m-d-H-i') . '.pdf');

            $pdf = \PDF::loadView($pdfTemplate, $this->data, [], [
                'mode' => 'utf-8',
                'format' => [210, 297],
                'setAutoTopMargin' => 'stretch',
                'autoMarginPadding' => 0,
                'bleedMargin' => 0,
                'crossMarkMargin' => 0,
                'cropMarkMargin' => 0,
                'nonPrintMargin' => 0,
                'margBuffer' => 0,
                'collapseBlockMargins' => false,
                'setDirectionality' => 'rtl',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'autoPageBreak' => true,
            ]);

            $settings['pdfOutput'] = $pdf->output();

            $savePdf = $pdf->save($pdfFilePath);

            $template = 'frontend.email_template.mail_template_en';

            // mail to user
            try {
                \Mail::send($template, $mailData, function ($message) use ($settings, $pdfFilePath) {
                    $message->to($settings['to'])
                        ->subject($settings['subject'])
                        ->attachData($pdfFilePath, "YourSMECertificate.pdf");
                });
            } catch (\Exception$ex) {
                dd($ex->getMessage());
            }

        }

        $userMessage = $this->custom_message($messages[$currentStatus], 'success');

        return redirect()->to(route('registrations', ['formType' => 'user-registrations']))->with('userMessage', $userMessage);
    }

    public function delete($deleteID, Request $request) {
        if (!$this->checkPermission('Delete')) {
            return $this->returnInvalidPermission($request);
        }

        if (empty($deleteID)) {
            return redirect()->to(apa('users'));
        }

        try {
            $user = User::find($deleteID);

            if (empty($user)) {
                return redirect()->to(apa('users'))->with('errors', [lang('user_details_not_found')]);
            }

            $user->delete();
        } catch (\Exception$e) {
            DB::rollBack();
            // $errorInfo = $e->errorInfo;
            // $this->data['errors'] = [$e->getMessage()];
            $this->data['errors'] = [lang('error_occurred') . $e->getMessage()];
        }
        $userMessages = $this->custom_message(lang('user_account_deleted'), 'success');
        return redirect()->to(apa('users'))->with('userMessage', $userMessages);
    }

    private function _isRoleSelected($roleName = 'Manage Web', $request) {
        if (empty($request->input('roles'))) {
            return false;
        }
        $roleIndex = str_replace(' ', '_', $roleName);
        if (!$this->rolesObj || !isset($this->rolesObj[$roleIndex])) {
            $this->rolesObj[$roleIndex] = Role::select('id')->where('name', '=', $roleName)->first();
        }
        return (in_array($this->rolesObj[$roleIndex]->id, $request->input('roles')));
    }

    public function changePassword(Request $request) {

        $this->data['pageTitle'] = (!empty($this->data['websiteSettings'])) ? $this->data['websiteSettings']->post_title : '' . ' | ' . lang('change_password');

        if ($request->isMethod('post')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'password' => ['required', 'confirmed', new PasswordStrength, new SameOldPassword],
                    // 'current_password' => 'required',
                ],
                [
                    'password.required' => lang('password_is_required'),
                    'password.confirmed' => lang('confirm_password_mismatch'),
                    // 'current_password.required' => lang('current_password_required'),
                ]
            );

            if ($validator->fails()) {
                // $messagesTmp = '<ul class="alert alert-danger">';
                $messages = $validator->messages();
                $messagesTmp = "";
                foreach ($messages->all() as $message) {
                    $messagesTmp .= '<li>' . $message . '</li>';
                }
                // $messagesTmp .= '</ul>';
                $this->data['errorMessage'] = $messagesTmp;
            } else {
                $password = $request->input('password_confirmation');
                $user = User::find(Auth::user()->id);
                $redirectToDashboard = false;
                if ($user->force_password_change == 1) {
                    $user->force_password_change = 2;
                    $user->password_changed = 1;
                    $redirectToDashboard = true;
                }
                $user->password = \Hash::make($password);
                $user->save();
                $this->data['userMessage'] = '<div class="alert alert-success">' . lang('password_changed_successfully') . '</div>';
                if ($redirectToDashboard == true) {
                    return redirect()->to(route('admin_dashboard'))->with('userMessage', $this->data['userMessage']);
                }
            }
        }
        return view('admin.users.change_password', $this->data);
    }

    public function resetPassword($id, Request $request) {
        $responseData = [];
        if ($request->ajax()) {
            $user = User::findOrFail($id);

            if (!empty($user)) {
                try {
                    $resetPasswordLink = "";
                    $validateCode = \Hash::make($user->getEmailAddress() . microtime());

                    // Change password and enable force password change
                    $inputs = [
                        'user_validate_code' => $validateCode,
                        //    'password' => \Hash::make($this->generateRandomPassword()),
                        //    'force_password_change' => 1,
                    ];

                    //$resetPasswordLink = \URL::to(\Session::get('lang') . '/change-password?code=' . $validateCode);
                    $resetPasswordLink = RT('reset-password-admin', ['code=' . $validateCode]);

                    $user->fill($inputs)->update();

                    $responseData = [
                        'status' => true,
                        'message' => lang("reset_link_copied_to_clipboard"),
                        'resetPasswordLink' => $resetPasswordLink,
                        'copyToClipboard' => $request->input('sendMail') == "true" ? false : true,
                    ];

                    //===========================================================//
                    if ($request->input('sendMail') == "true") {
                        try {

                            $mailData = [
                                'name' => $user->getName(),
                                'to' => $user->getEmailAddress(),
                                'subject' => "Password reset",
                                'resetPasswordLink' => $resetPasswordLink,
                            ];
                            try {
                                \Mail::send('frontend.email_template.mail_template_reset_password', $mailData, function ($message) use ($mailData) {
                                    $message->to($mailData['to'])->subject($mailData['subject']);
                                });

                            } catch (\Exception$ex) {
                                // pre($ex->getMessage());
                            }

                        } catch (\Exception$e) {
                            \Log::info('Error sending reset password mail: ' . $e->getMessage());
                            $responseData = [
                                'status' => false,
                                'message' => lang("error_occurred"),
                            ];
                        }
                        $responseData = [
                            'status' => true,
                            'message' => "Reset Password Mail Sent Successfully",
                            'resetPasswordLink' => $resetPasswordLink,
                            'copyToClipboard' => $request->input('sendMail') == "true" ? false : true,
                        ];
                    }
                    //===========================================================//

                } catch (\Exception$ex) {
                    \Log::info('Error while resetting password: ' . $ex->getMessage());
                    $responseData = [
                        'status' => false,
                        'message' => lang("error_occurred"),
                    ];
                }

            } else {
                $responseData = [
                    'status' => false,
                    'message' => lang("user_does_not_exist"),
                ];
            }

            return response()->json($responseData);
        } else {
            return redirect()->to(route('users'))->with('userMessage', lang('invalid_request'));
        }
    }

}
