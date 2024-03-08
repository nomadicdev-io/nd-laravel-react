
<div id="accordion" class="accordion search_form_wrap" role="tablist" aria-multiselectable="true">
    <div class="card">
      <div class="card-header" role="tab" id="headingOne">
        <a data-toggle="collapse" href="#collapseOne"  aria-expanded="{{(!empty(request()->all()))?'true':'false'}}" aria-controls="collapseOne">
            {{ lang('search') }}
        </a>
      </div><!-- card-header -->

      <div id="collapseOne" data-parent="#accordion" class="collapse {{(!empty(request()->all()))?'show':''}}" role="tabpanel" aria-labelledby="headingOne">
        <div class="card-body searchSection">

              {{ Form::open(array('name'=>'filter-reg','method'=>'get' )) }}


                  @if(!empty($filters))
				  <div class="row mg-b-20" >
					@foreach($filters as $key => $filter)
					<div class="col-sm-3">
						<div class="form-group">
							<label>{{ lang($filter['title']) }}</label>
							@if($filter['type'] == 'select')
							<select name="{{ $key }}" class="form-control {{ (!empty(request()->get($key))) ? 'border-green' : '' }} ">
								<option value="">{{lang('select')}}</option>
								<?php if (!empty($filter['data'])) {?>
								<?php foreach ($filter['data'] as $id => $data) {?>
								<option value="{{ $id }}" {!! (request()->get($key) == $id ) ? 'selected="selected"' : '' !!}>{{ $data }}</option>
								<?php }?>
								<?php }?>
							</select>
							@elseif($filter['type'] == 'custom')
							<select name="{{ $key }}" class="form-control {{ (!empty(request()->get($key))) ? 'border-green' : '' }} ">
								<option value="">{{lang('select')}}</option>
								<?php if (!empty($filter['data'])) {?>
								<?php foreach ($filter['data'] as $id => $data) {?>
								<option value="{{ $id }}" {!! (request()->get($key) == $id ) ? 'selected="selected"' : '' !!}>{{ $data }}</option>
								<?php }?>
								<?php }?>
							</select>
							@elseif($filter['type'] == 'number')
							<div class="input-group">
								<input type="number" id="{{ $key }}"  name="{{ $key }}" value="{{ request()->get($key) }}" class="form-control {{ ($filter['q'] == 'datetime') ? 'datepicker' : '' }} {{ (!empty(request()->get($key))) ? 'border-green' : '' }} " {{ ($filter['q'] == 'datetime') ? 'readonly' : '' }}>
							</div>
							@elseif($filter['type'] == 'date_range')
									    <div style="display:flex;">
											<div style="margin-right:5px;">
												<div class="input-group">
													<input type="text" id="{{ $key }}"  name="{{ $key }}" value="{{ request()->get($key) }}" class="form-control {{ ($filter['type'] == 'date_range') ? 'datepicker' : '' }} {{ (!empty(request()->get($key))) ? 'border-green' : '' }} " {{ ($filter['type'] == 'date_range') ? 'readonly' : '' }}>
												</div>
											</div>
											<div style="margin-left:5px;">
												<div class="input-group">
													<input type="text" id="{{ $key }}_to"  name="{{ $key }}_to" value="{{ request()->get($key.'_to') }}" class="form-control {{ ($filter['type'] == 'date_range') ? 'datepicker' : '' }} {{ (!empty(request()->get($key))) ? 'border-green' : '' }} " {{ ($filter['type'] == 'date_range') ? 'readonly' : '' }}>
												</div>
											</div>
										</div>
							@else
							<div class="input-group">
								<input type="text" id="{{ $key }}"  name="{{ $key }}" value="{{ request()->get($key) }}" class="form-control {{ ($filter['q'] == 'datetime') ? 'datepicker' : '' }} {{ (!empty(request()->get($key))) ? 'border-green' : '' }} " {{ ($filter['q'] == 'datetime') ? 'readonly' : '' }}>
							</div>
							@endif
						</div>
					</div>
					@endforeach
				@endif
                  <div class="col-sm-12">
                    <div class="form-group">
                        <input type="submit" class=" btn btn-success"  value="{{ lang('search') }}"/>
                        <a href="{{ \URL::current() }}"><input type="button" name="filterNow" class=" btn btn-primary" value="{{ lang('reset') }}" /></a>
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