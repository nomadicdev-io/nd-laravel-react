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
    <div >
        {{ Form::open(array('name'=>'filter-reg','url'=>route('post_index',[$postType]),'method'=>'get' )) }}				
                <div class="row">						
                <div class="col-sm-4 form-group">
                    <input type="text" name="post_title" class="form-control border {{ !empty(request()->get('post_title')) ? 'border-green' : '' }}" value="{{request()->get('post_title')}}" placeholder="Filter by Title" /> 
                </div>
                
                <div class="col-sm-4 form-group">
                    <input type="submit" class=" btn btn-success"  /> 
                    <a href="{{ route('post_index',[$postType]) }}"><input type="button" name="filterNow" class=" btn btn-primary" value="Reset" /></a> 
                </div>
            </div>
        {{ Form::close()}}
        </div>
       
        <div class="col-sm-12">
            @include('admin.common.user_message')
        </div>
        <div class="table-responsive-md">
    <table class="table table-hover mg-t-50 mg-b-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Image</th>
                <th scope="col">Date</th>
                @if($buttons['status'] )
                    <th scope="col">Status</th>
                @endif
                <th scope="col">Update</th>
            </tr>
        </thead>
        <tbody>
            @if( !empty($post_items) && $post_items->count() >0 )
                <?php $inc = getPaginationSerial($post_items);?>
                @foreach($post_items as $item)
                <?php
                    $statusChangeUrl = apa('post/' . $postType . '/changestatus/' . $item->post_id . '/' . $item->post_status, true);
                    ?>
                    <tr>
                        <th scope="row">{{ $inc++ }}</th>
                        <td><p>{!!  $item->post_title !!} </p><p dir="rtl">{!!  $item->post_title_arabic !!} </p></td>
                        <td><img src="{{PP($item->getData('news_image'))}}" width="100"></td>
                        <td>{{$item->formatDate('news_date')}}</td>
                        
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
    @include('admin.common.pagination_links')
</div>
           
       

@stop
@section('scripts')
@parent
<script>

$('.archived').on('click',function(e){
	   e.preventDefault();
	   var postId =$(this).data('id');
	   var val =($(this).prop('checked'))?1:2;
	   var this_ =$(this);
	   var url = "{{apa('add-to-archive')}}";
       var data_={'postId':postId,'value':val};
	   PGSADMIN.utils.sendAjax(url, 'GET', data_, function (responseData) {
            if (responseData.status==true) {
                Swal.fire('Updated',responseData.message,'success');
                if(val==1){
                    this_.prop('checked',true);
                }else{
                    this_.prop('checked',false);
                }
	             

            } else {
                Swal.fire('Failed',responseData.message,'warning');
            }
        });
   })

</script>
@stop