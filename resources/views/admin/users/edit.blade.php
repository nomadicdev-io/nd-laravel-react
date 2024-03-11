@extends('admin.layouts.master')
@section('styles')
@parent
{{-- {{ HTML::style('assets/admin/vendor/daterangepicker/daterangepicker.css') }} --}}
{{-- {{ HTML::style('assets/admin/vendor/tagit/css/jquery.tagit.css') }} --}}
{{-- {{ HTML::style('assets/admin/vendor/tagsinput/bootstrap-tagsinput.css') }} --}}
@stop
@section('content')
@section('bodyClass')
@parent
hold-transition skin-blue sidebar-mini
@stop

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">{{lang('edit')}} {{ lang('member') }}</h2>
        </div>
    </div>
</div>
{{ Form::open(array('url' => array(route('user-edit', ['id' => $user->id])),'files'=>true,'id'=>'add-form')) }}
    {{-- <input type="hidden" name="post[type]" value="{{$postType}}" /> --}}
    <div class="row mg-t-20 mg-b-20">
        <div class="col-sm-12">
            @include('admin.common.user_message')
        </div>
        <!-- ============================================================== -->
        <!-- striped table -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <section class="basic_settings">
                        <h5 class="az-content-label mg-b-25 mg-t-15">{{lang('user_details')}}</h5>
                        <div class="row ">
                        <div class="col-sm-6 ">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{ lang('first_name') }}<em>*</em></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="" value="{{ (!empty($user->first_name))?$user->first_name:$user->name }}" required/>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{ lang('last_name') }}<em>*</em></label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="" value="{{ $user->last_name }}" required/>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <label for="email" class="col-form-label">{{lang('email')}}<em>*</em></label>
                                    <input type="email" name="email" readonly="true" id="email" class="form-control" placeholder="" value="{{ $user->email }}" required/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="designation" class="col-form-label">{{lang('designation')}}</label>
                                    <input id="designation" name="designation" type="text" value="{{ $user->designation }}" class="form-control">
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone_number" class="col-form-label">{{lang('phone_number')}}</label>
                                    <input id="phone_number" name="phone_number" type="text" value="{{ $user->phone_number }}" class="form-control">
                                </div>
                            </div>
                           
                            @php
                                $uploaderData = [
                                    'control_name'=>'user_avatar',
                                    'folder' => 'userAvatars/',
                                    'isPostModel' => false,
                                    'label' => lang('upload_user_avatar') . ' (' . lang('max') . ' 2 MB)',
                                    'old_file_name'=> $user->getData('user_avatar'),
                                    'path' => 'app/public/userAvatars/',
                                    'postType' => 'users',
                                    'required' => false,
                                    'type'=> 'image',
                                ];
                            @endphp
                            <div class="col-sm-6 form-group">
                                @include('admin.common.file_upload.f-uploader',$uploaderData)
                            </div>
                        </div>



                    </section>
                </div>
            </div>
            <div class="card mg-b-20">
                 <div class="card-body">
                    <section class="basic_settings">
                        <h5 class="az-content-label mg-b-25 mg-t-15">{{lang('account_settings')}}</h5>
                        <div class="row ">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status" class="col-form-label">{{lang('force_password_change')}}</label>
                                    <select class="form-control" id="force_password_change" name="force_password_change">
                                        <option {{ ( $user->force_password_change ==  1 ) ? 'selected' : '' }} value="1">{{lang('yes')}}</option>
                                        <option {{ ( $user->force_password_change  == 2) ? 'selected' : '' }} value="2">{{lang('no')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status" class="col-form-label">{{lang('status')}}</label>
                                    <select class="form-control" id="status" name="status">
                                        <option {{ ( $user->status == 1 ) ? 'selected' : '' }} value="1">{{lang('enable_account')}}</option>
                                        <option {{ ( $user->status == 2) ? 'selected' : '' }} value="2">{{lang('disable_account')}}</option>
                                    </select>
                                </div>
                            </div>
                         </div>
                         </section>
                </div>
            </div>
            <div class="card mg-b-20">
                 <div class="card-body">
                    <section class="basic_settings">

                        {{-- Display roles only if you're creating an admin --}}
                        @if(isset($roles))
                             <h5 class="az-content-label mg-b-25 mg-t-15">{{lang('assign_roles')}}</h5>
                                <div class="role_list_wrap">
                                    @foreach ($roles as $role)
                                        <div class="r_item">
                                              <div data-role-id="{{ $role->id }}" class="az-toggle az-toggle-success {{ (in_array($role->id, $userRoleIDs)) ? 'on' : '' }}">
                                                <span></span>
                                              </div>
                                              <span>{{ Form::label($role->name, ucfirst($role->name)) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                @foreach ($roles as $role)
                                    <input id="role-{{ $role->id }}" style="display: none;" type="checkbox" data-id="{{ $role->name }}" name="roles[]" value="{{ $role->id }}"  {{ (in_array($role->id, $userRoleIDs))?' checked="checked" ':'' }} />
                                @endforeach
                        @endif

                        <div class="row mg-t-20 ">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="current_admin_pass" class="col-form-label">{{lang('current_admin_password')}}<em>*</em></label>
                                    <input id="current_admin_pass" autocomplete="new" name="current_admin_pass" type="password" value="" class="form-control" >
                                </div>
                            </div>
                        </div>

                    </section>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-control-wrapper">
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="updatebtnsubmit" value="{{lang('save')}}"  />
                                    <a href="{{ route('users') }}" class="btn btn-danger">{{lang('close')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


{{ Form::close() }}

@stop

@section('scripts')
@parent

{{-- <script src="{{  asset('assets/admin/vendor/tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script> --}}
<script src="{{  asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('assets/admin/vendor/multi-select/js/jquery.multi-select.js') }}"></script> --}}

<script>
$(document).ready(function() {
    $('select').select2({});
    PGSADMIN.utils.createEnglishArticleEditor();
    PGSADMIN.utils.createArabicArticleEditor();
    PGSADMIN.utils.createAjaxFileUploader("{{ route('post_media_create',['slug'=>'users', 'uploadPath' => 'public/userAvatars']) }}" ,"{{ apa('post_media_download') }}/", "{{ asset('storage/userAvatars') }}/" );
     $('.az-toggle').on('click', function(){
          $(this).toggleClass('on');
        })

});
</script>
<script>
    $(".az-toggle.az-toggle-success").on('click', function(){
        var isChecked = $(this).hasClass('on') ? false : true;
        $("#role-" + $(this).attr('data-role-id')).attr('checked', isChecked);
    });
</script>
@stop