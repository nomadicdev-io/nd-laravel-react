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
            <h2 class="pageheader-title">Edit {{ strip_tags($postDetails->getData('post_title')) }}</h2>
        </div>
    </div>
</div>
{{ Form::open(array('url' => array(apa('post/'.$postType.'/edit/'.$postDetails->getData('post_id'))),'files'=>true,'id'=>'add-form')) }}
<input type="hidden" name="post[type]" value="{{$postType}}" />

<div class="col-sm-12">
    @include('admin.common.user_message')
</div>
<!-- ============================================================== -->
<!-- striped table -->
<!-- ============================================================== -->
<div class="card mg-b-20">
    <div class="card-body">
        <section class="basic_settings">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="post_lang" class="col-form-label">Language</label>
                        <select class="form-control" id="post_lang" name="post[lang]">
                            <option value="">Both</option>
                            <option {{ ( $postDetails->post_lang == 'en' )? 'selected' : '' }} value="en">English
                            </option>
                            <option {{ ( $postDetails->post_lang== 'ar' )? 'selected' : '' }} value="ar">Arabic</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 form-group ">
                    <label for="news_date" class="col-form-label">Date<em>*</em></label>
                    <input type="text" autocomplete="off" name="meta[date][news_date]" id="news_date"
                        class="form-control datepicker" placeholder=""
                        value="{{$postDetails->formatDate('news_date') }}" required />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group changelang_en">
                    <label for="post_title" class="col-form-label">Title<em>*</em></label>
                    <input type="text" name="post[title]" id="post_title" class="form-control" placeholder=""
                        value="{{ $postDetails->post_title }}" required />
                </div>
                <div class="col-sm-6 form-group changelang_ar">
                    <label for="title_arabic" class="col-form-label">Title [Arabic]<em>*</em></label>
                    <input type="text" name="post[title_arabic]" id="post_title_arabic" dir="rtl" class="form-control"
                        placeholder="" value="{{ $postDetails->post_title_arabic }}" required />
                </div>

                <div class="col-sm-6 form-group changelang_en">
                    <label for="description" class="col-form-label">Description</label>
                    <textarea id="description" name="meta[text][description]" class="form-control ckeditorEn" > {!! $postDetails->getMeta('description') !!} </textarea>
                </div> 
                <div class="col-sm-6 form-group changelang_ar">
                    <label for="description_arabic" class="col-form-label">Description [Arabic]</label>
                    <textarea id="description_arabic" name="meta[text][description_arabic]" class="form-control ckeditorAr" > {!!  $postDetails->getMeta('description_arabic')  !!} </textarea>
                </div>  
               
            </div>

            <div class="row mg-b-20 ">
                @php
                $uploaderArr = [
                    [
                        'label'=>'Upload Image (2mb)',
                        'control_name'=>'news_image',
                        'type'=> 'image',
                        'old_file_name'=> $postDetails->getMeta('news_image'),
                        'required'=>true,
                        'mimes'=>['jpg', 'jpeg', 'png'],
                    ],
                ];
                @endphp
                @foreach($uploaderArr as $uploaderData)
                <div class="col-sm-6 form-group">
                    @include('admin.common.file_upload.uploader',$uploaderData)
                </div>
                @endforeach
            </div>

        </section>
    </div>
</div>

@include('admin.common.image_gallery')

<div class="card mg-b-20">
        <div class="card-body">
            <div class="row">
                <?php /* <div class="col-sm-4">
								<div class="form-group">
									<label for="post_status" class="col-form-label">Display Priority</label>
									<input type="number" min="1" name="post[priority]" id="post_priority"  class="form-control" placeholder="" value="{{ $postDetails->getData('post_priority')  }}"   />
								</div>
							</div> */ ?>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="post_status" class="col-form-label">Status</label>
                        <select class="form-control" id="post_status" name="post[status]">
                            <option
                                <?php echo ($postDetails->getData('post_status') == 1) ? 'selected =="selected"' : ""; ?>
                                value="1">Publish</option>
                            <option
                                <?php echo ($postDetails->getData('post_status') == 2) ? 'selected =="selected"' : ''; ?>
                                value="2">Unpublish</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="button-control-wrapper">
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="updatebtnsubmit" value="Save" />
                            <a href="{{ apa('post/'.$postType,true) }}" class="btn btn-danger">Close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
$hash = (!empty($postDetails->getMeta('private_token'))) ? $postDetails->getMeta('private_token') : $hash = Hash::make(microtime());
?>
    @if($postDetails->getMeta('type') == 'private')
    <input type="hidden" name="meta[text][private_token]" id="private_token" value="{{ $hash }}" />
    @endif
    {{ Form::close() }}
</div>
@stop

@section('scripts')
@parent
<script src="{{  asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>

<script>
var postLang = "{{@$postDetails->post_lang}}";
$(document).ready(function() {
   

    PGSADMIN.utils.createEnglishArticleEditor();
    PGSADMIN.utils.createArabicArticleEditor();
    PGSADMIN.utils.createMediaUploader("{{ route('post_media_create',['slug'=>$postType]) }}",
        "#galleryWrapper", "{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/");
    PGSADMIN.utils.createAjaxFileUploader("{{ route('post_media_create',['slug'=>$postType]) }}",
        "{{ apa('post_media_download') }}/", "{{ asset('storage/post/') }}/");

    PGSADMIN.utils.youtubeVideoThumbUploader('changeImage',
        "{{ route('post_media_create',['slug'=>$postType]) }}", "{{ asset('storage/post/') }}/",
        "#galleryWrapper");



});
</script>
@include('admin.common.lang_switch_script')
@stop