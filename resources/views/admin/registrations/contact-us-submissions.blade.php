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
        <h2 class="pageheader-title">Contact Us Submissions
          <a class="float-sm-right" href="{{ apa('export-excel-list/contact-us-submissions', true) }}">
            <button class="btn btn-success btn-flat">Download Excel</button>
          </a>
        </h2>
      </div>
    </div>
  </div>

  {{-- {!! $filterDOM !!} --}}

  <div class="row">
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
                <th scope="col">Action</th>
                <th scope="col">Submitted on</th>
              </tr>
            </thead>
            <tbody>
              @if( !empty($submissionList) && $submissionList->count() >0 )
              <?php $inc = getPaginationSerial($submissionList);?>
              @foreach($submissionList as $item)
              <tr data-cc-id="{{$item->getId()}}">
                <th scope="row">{{ $inc++ }}</th>
                <td>{{$item->getName()}}</td>
                <td>{{$item->getEmailAddress()}}</td>
                <td>{{$item->getPhoneNumber()}}</td>
                <td><a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal" data-gr-id="{{$item->getId()}}">View Details</a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Contact Request Details</h5>
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

  @if(!empty($registrationData))
      var registrationData = JSON.parse(@json($registrationData));
  @else
      var registrationData = [];
  @endif

  // Find the object by it's key and value
  function findObjectByKeyValue(data, key, value) {
      return data.find(obj => {
          return obj[key] == value;
      });
  }

  var currentRegistrantObj = {};

  $("[data-target]").on('click', function(){
    var html = "";

    currentRegistrantObj = findObjectByKeyValue(registrationData.data, 'cm_id', $(this).attr('data-gr-id'));
    console.log(currentRegistrantObj);

    var createdAt = new Date(currentRegistrantObj.cm_created_at);

    html = `
    <table class="table table-bordered">
      <tbody>
        <tr>
           <td colspan="100%"><b>Name:</b><br/> ` + ((currentRegistrantObj.cm_name) ? currentRegistrantObj.cm_name : "N/A") + `</td>
        </tr>
        <tr>
           <td><b>Phone Number:</b><br/> ` + ((currentRegistrantObj.cm_phone_number) ? currentRegistrantObj.cm_phone_number : "N/A") + `</td>
           <td><b>Email Address:</b><br/> ` + ((currentRegistrantObj.cm_email_address) ? currentRegistrantObj.cm_email_address : "N/A") + `</td>
        </tr>
        <tr>
           <td><b>Subject:</b><br/> ` + ((currentRegistrantObj.subject) ? currentRegistrantObj.subject.post_title : "N/A") + `</td>
           <td><b>Message:</b><br/> ` + ((currentRegistrantObj.cm_message) ? currentRegistrantObj.cm_message : "N/A") + `</td>
        </tr>
        <tr>
          <td colspan="100%"><b>Submitted on:</b><br/> ` + ((currentRegistrantObj.cm_created_at) ? createdAt.toLocaleString() : "N/A") + `</td>
        </tr>
      </tbody>
    </table>
    `;

    $("#modalBody").html(html);

  });
</script>
@stop