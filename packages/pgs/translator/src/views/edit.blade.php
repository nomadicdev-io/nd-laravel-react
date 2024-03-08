@extends('admin.layouts.master') 
@section('metatags')
<meta name="description" content="{{@$websiteSettings->site_meta_description}}" />
<meta name="keywords" content="{{@$websiteSettings->site_meta_keyword}}" />
<meta name="author" content="{{{@$websiteSettings->site_meta_title}}}" /> 
@stop 
@section('seoEventTitle')
<title>Edit {{ $policy->ra_title }}</title>
@stop @section('styles') 
@parent 
{{ HTML::style('assets/admin/plugins/iCheck/square/blue.css') }} 
{{ HTML::style('assets/admin/dist/css/sweetalert.css') }} 
<style>
ul.EventCheckboxUL {
    list-style: none;
    padding: 0;
    margin: 0;
}
ul.EventCheckboxUL li{ padding:0 0 5px 0;font-weight:bold}
.errorInput{border:1px solid red;}
</style>
<style>
	#EventTypeLoader img{max-height: 24px; margin-left: 10px;}
	.manage ul{
		padding: 0 !important;
		display: inline-block;
	}
	.manage li{
		float: left;
		width: 50px;
	}
	.Event_meta{
		list-style-type: none;
		padding: 0;
	}
	.Event_meta > li:first-child {
		font-size: 15px;
		letter-spacing: 0.02em;
		font-weight: 600;
	}
	.Event_meta > li:last-child {
		margin-top: 8px;
	}
	.Event_meta > li:last-child {
		padding: 0;
	}
	.Event_meta > li:last-child .label{
		margin:0 2px;
		line-height: normal;
		padding: 0 10px;
	}
	.Event_meta > li:last-child .label:first-child{
		margin-left: 0px;
	}
	.Event_meta > li:last-child .label:last-child{
		margin-right: 0px;
	}
	.Event_meta > li .label{
		font-weight: normal;
		font-size: 12px;
	}
	label , input  {
	border-radius: 0 !important;
	}
  </style>
@stop 
@section('content') 
	@section('bodyClass') 
		@parent 
		hold-transition skin-blue sidebar-mini
	@stop
