<div id="accordion" class="accordion search_form_wrap" role="tablist" aria-multiselectable="true">
    <div class="card">
      <div class="card-header" role="tab" id="headingOne">
        <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            {{ lang('search') }}
        </a>
      </div><!-- card-header -->

      <div id="collapseOne" data-parent="#accordion" class="collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="card-body searchSection">

              {{ Form::open(array('name'=>'filter-reg','url'=>route('users'),'method'=>'get' )) }}
                 <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control border {{ !empty(request()->get('name')) ? 'border-green' : '' }}" value="{{request()->get('name')}}" placeholder="{{ lang('name') }}" />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control border {{ !empty(request()->get('email')) ? 'border-green' : '' }}" value="{{request()->get('email')}}" placeholder="{{ lang('email') }}" />
                    </div>
                  </div>
                  {{-- <div class="col-sm-4 ">
                    <div class="form-group">
                        <select name="entity_id" class="form-control">
                        <option value="">{{ lang('entity') }}</option>
                        @if(!empty($entities))
                            @foreach($entities as $entity)
                                <option value="{{ $entity->getId() }}" {{ (request()->get('entity_id') == $entity->getId())?'selected':''}}>{{ $entity->getTitle() }}</option>
                            @endforeach
                        @endif
                    </select>
                    </div>
                  </div> --}}
                  <div class="col-sm-4 ">
                    <div class="form-group">
                        <select name="status" class="form-control">
                        <option value="">{{ lang('status') }}</option>
                        @if(!empty($userStatuses))
                            @foreach($userStatuses as $k => $v)
                                <option value="{{ $k }}" {{ (request()->get('status') == $k) ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        @endif
                    </select>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                        <input type="submit" class=" btn btn-success"  value="{{ lang('search') }}"/>
                        <a href="{{ route('users') }}"><input type="button" name="filterNow" class=" btn btn-primary" value="{{ lang('reset') }}" /></a>
                    </div>
                  </div>
                </div>

              {{ Form::close()}}


        </div>
      </div>
    </div>
</div>

@section('scripts')
@parent
    @if(!empty(request()->all()))
        <script>
            $("a[href='#collapseOne']").click();
        </script>
    @endif
@stop