<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ (Auth::user() && Auth::user()->hasRole('Country Coordinator'))?'rtl':'ltr' }}">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="robots" content="index, follow">
	<meta name="baseurl" content="<?php echo asset('/') ?>" />
	<meta name="device" content="<?php echo (Agent::isMobile() === true )?'true':'false'; ?>" />
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
	<link rel="shortcut icon" href="{{ asset('assets/frontend/dist/images/favicon.png') }}">
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
			window.saveYoutubeURL = "{{ route('save_youtube_video') }}/";
		@endif
	</script>
	@section('styles')
	@include('admin.layouts.cssfiles')
	@show
</head>
<body >
        
        <div class="az-body">
            @yield('content')
        </div>
        @include('admin.layouts.footer')	
	@section('scripts')
		@include('admin.layouts.jsfiles')
	@show
</body>
</html>