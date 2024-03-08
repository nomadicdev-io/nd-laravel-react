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

	{{ Form::open(array('url' => array(apa('post/'.$postType.'/edit/'.$postDetails->getData('post_id'))),'files'=>true,'id'=>'add-form')) }}
		<input type="hidden" name="post[type]" value="{{$postType}}" />		
		
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
									<input type="text" name="post[title]" id="post_title" class="form-control" placeholder="" value="{{$postDetails->post_title }}" required/>
								</div>	
								<div class="col-sm-6 form-group">
									<label for="title_arabic" class="col-form-label">Title [Arabic]<em>*</em></label>
									<input type="text" name="post[title_arabic]" id="post_title_arabic" dir="rtl" class="form-control" placeholder="" value="{{$postDetails->post_title_arabic }}" required />
								</div> 
								<div class="col-sm-6 form-group">
									<label for="publish_date" class="col-form-label">Date</label>
									<input autocomplete="off" type="text" id="publish_date" name="meta[date][publish_date]" class="form-control datepicker" value="{!! $postDetails->formatDate('publish_date','m/d/Y') !!}">  
							   </div> 
								
							</div>
							<div class="row mg-b-20 "> 	
									@php 
										$uploaderArr = [
															[
																'label'=>'Gallery Banner (2mb)',
																'control_name'=>'gallery_banner',
																'type'=> 'image',
																'old_file_name'=> $postDetails->getData('gallery_banner'),
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
			</div>
		
		@include('admin.common.media_gallery')

		<div class="card mg-b-20">
				<div class="card">
					<div class="card-body">
					<div class="row mg-b-20 ">
				        	<div class="col-sm-6">
								<div class="form-group">
									<label for="post_status" class="col-form-label">Display Priority</label>
									<input type="number" min="1" name="post[priority]" id="post_priority"  class="form-control" placeholder="" value="{{ $postDetails->getData('post_priority') }}"  required/>
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
		</div>
	{{ Form::close() }}

@stop

@section('scripts') 
@parent
<script src="{{  asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>

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