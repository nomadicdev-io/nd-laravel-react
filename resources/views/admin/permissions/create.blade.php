@extends('admin.layouts.master')
@section('styles')
@parent
<style>

</style>
@stop
@section('content')
  @section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
  @stop
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{ lang('add_permission') }}</h2>
            </div>
        </div>
    </div>

 
    
    <div class="row mg-t-20 mg-b-20">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                 {!! Form::open(['method' => 'POST', 'url' => asset(Config::get('app.admin_prefix').'/permissions/create' ), 'id'=>'post-form'] ) !!}
				
                    <div class="card-body">
                        <div class="col-sm-12">
                            @include('admin.common.user_message')
                            <div class="clearfix"></div>
                            
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="banner_title" class="col-form-label">{{ lang('permission_name') }}<em>*</em></label>
                                            <input id="banner_title" name="name" type="text" value="{{ old('name') ?? "" }}" class="form-control" required>
                                        </div>
                                    </div>
 
                                 </div>
                                <div class="button-control-wrapper">
                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" name="" value="{{ lang('save') }}"  />
                                        <a href="{{ apa('permissions') }}" class="btn btn-danger">{{ lang('close') }}</a>
                                    </div>
                                </div>
                        </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-sm-12">
                            
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
     $('#post-form').validate();

 });
</script>

@stop