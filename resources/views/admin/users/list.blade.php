@extends('admin.layouts.master')
@section('content')
@section('bodyClass')
@parent
hold-transition skin-blue sidebar-mini
@stop
<div class="az-content-breadcrumb">
    <span>{{lang('privileges')}}</span>
    <span>{{lang('users')}}</span>
</div>

<div class="row row-xs mg-b-20">
    <div class="col">
      <div class="az-content-label mg-b-5">{{lang('users')}}</div>
      <p class="mg-b-20">{{ trans('messages.there_are_x_records_present', ['X' => $users->total()]) }}</p>
  </div>
  <div class="col-sm-2 col-md-2">
    <a href="{{ route('user-create') }}" class="btn btn-sm btn-az-primary btn-block">{{ lang('add_user') }}</a>
</div>
</div>


@include('admin.users.list_filters')

@include('admin.common.user_message')

<div class="card mt-3">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mt-4">
        <thead>
          <tr>
            <th>#</th>
            <th scope="col">{{lang('name')}}</th>
            <th scope="col">{{lang('email')}}</th>
            <th scope="col">{{lang('role')}}</th>
            <th scope="date">{{lang('date')}}</th>
            <th scope="col">{{lang('status')}}</th>
            <th scope="col">{{lang('actions')}}</th>
        </tr>
    </thead>
    @if(!empty($users) && $users->count() > 0)
    @php
    $inc = getPaginationSerial($users);
    @endphp
    <tbody>
      @foreach($users as $user)
      @php
 
      $statusUrl = route('user-change-status', ['id' => $user->getId(), 'status' => $user->getStatus()]);
      @endphp
      <tr data-user-id="{{ $user->getId() }}">
        <th scope="row">{{ $inc++ }}</th>
        <td>{{ $user->getName() }}</td>
        <td>{{ $user->getEmailAddress() }}</td>
        <td>{!! $user->getRoles(true) !!}</td>
        <td>{{ $user->getCreatedAt() }}</td>
        <td>
            <div data-status-url="{{ $statusUrl  }}" class="change-status az-toggle az-toggle-success {{ ($user->getStatus() == 1) ? "on" : "" }}"><span></span></div>
        </td>
        <td>
          <div class="btn-icon-list">
              <a href="#" title="{{lang('reset_password_mail')}}" class="btn btn-primary btn-icon reset-password "><i class="fa fa-copy"></i></a>
              <a href="#" title="{{lang('reset_password_mail')}}" class="btn btn-primary btn-icon reset-password-mail"><i class="typcn typcn-mail"></i></a>
              <a title="{{lang('edit')}}" href="{{ route('user-edit', ['id' => $user->getId()]) }}" class="btn btn-primary btn-icon"><i class="typcn typcn-edit"></i></a>
  
              {{-- @switch($user->getStatus())
              @case(1)
              <a title="{{lang('change_status')}}" href="{{ $statusUrl  }}" class="btn btn-danger btn-icon"><i class="typcn typcn-delete"></i></a>
              @break
              @case(2)
              <a title="{{lang('change_status')}}" href="{{ $statusUrl }}" class="btn btn-success btn-icon"><i class="typcn typcn-tick"></i></a>
              @break
              @endswitch --}}
              @if($user->is_super_admin!=1)
              <a onclick="return confirm('{{ lang('do_you_want_to_remove_this_user') }}')" title="{{lang('delete')}}" href="{{ route('user-delete', ['id' => $user->getId()]) }}" class="btn btn-danger btn-icon"><i class="typcn typcn-trash"></i></a>
              @endif
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
  
  {!! $users->links('pagination::bootstrap-4') !!}
  
  </div><!-- table-responsive -->
  </div>
</div>
@stop

@section('scripts')
@parent
<script>
  function copyToClipboard(val){
     var dummyContent = val;
     var dummy = $('<input>').val(dummyContent).appendTo('body').select();
     document.execCommand('copy');
     setTimeout(function(){
      dummy.remove();
     }, 1000);
  }

  $(".reset-password, .reset-password-mail").on('click', function(e) {
    e.preventDefault();
    var userId = $(this).closest('tr').attr('data-user-id');

    var _url = "{{ apa('users/reset-password')}}/" + userId;

    var _data = {
      "_token": "{{ csrf_token() }}",
      "sendMail": ($(this).hasClass('reset-password-mail')) ? true : false,
    };

    sendAjax(_url,'post',_data, function(responseData){
          if(!responseData.status){

                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    html: responseData.message,
                    showCloseButton: true,
                    confirmButtonText: "{{lang('ok')}}",
                });

          }else {
                if(responseData.resetPasswordLink){
                  setTimeout(copyToClipboard(responseData.resetPasswordLink), 1000);
                }
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    html: responseData.message,
                    showCloseButton: true,
                    confirmButtonText: "{{lang('ok')}}",
                });
              
          }
      }, true);
      

  });
</script>
@stop