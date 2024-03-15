@extends('admin.layouts.login_master')
@section('metatags')
	<meta name="description" content="{{@$websiteSettings->site_meta_description}}" />
	<meta name="keywords" content="{{@$websiteSettings->site_meta_keyword}}" />
	<meta name="author" content="{{{@$websiteSettings->site_meta_title}}}" />
@stop
@section('seoPageTitle')
 <title>{{ $pageTitle }}</title>
@stop
@section('styles')
@parent
{!! RecaptchaV3::initJs() !!}
@stop
@section('content')
 <div class="az-signin-wrapper" @if(!empty($websiteSettings) && $websiteSettings->getMeta('theme_color')) style="background-color: {{$websiteSettings->getMeta('theme_color')}}" @endif>
  <div class="az-card-signin">
    <div class="az-signin-header">
    <h1 class="az-logo"><img class="logo-img" src="{{ ($websiteSettings) ? PP($websiteSettings->getMeta('logo_main')) : '' }}" alt=""></h1>
       @if(!empty($userMessage))
            {!! $userMessage !!}
        @endif
      
    </div><!-- az-signin-header -->
   
      
      
        
 

  {{ Form::open(array('url' => apa('reset-password-admin') ,'files'=>true,'id'=>'reset_password')) }}

                        <input  type="hidden" name="code"  value="{{request()->get('code')}}"/>

                         <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{lang('new_password')}}<em>*</em></label>
                                    <input dir="ltr" type="password" name="password" id="password" class="form-control" value="" required="required"/>
                                </div>
                            </div>
                         </div>


                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password" class="col-form-label">{{lang('confirm_password')}}<em>*</em></label>
                                    <input dir="ltr" type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="" required="required"/>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="button-control-wrapper">
                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" name="updatebtnsubmit" value="{{lang('save')}}"  />
                                        <a href="{{ apa('dashboard') }}" class="btn btn-danger">{{lang('close')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                          {!! RecaptchaV3::field('reset_password') !!}
                </div>
                </div>
            </div>

        {{ Form::close() }}

   
  </div>
</div>
@stop

@section('scripts')
@parent

<script>
	
	
     $(document).ready(function(){
	$('#reset_password').validate({
		'rules':{
			'g-recaptcha-response' : {'required':true},
			'password' : {'required':true},
			'password_confirmation' : { equalTo: "#password"}
		},
		'messages':{
			'password' : {'required':'{{ lang("field_required") }}'},
			'password_confirmation' : {'required':'{{ lang("field_required") }}','equalTo':'{{ lang("password_mismatch") }}'}
		},
		submitHandler: function(form) {
			return true;
		}
	});
 });

	
</script>
@stop
