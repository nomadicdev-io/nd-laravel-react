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
            <h2 class="pageheader-title">Create {{ ucwords(str_replace('-', ' ', $postType)) }}</h2>
        </div>
    </div>
</div>
{{ Form::open(['url' => [apa('post/' . $postType . '/add')], 'files' => true, 'id' => 'add-form']) }}
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
                            value="{{ old('post_title') ?? '' }}" required />
                    </div>



                    <div class="col-sm-6 form-group">
                        <label for="media_youtube" class="col-form-label"> Youtube Url <em>*</em></label>
                        <input type="text" name="meta[text][media_youtube]" id="media_youtube" class="form-control"
                            placeholder="" value="{{ old('meta')['text']['media_youtube'] ?? '' }}" />
                    </div>


                </div>
                <span>For One image <b>934*476 </b></span><br />
                <span>For Multiple image <b> 400*400 </b></span>
                <div class="row mg-b-20 ">

                    @php
                        $uploaderArr = [
                            [
                                'label' => 'Upload Image (2mb)',
                                'control_name' => 'media_doc',
                                'type' => 'image',
                                'old_file_name' => old('meta')['text']['media_doc'] ?? '',
                                'required' => false,
                                //'mimes' => ['jpg', 'jpeg', 'png', 'svg', 'pdf', 'docx', 'doc', 'xls', 'xlsx'],
                                'mimes' => ['jpg', 'jpeg', 'png', 'mp4'],
                            ],
                        ];
                    @endphp
                    @foreach ($uploaderArr as $uploaderData)
                        <div class="col-sm-6 form-group">
                            @include('admin.common.file_upload.uploader', $uploaderData)
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>



<div class="card mg-b-20">
    <div class="card">
        <div class="card-body">
            <div class="row mg-b-20 ">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="post_status" class="col-form-label">Status</label>
                        <select class="form-control" id="post_status" name="post[status]">
                            <option {{ old('post')['status'] ?? '' == 1 ? 'selected' : '' }} value="1">Publish
                            </option>
                            <option {{ old('post')['status'] ?? '' == 2 ? 'selected' : '' }} value="2">Unpublish
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mg-b-20 ">
                <div class="col-sm-12">
                    <div class="button-control-wrapper">
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="btnsubmit" value="Save" />
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
<script src="{{ asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
@include('admin.common.common_gallery_scripts')
<script>
    window.onload = function() {
        $("#videoGalleryUpload").hide();
    }
</script>
<script>
    $(document).ready(function() {
        PGSADMIN.utils.createEnglishArticleEditor();
        PGSADMIN.utils.createArabicArticleEditor();
        PGSADMIN.utils.createMediaUploader("{{ route('post_media_create', ['slug' => $postType]) }}",
            "#galleryWrapper", "{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/");
        PGSADMIN.utils.createAjaxFileUploader("{{ route('post_media_create', ['slug' => $postType]) }}",
            "{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/");

    });
</script>
@stop
