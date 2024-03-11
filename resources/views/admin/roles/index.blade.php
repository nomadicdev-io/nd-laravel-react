@extends('admin.layouts.master')
@section('content')
@section('bodyClass')
@parent
hold-transition skin-blue sidebar-mini
@stop

<div class="az-content-breadcrumb">
	<span>{{lang('privileges')}}</span>
	<span>{{lang('roles')}}</span>
</div>

<div class="row row-xs mg-b-20">
    <div class="col">
      <div class="az-content-label mg-b-5">{{lang('roles')}}</div>
      <p class="mg-b-20">{{ trans('messages.there_are_x_records_present', ['X' => $roles->count()]) }}</p>
    </div>
    <div class="col-sm-2 col-md-2">
        <a href="{{ route('roles-create') }}" class="btn btn-sm btn-az-primary btn-block">{{ lang('add_role') }}</a>
    </div>
</div>

@include('admin.roles.list_filters')
@include('admin.common.user_message')

<div class="table-responsive">
	<table class="table table-hover mg-t-50 mg-b-0">
	  <thead>
	    <tr>
	      <th>#</th>
	      <th>{{lang('role')}}</th>
	      <th>{{lang('actions')}}</th>
	    </tr>
	  </thead>
	  @if(!empty($roles) && $roles->count() > 0)
	    @php
	        $inc = getPaginationSerial($roles);
	    @endphp
	  <tbody>
	    @foreach($roles as $item)
	    <tr>
	      <th scope="row">{{ $inc++ }}</th>
	      <td>{{ $item->name }}</td>
	      <td>
	        <div class="btn-icon-list">
	            <a title="{{lang('edit')}}" href="{{ route('roles-edit', ['id' => $item->id]) }}" class="btn btn-primary btn-icon"><i class="typcn typcn-edit"></i></a>
	            <a title="{{lang('delete')}}" href="{{ route('roles-delete', ['id' => $item->id]) }}" class="btn btn-secondary btn-icon"><i class="typcn typcn-trash"></i></a>
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
	{{-- {!! $roles->links() !!} --}}
</div>
@stop