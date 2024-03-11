@extends('admin.layouts.master')
@section('content')
  @section('bodyClass')
    @parent
        hold-transition skin-blue sidebar-mini
  @stop

    <div class="az-content-breadcrumb">
        <span>{{lang('master_records')}}</span>
        <span>Mail Templates</span>
    </div>
    <div class="row row-xs mg-b-20">
        <div class="col">
            <div class="az-content-label mg-b-5">Manage Mail Templates</div>
            <p class="mg-b-20">Total {{ $MailTemplateList->count() }} records</p>
        </div>
        <div class="col-sm-2 col-md-2">
            <a href="{{ route('admin_mailtemplate_create') }}" class="btn btn-sm btn-az-primary btn-block">{{ lang('create_new') }}</a>
        </div>
    </div>

    @include('admin.common.user_message')

    <div class="table-responsive">
    <table class="table table-hover mg-t-50 mg-b-0">
      <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Subject</th>
                <th>Action</th>
                <th>Manage</th>
            </tr>
      </thead>

      <tbody>

            @if( !empty($MailTemplateList) && $MailTemplateList->count() >0 )
                    @php $inc = getPaginationSerial($MailTemplateList);     @endphp
                    @foreach($MailTemplateList as $template)
                        <tr>
                            <th scope="row">{{ $inc++ }}</th>
                            <td>{!! $template->mt_title !!}</td>
                            <td>{!! $template->mt_subject !!}</td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input class="form-control" type="email" placeholder="Send test email - EN" name="test_email" data-template-id="{{$template->mt_id}}" data-lang="en" />
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="email" placeholder="Send test email - AR" name="test_email" data-template-id="{{$template->mt_id}}" data-lang="ar" />
                                    </div>
                                </div>
                            </td>
                            <td class="manage">
                                
                                <div class="btn-icon-list">
                                   <a  href="<?php echo asset(Config::get('app.admin_prefix') . '/mail-templates/edit/' . $template->mt_id); ?>"  title="edit" class="btn btn-primary btn-icon"><i class="typcn typcn-edit"></i></a>
                                   
                               </div>
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
         {!! $MailTemplateList->links('pagination::bootstrap-4') !!}
  </div><!-- table-responsive -->
@stop
@section('scripts')
@parent
<script type="text/javascript">
    $('input[name="test_email"]').on('blur', function(){
        if($(this).val()) {
            $.ajax({
                type: "POST",
                url: "{{apa('mail-templates/test-mail-template')}}/" + $(this).attr('data-template-id'),
                async: false,
                data: {
                    '_token': "{{csrf_token()}}",
                    'langSelected': $(this).attr('data-lang'),
                    'emailAddress': $(this).val(),
                },
                dataType: 'json',
            })
            .done(function(response) {
                    swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: response.message,
                        confirmButtonText: "{{lang('ok')}}",
                        confirmButtonColor:'#000',
                        closeOnConfirm: false
                    })
                
            })
            .fail(function(response) {
                
                swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: response.message,
                        confirmButtonText: "{{lang('ok')}}",
                        confirmButtonColor:'#000',
                        closeOnConfirm: false
                    })
            })
        }
    });
</script>
@stop