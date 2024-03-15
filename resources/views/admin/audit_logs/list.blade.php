@extends('admin.layouts.master')
@section('styles')
@parent
@stop
@section('content')
@section('bodyClass')
@parent
hold-transition skin-blue sidebar-mini
@stop

<div class="az-content-breadcrumb">
	<span>{{lang('privileges')}}</span>
	<span>{{lang('audit_logs')}}</span>
</div>

<div class="row row-xs mg-b-20">
    <div class="col">
      <div class="az-content-label mg-b-5">{{lang('audit_logs')}}</div>
      <p class="mg-b-20">{{ trans('messages.there_are_x_records_present', ['X' => $auditList->total()]) }}</p>
    </div>
</div>

@include('admin.common.user_message')

<?php /* <div class="card mt-3">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mt-4">
        <thead>
          <tr>
           <th>#</th>
            <th>{{lang('ip')}}</th>
           <!-- <th>{{lang('url')}}</th> -->
            <th>{{lang('actions')}}</th>
            <th>{{lang('user')}}</th>
            <th>{{lang('date')}} {{ lang('and')}} {{ lang('time')}}</th>
            <th>{{lang('view')}}</th>
          </tr>
        </thead>
        @if(!empty($auditList) && $auditList->count() > 0)
          @php
              $inc = getPaginationSerial($auditList);
          @endphp
        <tbody>
          @foreach($auditList as $audit)
          <tr>
            <th scope="row">{{ $inc++ }}</th>
            @php
           $auditUrl = (substr($audit->url, -1) == "?") ? substr($audit->url,0,-1) : $audit->url;
          @endphp
            <td>{{ $audit->ip_address }}</td>
            <!-- <td>{{ $auditUrl }}</td> -->
            <td>{{ ucfirst($audit->event) }}</td>
          <td>{{ isset($audit->user) ? ucfirst($audit->user->name) : "N/A" }}</td>
          <td style="font-size:11px">{{ date('d M,Y h:i a',strtotime($audit->created_at)) }}</td>
          <td>
                      <div class="btn-icon-list">
      
                          <a title="{{lang('view')}}" href="http://localhost/apnf/public" data-fancybox data-type="ajax" class="btn btn-primary btn-icon"><i class="icon ion-md-eye"></i></a>
      
                      </div>
                    </td>
          </tr>
          @endforeach
        </tbody>
        @else
        <tbody>
          <tr class="no-records">
              <td colspan="7" class="text-center text-danger">{{lang('no_records_found')}}</td>
          </tr>
        </tbody>
        @endif
      </table>
     
      {!! $auditList->links('pagination::bootstrap-4') !!}
     
     </div><!-- table-responsive -->
  </div>
</div> */ ?>

<div class="card mt-3">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mt-4">
        <thead>
          <tr>
             <th>#</th>
             <th>Model</th>
            <th>Action</th>
            <th>User</th>
            <th>Time</th>
            <!-- <th>Old Values</th>       
            <th>New Values</th> -->
            <th>Url</th>
            <th>Ip_adrress</th>       
            <th>Navegador</th>
            <th>{{lang('view')}}</th>
          </tr>
        </thead>
        @if(!empty($auditList) && $auditList->count() > 0)
          @php
              $inc = getPaginationSerial($auditList);
          @endphp
        <tbody>
          @foreach($auditList as $audit)
          <tr>
            <td scope="row">{{ $inc++ }}</td>
            <td>{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
            <td>{{ $audit->event }}</td>
            <td>{{ $audit->user->name ?? "" }}</td>
            <td>{{ $audit->created_at }}</td>                            
            <!-- <td>
                <table class="table table-bordered table-hover" style="width:100%">
                    @foreach($audit->old_values as $attribute  => $value)                                 
                        <tr>
                            <td><b>{{ $attribute  }}</b></td>
                            <td>{{ $value }}</td>
                        </tr>                                  
                    @endforeach
                </table>
            </td>                    
            <td>
                <table class="table table-bordered table-hover" style="width:100%">
                    @foreach($audit->new_values as  $attribute  => $data)
                        <tr>
                            <td><b>{{  $attribute  }}</b></td>
                            <td>{{ $data }}</td>
                        </tr>
                    @endforeach
                </table>
            </td> -->
            <td>{{ $audit->url }}</td>
            <td>{{ $audit->ip_address }}</td>
            <td>{{ $audit->user_agent }}</td> 
            <td>
              <div class="btn-icon-list">
                  <a title="{{lang('view')}}" href="{{route('audit-logs-details',[$audit->id])}}" data-fancybox data-type="ajax" class="btn btn-primary btn-icon"><i class="icon ion-md-eye"></i></a>

              </div>
            </td>
           
          </tr>
          @endforeach
        </tbody>
        @else
        <tbody>
          <tr class="no-records">
              <td colspan="7" class="text-center text-danger">{{lang('no_records_found')}}</td>
          </tr>
        </tbody>
        @endif
      </table>
     
      {!! $auditList->links('pagination::bootstrap-4') !!}
     
     </div><!-- table-responsive -->
  </div>
</div>

@stop
@section('scripts')
@parent
@stop