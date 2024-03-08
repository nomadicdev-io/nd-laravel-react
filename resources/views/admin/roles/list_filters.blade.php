<div id="accordion" class="accordion search_form_wrap" role="tablist" aria-multiselectable="true">
    <div class="card">
      <div class="card-header" role="tab" id="headingOne">
        <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            {{ lang('search') }}
        </a>
      </div><!-- card-header -->

      <div id="collapseOne" data-parent="#accordion" class="collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="card-body searchSection">

              {{ Form::open(array('name'=>'filter-reg','url'=>route('roles-index'),'method'=>'get' )) }}
                 <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">{{ lang('title') }}</label>
                        <input type="text" name="name" class="form-control border {{ !empty(request()->get('name')) ? 'border-green' : '' }}" value="{{request()->get('name')}}" placeholder="{{ lang('filter_by_title') }}" />
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                        <input type="submit" class=" btn btn-success"  value="{{ lang('search') }}"/>
                        <a href="{{ route('roles-index') }}"><input type="button" name="filterNow" class=" btn btn-primary" value="{{ lang('reset') }}" /></a>
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