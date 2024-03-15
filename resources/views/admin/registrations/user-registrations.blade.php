@extends('admin.layouts.master')
@section('styles')
@parent
<style>
.btn-light {
  background-color: white;
}
</style>
@stop
@section('content')
@section('bodyClass')
@parent
hold-transition skin-blue sidebar-mini
@stop
<div class="dashboard-content">
  <div class="row mg-b-30">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="page-header">
        <h2 class="pageheader-title">User Registrations
          <a class="float-sm-right" href="{{ apa('export-excel-list/user-registrations', true) }}">
            <button class="btn btn-success btn-flat">Download Excel</button>
          </a>
          <a class="float-sm-right" href="{{ apa('export-zip-archive/user-registrations', true) }}">
            <button class="btn btn-primary btn-flat">Download Zip</button>
          </a>
        </h2>
      </div>
    </div>
  </div>

  {!! $filterDOM !!}

  <div class="row mg-t-30">
   <div class="col-sm-12">
    @include('admin.common.user_message')
    <div class="ajax-message-wrapper"></div>
  </div>
  <!-- ============================================================== -->
  <!-- striped table -->
  <!-- ============================================================== -->
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="col-sm-12 card-header my-table-header">
        <div class="row align-items-center">
          <div class="col-sm-6"><h5 class="">{{ $submissionList->total() }} results found.</h5></div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive-md">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Approval Status</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
                <th scope="col">Date posted</th>
              </tr>
            </thead>
            <tbody>
              @if( !empty($submissionList) && $submissionList->count() >0 )
              <?php $inc = getPaginationSerial($submissionList);?>
              @foreach($submissionList as $item)
              @php
                $statusUrl = route('user-change-status', ['id' => $item->getId(), 'status' => $item->getStatus()]);
              @endphp
              <tr data-cc-id="{{$item->getId()}}">
                <th scope="row">{{ $inc++ }}</th>
                <td>{{$item->getName()}}</td>
                <td>{{$item->getEmailAddress()}}</td>
                <td>{{$item->getPhoneNumber()}}</td>


                <td>
                    @if($item->user_approved == 3)
                      <span class="badge badge-warning">Pending</span>
                    @elseif($item->user_approved == 2)
                      <span class="badge badge-danger">Rejected</span>
                    @elseif($item->user_approved == 1)
                      <span class="badge badge-success">Approved</span>
                    @endif
                </td>

                <td>
                  <div data-status-url="{{ $statusUrl  }}" class="change-status az-toggle az-toggle-success {{ ($item->getStatus() == 1) ? "on" : "" }}"><span></span></div>
                </td>

                <td>
                    @if($item->user_approved == 3)
                      <a href="{{ route('change-registrant-status', ['id' => $item->getId(), 'status' => 1]) }}" class="btn btn-sm btn-success">Approve</a>
                      <a href="{{ route('change-registrant-status', ['id' => $item->getId(), 'status' => 2]) }}" class="btn btn-sm btn-danger">Reject</a>
                    @endif
                    <a href="{{ route('registrant-details', ['registerType' => 'user-registrations', 'id' => $item->getId()]) }}" class="btn btn-sm btn-info" data-user-id="{{$item->getId()}}">View Details</a>
                </td>

                <td>{{$item->getCreatedAt()}}</td>
              </tr>
              @endforeach
              <tr>
               <td colspan="10">{{ $submissionList->links() }}</td>
             </tr>
             @else
             <tr class="no-records">
               <td colspan="7" class="text-center text-danger">No records found!</td>
             </tr>
             @endif
           </tbody>
         </table>
       </div>
     </div>
   </div>
 </div>
 <!-- ============================================================== -->
 <!-- end striped table -->
 <!-- ============================================================== -->
</div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrant Details</h5>
        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <div id="modalBody" class="modal-body"></div>
      {{-- <div class="modal-footer"> --}}
        {{-- <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a> --}}
        {{-- <a href="#" class="btn btn-primary">Save changes</a> --}}
      {{-- </div> --}}
    </div>
  </div>
</div>

@stop

@section('scripts')
@parent
<script>
  function sendAjax(url,type,dataToSend,func,loaderDivID){
    if(loaderDivID){ $(loaderDivID).addClass('show'); }
    $.ajax({
      url:url,
      type:type,
      async:false,
      data:dataToSend,
      dataType:'json',
      statusCode: {
        302:function(){ console.log('Forbidden. Access Restricted'); },
        403:function(){ console.log('Forbidden. Access Restricted','403'); },
        404:function(){ console.log('Page not found','404'); },
        500:function(){ console.log('Internal Server Error','500'); }
      },
      error: function(res) {
        console.log(res.responseText);
      }
    }).done(function(responseData){
      func(responseData);

    }).always(function(){
      if(loaderDivID){$(loaderDivID).removeClass('show');}
    });
  }
</script>
@stop