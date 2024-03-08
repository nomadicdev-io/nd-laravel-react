@extends('admin.layouts.master')
@section('styles')
@parent
@stop
@section('content')
@section('bodyClass')
@parent
hold-transition skin-blue sidebar-mini
@stop

<div class="card mg-b-20">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Create Post Type</h2>
        </div>
    </div>
</div>
{{ Form::open(array('url' => array(route('add-post-type')),'files'=>true,'id'=>'add-form')) }}
<div class="col-sm-12">
    @include('admin.common.user_message')
</div>
<!-- ============================================================== -->
<!-- striped table -->
<!-- ============================================================== -->
<div class="card mg-b-20">
    <div class="card">
        <div class="card-body">
            <section class="basic_settings">
                <div class="row mg-b-20 ">
                    <div class="col-sm-6 form-group">
                        <label for="form_title" class="col-form-label"> Title <em>*</em></label>
                        <input type="text" name="form_title" id="form_title" class="form-control" placeholder=""
                            value="{{ old('form_title') ?? "" }}" required />
                    </div>
                </div>
              
              <?php 
              /*  <div class="row mg-b-20 ">
                    <div class="col-sm-6 form-group">
                        <label for="add_page" class="col-form-label"> Add Page <em>*</em></label>
                        <textarea rows="50"  style="background: #000;color:#fff" id="add_page" name="add_page" class="form-control"> {{ @$add_page }} </textarea>
                        
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="edit_page" class="col-form-label"> Edit Page <em>*</em></label>
                        <textarea rows="50"  style="background: #000;color:#fff" id="edit_page" name="edit_page" class="form-control"> {{ @$edit_page }} </textarea>
                        
                    </div>
                </div>
                */ ?>

            </section>
        </div>
    </div>
</div>
<div class="card mg-b-20">
    <div class="card">
        <div class="card-body">
           
            <div class="row mg-b-20 ">
                <div class="col-sm-12">
                    <div class="button-control-wrapper">
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="btnsubmit" value="Save" />
                            <a href="{{ route('add-post-type') }}" class="btn btn-danger">Close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@stop
