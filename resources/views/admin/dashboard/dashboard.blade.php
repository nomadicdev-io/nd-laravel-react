@extends('admin.layouts.master')
@section('metatags')
    <meta name="description" content="{{ @$websiteSettings->site_meta_description }}" />
    <meta name="keywords" content="{{ @$websiteSettings->site_meta_keyword }}" />
    <meta name="author" content="{{ @$websiteSettings->site_meta_title }}" />

@stop
@section('seoPageTitle')
    <title>{{ $pageTitle }}</title>
@stop
@section('styles')
    @parent
    {{ HTML::style('assets/admin/lib/morris.js/morris.css') }}
@stop

@section('content')
@section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
@stop

<div class="row">

    <div class="col-lg-12 mg-t-20 mg-lg-t-0">

        @if (!empty($userMessage))
            {!! $userMessage !!}
        @endif

        <div class="card card-dashboard-four">
            <div class="card-header tx-medium bg-gray-300 tx-white">

            </div>


            <div class="card-body ">
                <div class="az-dashboard-one-title">
                    <div>
                        <h2 class="az-dashboard-title">Hi, welcome back!</h2>
                        @if (!empty($wishing) && isset($wishing[0]))
                            <p class="az-dashboard-text">{{ $wishing[0] }}</p>
                        @endif
                    </div>
                </div>
            </div><!-- card-body -->
            <div class="az-content-body">

            </div>
        </div><!-- card-dashboard-four -->
    </div>
</div>
@if (Auth::user()->hasAnyPermission(['Manage Dashboard']) ||
        Auth::user()->is_super_admin == 1 ||
        Auth::user()->hasAnyRole(['Super Admin']))
@else
@endif


@stop

@section('scripts')
@parent
<script src="{{ asset('assets/admin/lib/raphael/raphael.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/lib/morris.js/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/lib/chart.js/Chart.min.js') }}" type="text/javascript"></script>
@stop
