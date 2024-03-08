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
<div class="dashboard-content">
    <!-- Main content -->

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Add New</h2>
            </div>
        </div>
    </div>

    {{ Form::open(['url' => [Config::get('app.admin_prefix') . '/mail-templates/create'], 'files' => true]) }}

    <div class="row">
        <div class="col-sm-12">
            @include('admin.common.user_message')
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">

                    <section class="basic_settings">

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Title<em class="red">*</em></label>
                                <input type="text" name="mt_title" class="form-control" placeholder=""
                                    value="{{ old('mt_title') ?? "" }}" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Subject<em class="red">*</em></label>
                                <input type="text" name="mt_subject" class="form-control" placeholder=""
                                    value="{{ old('mt_subject') ?? "" }}" required />
                            </div>

                            <?php if ($websiteSettings->getMeta('disable_language') != 'ar') {?>
                            <div class="col-sm-6 form-group">
                                <label>Subject [Arabic]</label>
                                <input type="text" name="mt_subject_arabic" class="form-control" dir="rtl"
                                    placeholder="" value="{{ old('mt_subject_arabic') ?? "" }}" />
                            </div>
                            <?php }?>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Template<em class="red">*</em></label>
                                <textarea id="mt_template" name="mt_template" class="form-control ckeditorEn"
                                    required> {{ old('mt_template') ?? "" }} </textarea>
                            </div>

                            <?php if ($websiteSettings->getMeta('disable_language') != 'ar') {?>
                            <div class="col-sm-6 form-group">
                                <label>Template [Arabic]</label>
                                <textarea id="mt_template_arabic" name="mt_template_arabic" dir="rtl"
                                    class="form-control ckeditorAr"> {{ old('mt_template_arabic') ?? "" }} </textarea>
                            </div>
                            <?php }?>
                        </div>

                    </section>

                </div>
            </div>
        </div>


        <div class="form-group"></div>

        <div class="form-group">
            <input type="submit" name="createbtnsubmit" value="Submit" class="btn btn-success btn-flat">
            <a href="<?php echo asset(Config::get('app.admin_prefix') . '/mail-templates'); ?>" class="btn btn-danger btn-flat">Close</a>
        </div>

        {{ Form::close() }}

    </div> <!-- /.box-body -->

</div>
@stop

@section('scripts')
@parent
<script src="{{ asset('assets/admin/vendor/tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        PGSADMIN.utils.createEnglishArticleEditor();
        PGSADMIN.utils.createArabicArticleEditor();
    });
</script>
@stop
