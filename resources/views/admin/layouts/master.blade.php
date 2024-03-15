<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ (App::getLocale() == 'ar')?'rtl':'ltr' }}">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="robots" content="index, follow">
	<meta name="baseurl" content="<?php echo asset('/') ?>" />
	<meta name="device" content="<?php echo (Agent::isMobile() === true) ? 'true' : 'false'; ?>" />
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	@section('metatags')
	
        <meta name="title" content="{{ ($websiteSettings) ? $websiteSettings->post_title : ' Website ' }}" />
        <meta name="description" content="{{  ($websiteSettings) ? $websiteSettings->getMeta('home_page_description_arabic') : 'Description' }}" />
        <meta name="keywords" content="{{ ($websiteSettings) ? $websiteSettings->site_meta_keyword : '' }}" />
	@show
	@section('seoPageTitle')
        <title>{{ ($pageTitle) ? ucwords(str_replace('_',' ',$pageTitle)) : @$websiteSettings->post_title }}</title>
	@show
	<link rel="shortcut icon" href="{{ asset('assets/frontend/dist/images/favicon.ico') }}">
	<!-- Scripts -->
	<script>
		window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
		window.baseURL = "{{ asset('/') }}";
		window.adminPrefix = "{{ Config::get('app.admin_prefix') }}/";
		window.appTrans = {
				invalidFile : " {{ lang('invalid_file') }} ",
				error : "{{lang('error')}}",
				ok : "{{lang('ok')}}",
				areYouSure : "{{lang('are_you_sure')}}",
				cannotRevert : "{{lang('cannot_revert')}}",
				yes : "{{lang('yes')}}",

		};
		@if(\Auth::user())
			window.postMediaDelURL = "{{ apa('post_media/delete') }}/";
			window.saveYoutubeURL = "{{ route('save_youtube_video') }}";
		@endif
	</script>
	<style>
		.az-sidebar {
			background-color: #033053;
		}
		.logoWrapper {
			background: #fff;
			text-align: center;
			padding: 17px;
		}

		#videoTitleAr{
			display:none;
		}
		@if(!empty($hideGalleryText))
		#galleryWrapper .titleTextDiv{
			display:none;
		}
		.YoutubeUploadWrapper .titleTextDiv{
			display:none;
		}
		.gallery-grid .title-text{
			display:none;
		}
		@endif
		@if(!empty($hideGallerySource))
		#galleryWrapper .sourceTextDiv{
			display:none;
		}
		.YoutubeUploadWrapper .sourceTextDiv{
			display:none;
		}
		
		.gallery-grid .source-text{
			display:none;
		}
		
		@endif
		@if(!empty($hideGalleryLang))
		#galleryWrapper .langTextDiv{
			display:none;
		}
		.gallery-grid .lang-dropdown{
			display:none;
		}
		
		.YoutubeUploadWrapper .langTextDiv{
			display:none;
		}
		@endif
	</style>
	@section('styles')
		@include('admin.layouts.cssfiles')
	@show
	{{ HTML::style('assets/admin/css/custom_admin.css') }}
</head>
<body class="{{ ($menuPosition=='top')?'az-dashboard':'az-body az-body-sidebar' }} {{ $menuPosition }}">
	    @if (Auth::user())
			@if($menuPosition == 'top')
				@include('admin.layouts.topMenuLayout')
			@else
				@include('admin.layouts.leftMenuLayout')
			@endif
			@section('scripts')
				@include('admin.layouts.jsfiles')
			@show
		@endif
</body>
</html>