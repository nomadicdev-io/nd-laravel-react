@extends('admin.layouts.master')
@section('content')
  @section('bodyClass')
    @parent
        hold-transition skin-blue sidebar-mini
  @stop

    <div class="row row-xs mg-b-20">
        <div class="col">
            <div class="az-content-label mg-b-5">Data of {{ $registrant->getData('name') }}</div>
        </div>
        <div class="col-sm-2 col-md-2">
            <a href="{{ route('registrations',['formType' => 'user-registrations']) }}" class="btn btn-sm btn-az-primary btn-block">{{ lang('back') }}</a>
        </div>
    </div>


    <div id="wizard1">

      <h3>Ownership Information</h3>
      <section>

        @if(!empty($registrant->getOwnershipInformation()))
        <div class="table-responsive">
            <table class="table table-striped mg-b-0">
              <tbody>
                @foreach($registrant->getOwnershipInformation() as $k => $v)
                <tr>
                @if(!empty($v['isUrl']))
                  <td>{{ $v['label'] }}</td>
                  <td><a href="{{$v['content']}}">Download {{$v['label']}}</a></td>
                @else
                  <td>{{ $v['label'] }}</td>
                  <td>{{ $v['content'] }}</td>
                @endif
                </tr>
                @endforeach
              </tbody>
          </table>
        </div>
        @endif

      </section>
      <h3>Business Information</h3>
      <section>
            @if(!empty($registrant->getBusinessInformation()))
            <div class="table-responsive">
                <table class="table table-striped mg-b-0">
                  <tbody>
                    @foreach($registrant->getBusinessInformation() as $k => $v)
                    <tr>
                    @if(!empty($v['isUrl']))
                      <td>{{ $v['label'] }}</td>
                      <td><a href="{{$v['content']}}">Download {{$v['label']}}</a></td>
                    @else
                      <td>{{ $v['label'] }}</td>
                      <td>{{ $v['content'] }}</td>
                    @endif
                    </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>
            @endif
      </section>

      <h3>Activities</h3>
      <section>
            @if(!empty($registrant->getActivitiesInformation()))
            <div class="table-responsive">
                <table class="table table-striped mg-b-0">
                  <tbody>
                    @foreach($registrant->getActivitiesInformation() as $k => $v)
                    <tr>
                    @if(!empty($v['isUrl']))
                      <td style="width: 35%;">{{ $v['label'] }}</td>
                      <td><a href="{{$v['content']}}">Download {{$v['label']}}</a></td>
                    @else
                      <td style="width: 35%;">{{ $v['label'] }}</td>
                      <td>{{ $v['content'] }}</td>
                    @endif
                    </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>
            @endif
      </section>

      <h3>User Information</h3>
      <section>
        <div class="table-responsive">
            <table class="table table-striped mg-b-0">
                <tbody>
                    <tr>
                        <td style="width: 35%;">Email</td>
                        <td>{{$registrant->getData('email')}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
      </section>

      <h3>Partner(s)</h3>
      <section>
         @if(!empty($registrant->partners))
            @foreach($registrant->partners as $partner)
                @if(!$loop->first)
                <hr/>
                @endif
                <h3>Partner: {{$partner->bp_first_name . ' ' . $partner->bp_last_name}}</h3>
                <div class="table-responsive">
                    <table class="table table-striped mg-b-0">
                      <tbody>
                        <tr>
                            <td style="width: 35%;">Name</td>
                            <td>{{$partner->getFullNameEnglish()}}</td>
                        </tr>

                        <tr>
                            <td style="width: 35%;">Name (Arabic)</td>
                            <td>{{$partner->getFullNameArabic()}}</td>
                        </tr>

                        <tr>
                            <td style="width: 35%;">Date of Birth</td>
                            <td>{{$partner->getDateOfBirth()}}</td>
                        </tr>

                        <tr>
                            <td style="width: 35%;">Gender</td>
                            <td>{{$partner->getGender()}}</td>
                        </tr>

                        <tr>
                            <td style="width: 35%;">Emirates ID Number</td>
                            <td>{{$partner->getEmiratesIdNumber()}}</td>
                        </tr>

                        <tr>
                            <td style="width: 35%;">Email Address</td>
                            <td>{{$partner->getEmailAddress()}}</td>
                        </tr>

                        <tr>
                            <td style="width: 35%;">Phone Number</td>
                            <td>{{$partner->getPhoneNumber()}}</td>
                        </tr>

                        <tr>
                            <td style="width: 35%;">City</td>
                            <td>{{!empty($partner->city) ? $partner->city->getName() : "N/A"}}</td>
                        </tr>

                        <tr>
                            <td style="width: 35%;">Emirates ID</td>
                            <td>
                                <a href="{{ route('view-attachments', ['filename' => $partner->bp_emirates_id_file, 'type' => "partner_emirates_id"]) }}">Download Emirates ID</a>
                            </td>
                        </td>
                      </tbody>
                    </table>
                </div>
            @endforeach
        @endif
      </section>
    </div>
@stop

@section('scripts')
@parent
<script src="{{asset('assets/admin/lib/jquery-steps/jquery.steps.min.js')}}"></script>
<script>
  $(function(){
    'use strict'
    $('#wizard1').steps({
      headerTag: 'h3',
      bodyTag: 'section',
      autoFocus: true,
      enableAllSteps: true,
      enableFinishButton: false,
      enablePagination: false,
      titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>'
    });
  });
</script>
@stop