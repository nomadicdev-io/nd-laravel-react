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
            <h2 class="pageheader-title">{{lang('add_role')}}
				<a class="float-sm-right" href="{{ route('roles-index') }}"><button class="btn btn-outline-dark btn-flat">{{lang('back')}}</button></a></h2>
        </div>
    </div>
</div>

{!! Form::open(['method' => 'POST', 'url' => route('roles-create'), 'id'=>'post-form'] ) !!}
    <div class="row mg-t-20 mg-b-20">
        <div class="col-sm-12">
            @include('admin.common.user_message')
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <section class="basic_settings">

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="rolename" class="col-form-label">{{lang('role')}} {{lang('name')}}<em>*</em></label>
                                <input id="rolename" name="rolename" type="text" value="{{ old('rolename') ?? "" }}" class="form-control" required>
                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>

    <div class="row mg-b-20 ">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-control-wrapper">
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="createbtnsubmit" value="{{lang('save')}}"  />
                                    <a href="{{ route('roles-index') }}" class="btn btn-danger">{{lang('close')}}</a>
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
<script>
 $(document).ready(function(){
     $('#post-form').validate();
 });
</script>

@stop