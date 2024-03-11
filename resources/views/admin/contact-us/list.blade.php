@extends('admin.layouts.master')
@section('content')
  @section('bodyClass')
    @parent
        hold-transition skin-blue sidebar-mini
  @stop
 
    <div class="az-content-breadcrumb">
        <span>{{lang('master_records')}}</span>
        <span>{{ucwords(str_replace('-',' ',$postType))}}</span>
    </div>
    <div class="row row-xs mg-b-20">
        <div class="col">
            <div class="az-content-label mg-b-5">Manage {{ucwords(str_replace('-',' ',$postType))}}</div>
            <p class="mg-b-20">Total {{ $post_items->count() }} records</p>
        </div>
        <div class="col-sm-2 col-md-2">
            <a href="{{ route('post_create',$postType) }}" class="btn btn-sm btn-az-primary btn-block">{{ lang('create_new') }}</a>  
        </div>
    </div>
	@include('admin.common.filter_search')
    @include('admin.common.user_message')
    <div class="table-responsive">
    <table class="table table-hover mg-t-50 mg-b-0">
      <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                @if($buttons['status'] )
                    <th scope="col">Current Status</th>
                @endif
                <th scope="col">Update</th>
            </tr>
      </thead>
      
      <tbody>
      
            @if( !empty($post_items) && $post_items->count() >0 )
                    @php $inc = getPaginationSerial($post_items); 	@endphp
                    @foreach($post_items as $item)
                    @php
                        $statusChangeUrl = apa('post/'.$postType.'/changestatus/'.$item->post_id.'/'.$item->post_status,true);
                    @endphp
                        <tr>
                            <th scope="row">{{ $inc++ }}</th>
                            <td>{!!  $item->post_title !!}<br/>
                            
                            @if($buttons['status'] )
                                <td>
                                    {!! getAdminStatusIcon($item->post_status,$statusChangeUrl) !!}
                                </td>
                            @endif
                            <td>
                            {!! getAdminActionIcons($buttons,$postType,$item) !!}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="no-records">
                        <td colspan="7" class="text-center text-danger">No records found!</td>
                    </tr>
                @endif
        
        </tbody>
      </table>
         {!! $post_items->links() !!}
  </div><!-- table-responsive --> 
@stop