@extends('admin.layouts.master')
@section('styles')
@parent

{{ HTML::style('assets/admin/vendor/multi-select/css/multi-select.css') }}

@stop
@section('content')
  @section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
  @stop

<div class="row">
<div class="col-lg-12 mg-t-20 mg-lg-t-0">

    @include('admin.common.user_message')

    <div class="card-header tx-medium bg-gray-300 tx-white">
        <h6 class="card-title">{{lang('change_password')}}</h6>
    </div><!-- card-header -->
    <div class="card">

        {{ Form::open(array('url' => apa('change-password-admin') ,'files'=>true,'id'=>'change_password', 'class'=>'needs-validation')) }}

            <div class="card-body">
                <div class="row">
                <div class="col-sm-12">
                    <div class="clearfix"></div>

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
                        {{-- <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="current_password" class="col-form-label">Current Password <em>*</em></label>
                                    <input dir="ltr" type="password" name="current_password" id="current_password" class="form-control" value="" required="required"/>
                                </div>
                            </div>
                        </div> --}}
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
                </div>
                </div>
            </div>

        {{ Form::close() }}
        </div>
</div>
</div>
@stop

@section('scripts')
@parent
<script>

 $(document).ready(function(){
	$('#change_password').validate({
		'rules':{
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