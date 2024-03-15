@extends('admin.layouts.master')
@section('styles')
    @parent
@stop
@section('content')
@section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
@stop

<div class="page-header">
    <h2 class="pageheader-title">Edit {{ strip_tags($postDetails->getData('post_title')) }}</h2>
</div>

{{ Form::open(['url' => [apa('post/' . $postType . '/edit/' . $postDetails->getData('post_id'))], 'files' => true, 'id' => 'add-form']) }}
<input type="hidden" name="post[type]" value="{{ $postType }}" />

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
                        <label for="post_title" class="col-form-label"> Title <em>*</em></label>
                        <input type="text" name="post[title]" id="post_title" class="form-control" placeholder=""
                            value="{{ $postDetails->post_title }}" required />
                    </div>



                </div>



            </section>
        </div>
    </div>
</div>

@include('admin.common.image_gallery_bulk')

<div class="card mg-b-20">
    <div class="card">
        <div class="card-body">
            <div class="row mg-b-20 ">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="post_status" class="col-form-label">Display Priority</label>
                        <input type="number" min="1" name="post[priority]" id="post_priority"
                            class="form-control" placeholder="" value="{{ $postDetails->getData('post_priority') }}"
                            required />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="post_status" class="col-form-label">Status</label>
                        <select class="form-control" id="post_status" name="post[status]">
                            <option {{ $postDetails->getData('post_status') == 1 ? 'selected' : '' }} value="1">
                                Publish</option>
                            <option {{ $postDetails->getData('post_status') == 2 ? 'selected' : '' }} value="2">
                                Unpublish</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mg-b-20 ">
                <div class="col-sm-12">
                    <div class="button-control-wrapper">
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="updatebtnsubmit" value="Update" />
                            <a href="{{ route('post_index', $postType) }}" class="btn btn-danger">Close</a>
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



@stop