<aside class="right-side">
	<section class="content">
		<div class="box box-warning">
			<div class="box-header">
				<h3 class="col-sm-6 box-title">Edit {{ $policy->ra_title }}</h3>
				<a class="pull-right" href="{{ route('list_policy') }}"><button class="btn btn-success btn-flat">View Policy List</button></a>
			</div>
			<!-- /.box-header -->
			<div class="box-body admin">
				<div class="col-sm-12">
					<p style="margin-top: 10px;" class="text-muted well well-sm no-shadow">
						NB: <em class="red">*</em> denoted fields are mandatory
					</p>
				</div>
				<div class="col-sm-12">
				@if (!empty($userMessage))
				<div>
					{!! $userMessage !!}
				</div>
				@endif
         
					{{ Form::open(['url'=>route('edit_policy',$policy->getId()),'id'=>'editRankingForm']) }}
						<section class="basic_settings">
							<div class="row">
								<?php if($websiteSettings->disable_language != 1){ ?>	
									<div class="col-sm-6">
										<label> Policy Name<em class="red">*</em></label>
										<input type="text" name="pm_title" value="{{ $policy->pm_title }}" class="form-control editor" placeholder="Title Here" />
									</div>
								<?php } ?>
								<?php if($websiteSettings->disable_language != 2){ ?>
									<div class="col-sm-6">
										<label> Policy Name[Arabic]<em class="red">*</em></label>
										<input type="text" name="pm_title_arabic" dir="rtl" value="{{ $policy->pm_title_arabic }}" class="form-control editorAr" placeholder="Arabic Title Here" />
									</div>
								<?php } ?>
							</div>
							
							<div class="row">
								<?php if($websiteSettings->disable_language != 1){ ?>	
									<div class="col-sm-6">
										<label> Policy Sub title<em class="red">*</em></label>
										<input type="text" name="pm_sub_title" value="{{ $policy->pm_sub_title }}" class="form-control " placeholder="Title Here" />
									</div>
								<?php } ?>
								<?php if($websiteSettings->disable_language != 2){ ?>
									<div class="col-sm-6">
										<label> Policy Sub title[Arabic]<em class="red">*</em></label>
										<input type="text" name="pm_sub_title_arabic" dir="rtl" value="{{ $policy->pm_sub_title_arabic }}" class="form-control " placeholder="Arabic Title Here" />
									</div>
								<?php } ?>
							</div>
							
							<div class="row">
								<?php if($websiteSettings->disable_language != 1){ ?>	
									<div class="col-sm-6">
										<label> Policy Description<em class="red">*</em></label>
										<textarea name="pm_description"  class="form-control enInput editor" placeholder="Title Here" >{!! $policy->pm_description !!}</textarea>
									</div>
								<?php } ?>
								<?php if($websiteSettings->disable_language != 2){ ?>
									<div class="col-sm-6">
										<label> Policy Description[Arabic]<em class="red">*</em></label>
										<textarea name="pm_description_arabic" dir="rtl" class="form-control arInput editorAr" placeholder="Arabic Title Here" >{!! $policy->pm_description_arabic !!}</textarea>
									</div>
								<?php } ?>
							</div>
							<hr/>
							<div class="row"> 
								
									<div class="col-sm-4">
										{!! getPlUploadControl('Policy Image [1032 X 951]','pm_image',['jpg','png','jpeg'],'image','Select File',null,null,$policy->pm_image,'policy_main') !!}
									</div>

									<div class="col-sm-4">
										{!! getPlUploadControl('Policy Video Image [500 X 500]','pm_youtube_image',['jpg','png','jpeg'],'image','Select File',null,null,$policy->pm_youtube_image,'policy_video') !!}
									</div>

									<div class="col-sm-4">
										{!! getPlUploadControl('Policy Video GIF [400 X 400]','pm_video_gif_image',['gif'],'image','Select File',null,null,$policy->pm_video_gif_image,'pm_video_gif_image') !!}
									</div>

									<div class="col-sm-4">
										{!! getPlUploadControl('Policy Details Page Image [700 X 625]','pm_details_image',['jpg','png','jpeg'],'image','Select File',null,null,$policy->pm_details_image,'pm_details_image') !!}
									</div>

							</div>

							
							<div class="row">
								<div class="col-sm-4">
									<label> Policy Video YouTube URL</label>
									<input type="text" name="pm_youtube_url" value="{{ $policy->pm_youtube_url }}" class="form-control enInput" placeholder="Policy source URL / Name"  />
								</div>
								<div class="col-sm-4">
									<label>Status</label>
									<select name="pm_status" class="form-control" required>
										<option value="1" style="font-weight:bold;color:green" {{ $policy->isActive() ? 'selected' : '' }}>Activate</option>
										<option value="2" {{ !$policy->isActive() ? 'selected' : '' }}>Deactivate</option>
									</select>
								</div>
								
								<div class="col-sm-4">
									<label>Highlight This Policy ?</label>
									<select name="pm_highlight" class="form-control" required>
										<option value="1" {{ $policy->isHighlighted()  ? 'selected' : '' }}>Yes</option>
										<option value="2" {{ !$policy->isHighlighted() == 2 ? 'selected' : '' }}>No</option>
									</select>
								</div>
							</div>
							
						</section>
						<div class="form-group"></div>
						<div class="form-group">
							<input type="submit" name="updatebtnsubmit" id="updatebtnsubmit" value="Publish" class="btn btn-success btn-flat">
							<a href="{{ route('list_policy') }}" class="btn btn-danger  btn-flat">Close</a>
						</div>
					{{ Form::close() }}
				</div>
				<!-- /.col-sm-12 -->
			</div>
			<!-- /.box-body -->
		</div>
	</section>
	<!-- /.content -->
</aside>
@stop
@section('styles')
@parent
@stop
@section('scripts') 
@parent
<script src="<?php echo asset('assets/admin/plugins/flatdatetimepicker/flatpickr.min.js'); ?>" type="text/javascript"></script>
<script>
	$(function(){
		$('.datetimepicker').datetimepicker({
			format:"DD-MM-YYYY hh:mm A",
		});
	});
	
</script>
@stop