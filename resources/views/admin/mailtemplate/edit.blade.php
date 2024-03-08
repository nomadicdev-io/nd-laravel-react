@extends('admin.layouts.master')
@section('styles')
    @parent

@stop
@section('content')
@section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
@stop

<!-- Main content -->


<div class="card mg-b-20">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Edit Mail Template</h2>
        </div>
    </div>
</div>

{{ Form::open(['url' => [Config::get('app.admin_prefix') . '/mail-templates/edit/' . $mailTemplateDetails->mt_id], 'files' => true]) }}


<div class="col-sm-12">
    @include('admin.common.user_message')
</div>


<div class="card mg-b-20">
    <div class="card">
        <div class="card-body">

            <section class="basic_settings">

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>Title<em class="red">*</em></label>
                        <input type="text" name="mt_title" class="form-control" placeholder=""
                            value="{{ $mailTemplateDetails->mt_title }}" required />
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>Subject<em class="red">*</em></label>
                        <input type="text" name="mt_subject" class="form-control" placeholder=""
                            value="{{ $mailTemplateDetails->mt_subject }}" required />
                    </div>


                    <div class="col-sm-6 form-group">
                        <label>Subject [Arabic]</label>
                        <input type="text" name="mt_subject_arabic" class="form-control" placeholder=""
                            value="{{ $mailTemplateDetails->mt_subject_arabic }}" dir="rtl" />
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>Template<em class="red">*</em></label>
                        <textarea id="mt_template" name="mt_template" class="form-control ckeditorEn" required>{{ $mailTemplateDetails->mt_template }}</textarea>
                    </div>


                    <div class="col-sm-6 form-group">
                        <label>Template [Arabic]</label>
                        <textarea id="mt_template_arabic" name="mt_template_arabic" dir="rtl" class="form-control ckeditorAr">{{ $mailTemplateDetails->mt_template_arabic }}</textarea>
                    </div>

                </div>

            </section>

        </div>
    </div>
</div>
<div class="card mg-b-20">
    <div class="card">
        <div class="card-body">
            <div class="row mg-b-20 ">


                <div class="row mg-b-20 ">
                    <div class="col-sm-12">
                        <div class="button-control-wrapper">
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="updatebtnsubmit" value="Update" />
                                <a href="{{ apa('mail-templates') }}" class="btn btn-danger">Close</a>
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
    <script src="{{ asset('assets/admin/vendor/tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            PGSADMIN.utils.createEnglishArticleEditor();
            PGSADMIN.utils.createArabicArticleEditor();
        });
    </script>


@stop
