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
        <div class="col-lg-12">
            <div class="row row-xs row-sm--sm">
                <div class="col-sm-6 col-md-2">
                    <div class="card card-dashboard-seventeen">
                        <div class="card-body">
                            <h6 class="card-title">Translator</h6>
                            <div>

                                <h4><a href="{{ apa('translator') }}" />Read More </a></h4>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <div id="flotChart1" class="flot-chart" style="padding: 0px; position: relative;"><canvas
                                    class="flot-base" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas><canvas
                                    class="flot-overlay" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas>
                            </div>
                        </div><!-- chart-wrapper -->
                    </div>
                </div><!-- col -->
                <div class="col-sm-6 col-md-2 mg-t-20 mg-sm-t-0">
                    <div class="card card-dashboard-seventeen">
                        <div class="card-body">
                            <h6 class="card-title">Media</h6>
                            <div>
                                <h4><a href="{{ apa('post/media-uploads') }}" />Read More </a></h4>

                            </div>
                        </div><!-- card-body -->
                        <div class="chart-wrapper">
                            <div id="flotChart2" class="flot-chart" style="padding: 0px; position: relative;"><canvas
                                    class="flot-base" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas><canvas
                                    class="flot-overlay" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas>
                            </div>
                        </div><!-- chart-wrapper -->
                    </div><!-- card -->
                </div><!-- col -->
                <div class="col-sm-6 col-md-2 mg-t-20 mg-md-t-0">
                    <div class="card card-dashboard-seventeen bg-primary-dark tx-white">
                        <div class="card-body">
                            <h6 class="card-title">Bulk Media</h6>
                            <div>
                                <h4><a href="{{ apa('post/media-bulk') }}" />Read More </a></h4>

                            </div>
                        </div><!-- card-body -->
                        <div class="chart-wrapper">
                            <div id="flotChart3" class="flot-chart" style="padding: 0px; position: relative;"><canvas
                                    class="flot-base" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas><canvas
                                    class="flot-overlay" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas>
                            </div>
                        </div><!-- chart-wrapper -->
                    </div><!-- card -->
                </div><!-- col -->
                <div class="col-sm-6 col-md-2 mg-t-20 mg-md-t-0">
                    <div class="card card-dashboard-seventeen bg-primary tx-white">
                        <div class="card-body">
                            <h6 class="card-title">Add Post Type</h6>
                            <div>
                                <h4><a href="{{ apa('add-post-type') }}" />Read More </a></h4>
                            </div>
                        </div><!-- card-body -->
                        <div class="chart-wrapper">
                            <div id="flotChart4" class="flot-chart" style="padding: 0px; position: relative;"><canvas
                                    class="flot-base" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas><canvas
                                    class="flot-overlay" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas>
                            </div>
                        </div><!-- chart-wrapper -->
                    </div>
                </div><!-- col -->
                <div class="col-sm-6 col-md-2 mg-t-20 mg-md-t-0">
                    <div class="card card-dashboard-seventeen bg-primary tx-white">
                        <div class="card-body">
                            <h6 class="card-title">Logs</h6>
                            <div>
                                <h4><a href="{{ apa('logs') }}" />Read More </a></h4>
                            </div>
                        </div><!-- card-body -->
                        <div class="chart-wrapper">
                            <div id="flotChart4" class="flot-chart" style="padding: 0px; position: relative;"><canvas
                                    class="flot-base" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas><canvas
                                    class="flot-overlay" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas>
                            </div>
                        </div><!-- chart-wrapper -->
                    </div>
                </div><!-- col -->
 <div class="col-sm-6 col-md-2 mg-t-20 mg-md-t-0">
                    <div class="card card-dashboard-seventeen bg-primary tx-white">
                        <div class="card-body">
                            <h6 class="card-title">Import Post</h6>
                            <div>
                                <h4><a href="{{ apa('import-posts') }}" />Read More </a></h4>
                            </div>
                        </div><!-- card-body -->
                        <div class="chart-wrapper">
                            <div id="flotChart4" class="flot-chart" style="padding: 0px; position: relative;"><canvas
                                    class="flot-base" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas><canvas
                                    class="flot-overlay" width="189" height="180"
                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 189.328px; height: 180px;"></canvas>
                            </div>
                        </div><!-- chart-wrapper -->
                    </div>
                </div><!-- col -->
            </div><!-- row -->
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
