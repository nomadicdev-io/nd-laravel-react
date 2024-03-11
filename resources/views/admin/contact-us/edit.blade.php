@extends('admin.layouts.master')
@section('styles')
@parent
@stop
@section('content')
@section('bodyClass')
@parent
hold-transition skin-blue sidebar-mini
@stop

    <div class="mg-b-20">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Manage {{ucwords(str_replace('-',' ',$postType))}}</h2>
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
						<div class="row mg-b-20 ">
							<div class="col-sm-6 form-group">
								<label for="post_title" class="col-form-label">Page Title <em>*</em></label>
								<input type="text" name="post[title]" id="post_title" class="form-control" placeholder="" value="{{ $postDetails->post_title }}" required/>
							</div>
							<div class="col-sm-6 form-group">
								<label for="title_arabic" class="col-form-label">Page Title [Arabic]<em>*</em></label>
								<input type="text" name="post[title_arabic]" id="post_title_arabic" dir="rtl" class="form-control" placeholder="" value="{{ $postDetails->post_title_arabic }}" required />
							</div>
						</div>

						<div class="row mg-b-20 ">
						<div class="col-sm-6 form-group">
							<label for="location" class="col-form-label">Location <em>*</em></label>
							<input type="text" name="meta[text][location]" id="location" class="form-control" placeholder="" value="{{ $postDetails->getMeta('location') }}" required/>
						</div>
						<div class="col-sm-6 form-group">
							<label for="location_arabic" class="col-form-label">Location [Arabic]<em>*</em></label>
							<input dir="rtl" type="text" name="meta[text][location_arabic]" id="location_arabic" class="form-control" placeholder="" value="{{ $postDetails->getMeta('location_arabic') }}" required/>
						</div>
					</div>

					<div class="row mg-b-20 ">
				    	<div class="col-sm-6 form-group">
							<label for="opening_time" class="col-form-label">Opening Time<em>*</em></label>
							<input type="time" name="meta[text][opening_time]" id="opening_time" dir="rtl" class="form-control" placeholder="" value="{{ $postDetails->getMeta('opening_time') }}" required />
						</div>
						<div class="col-sm-6 form-group">
							<label for="closing_time" class="col-form-label">Closing Time<em>*</em></label>
							<input type="time" name="meta[text][closing_time]" id="closing_time" dir="rtl" class="form-control" placeholder="" value="{{ $postDetails->getMeta('closing_time') }}" required />
						</div>

					</div>

					<div class="row mg-b-20">
						<div class="col-sm-6 form-group">
							<label for="open_days" class="col-form-label">Open Days<em>*</em></label>
							<input type="text" name="meta[text][open_days]" id="open_days" class="form-control" placeholder="" value="{{ $postDetails->getMeta('open_days') }}" required />
						</div>
						<div class="col-sm-6 form-group">
							<label for="open_days_arabic" class="col-form-label">Open Days [AR]<em>*</em></label>
							<input type="text" name="meta[text][open_days_arabic]" id="open_days_arabic" class="form-control" placeholder="" value="{{ $postDetails->getMeta('open_days_arabic') }}" required />
						</div>
					</div>

					<div class="row mg-b-20 ">
						<div class="col-sm-6 form-group">
							<label for="map_url" class="col-form-label">Map URL <em>*</em></label>
							<input type="text" name="meta[text][map_url]" id="map_url" class="form-control" placeholder="" value="{{ $postDetails->getMeta('map_url') }}" required/>
						</div>
					</div>

					<div class="row mg-b-20 ">
						<div class="col-sm-4 form-group">
							<label for="contact_email" class="col-form-label">Email Address<em>*</em></label>
							<input type="text" name="meta[text][contact_email]" id="contact_email" class="form-control" placeholder="" value="{{ $postDetails->getMeta('contact_email') }}" required/>
						</div>
						<div class="col-sm-4 form-group">
							<label for="contact_tollfree" class="col-form-label">Toll-free<em>*</em></label>
							<input type="text" name="meta[text][contact_tollfree]" id="contact_tollfree" class="form-control" placeholder="" value="{{ $postDetails->getMeta('contact_tollfree') }}" required/>
						</div>
						<div class="col-sm-4 form-group">
							<label for="contact_phone" class="col-form-label">Phone Number<em>*</em></label>
							<input type="text" name="meta[text][contact_phone]" id="contact_phone" class="form-control" placeholder="" value="{{ $postDetails->getMeta('contact_phone') }}" required/>
						</div>
					</div>

					<div class="row mg-b-20 ">
						@php
							$uploaderArr = [
								[
									'label'=>'Upload Image (2MB)',
									'control_name'=>'inner_page_banner_image',
									'type'=> 'image',
									'old_file_name'=> $postDetails->getMeta('inner_page_banner_image'),
									'required' => true,
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

			<div class="card mg-b-20">
				<div class="card-body">
				<div class="row mg-b-20 ">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="post_status" class="col-form-label">Display Priority</label>
								<input type="number" min="1" name="post[priority]" id="post_priority"  class="form-control" placeholder="" value="{{ $postDetails->getData('post_priority')  }}"  required/>
								</div>
							</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="post_status" class="col-form-label">Status</label>
								<select class="form-control" id="post_status" name="post[status]">
									<option {{ ( $postDetails->getData('post_status') == 1 )? 'selected' : '' }} value="1">Publish</option>
									<option {{ ( $postDetails->getData('post_status') == 2 )? 'selected' : '' }} value="2">Unpublish</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row mg-b-20 ">
						<div class="col-sm-12">
							<div class="button-control-wrapper">
								<div class="form-group">
									<input class="btn btn-primary" type="submit" name="updatebtnsubmit" value="Update"  />
									<a href="{{ route('post_index',$postType) }}" class="btn btn-danger">Close</a>
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
<script src="{{  asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
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
	PGSADMIN.utils.createMediaUploader("{{ route('post_media_create',['slug'=>$postType]) }}","#galleryWrapper" ,"{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/" );
	PGSADMIN.utils.createAjaxFileUploader("{{ route('post_media_create',['slug'=>$postType]) }}" ,"{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/" );



});
</script>
@stop