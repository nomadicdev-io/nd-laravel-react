@extends('admin.layouts.master')
@section('content')
@section('bodyClass')
@parent
hold-transition skin-blue sidebar-mini
@stop

<div class="az-content-breadcrumb">
    <span>{{lang('manage_privileges')}}</span>
    <span>{{lang('permission')}}</span>
</div>

<div class="row row-xs mg-b-20">
	<div class="col">
	<div class="az-content-label mg-b-5">{{lang('permissions')}}</div>
	<p class="mg-b-20">{{ trans('messages.there_are_x_records_present', ['X' => $permissions->total()]) }}</p>
	</div>
	<div class="col-sm-2 col-md-2">
		<a href="{{ route('generate-permissions') }}" class="btn btn-sm btn-az-primary btn-block">{{ lang('generate_permissions') }}</a>
		<a href="{{ route('permission_create') }}" class="btn btn-sm btn-az-primary btn-block">{{ lang('add_permission') }}</a>
	</div>
</div>

@include('admin.permissions.list_filters')
@include('admin.common.user_message')

<div class="table-responsive">
	<table class="table table-hover mg-t-50 mg-b-0">
		<thead>
			<tr>

				<th scope="col">#</th>

				<th scope="col">{{lang('permissions')}}</th>

				<th scope="col">{{lang('actions')}}</th>


			</tr>
		</thead>
		<tbody>
			@if (count($permissions) > 0)
			<?php $inc = getPaginationSerial($permissions);?>
			@foreach ($permissions as $permission)
			<tr data-entry-id="{{ $permission->id }}">
				<td>{{ $inc++ }}</td>
				<td>{{ $permission->name }}</td>
				<td>
					<div class="btn-icon-list">
						<a title="{{lang('edit')}}" href="{{ apa('permissions/edit/'.$permission->id) }}" class="btn btn-primary btn-icon">
							<i class="typcn typcn-edit"></i>
						</a>
						<a title="{{lang('delete')}}" data-id="{{ $permission->id }}" href="{{ apa('permissions/delete/'.$permission->id) }}" class="deleteRecord btn btn-secondary btn-icon">
						<i class="typcn typcn-trash"></i>
						</a>
					</div>

				</td>

			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="3">@lang('global.app_no_entries_in_table')</td>
			</tr>
			@endif
		</tbody>
	</table>
	{!! $permissions->links() !!}
</div>


@stop