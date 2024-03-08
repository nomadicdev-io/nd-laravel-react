@extends('admin.layouts.master')
@section('content')
  @section('bodyClass')
    @parent
        hold-transition skin-blue sidebar-mini
  @stop
  <div class="az-content-breadcrumb">
    <span>{{lang('master_records')}}</span>
    <span>Contact request </span>
  </div>
  <div class="az-content-body mg-t-20">
<div class="row row-xs mg-b-20">
    <div class="col">
        <div class="az-content-label mg-b-5">Contact request</div>
        <p class="mg-b-20">Total {{$contactUsDetails->total()}} records</p>
    </div>
    <div class="col-sm-2 col-md-2">
        <a href="{{ route('contact-request-download',request()->all()) }}" class="btn btn-sm btn-az-primary btn-block">{{ lang('download') }}</a>  
    </div>
</div>   
{!! $filterDOM !!}
<div class="row">
    <div class="col-sm-12">
        @include('admin.common.user_message')
    </div>
    <div class="table-responsive">
    <table class="table table-hover mg-t-50 mg-b-0">
        <thead>
            <tr>

                <th scope="col">#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Contact number</th>
                 <th scope="col">Country</th>
                <?php /* <th scope="col">Type</th> */ ?>
                 <th scope="col">Organization Name</th>
                 <th scope="col">Program Interested</th>
                <?php /* <th scope="col">Subject</th> */ ?>
                <th scope="col">Comment</th>
                <th scope="date">Request Date</th>
            </tr>
        </thead>
        <tbody>
            @if( !empty($contactUsDetails) && $contactUsDetails->count() >0 )
                <?php $inc = getPaginationSerial($contactUsDetails);?>
                @foreach($contactUsDetails as $contact)
                    <tr>
                        <th scope="row">{{ $inc++ }}</th>
                        <td>{{$contact->getName()}}</td>
                        <td>{{$contact->getEmail()}}</td>
                        <td>{{$contact->getPhoneNumber()}}</td>
                        <td>{{$contact->getCountryName()}}</td>
                       <?php /* <td>{{$contact->getTypeTitle()}}</td> */ ?>
                        <td>{{$contact->getOrganizationName()}}</td>
                        <td>{{$contact->getProgramTitle()}}</td>
                       <?php /* <td>{{$contact->getSubject()}}</td> */ ?>
                        <td>{{$contact->getMessage()}}</td>
                        <td>{{$contact->getHumanReadableCreatedAt()}}</td>
                    </tr>
                @endforeach
                <tr>
                <td colspan="11">{{ $contactUsDetails->appends(request()->all())->links() }}</td>
                </tr>
            @else
                <tr class="no-records">
                    <td colspan="11" class="text-center text-danger">No records found!</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
</div>
@stop