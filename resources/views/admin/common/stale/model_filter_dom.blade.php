<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<h5 class="card-header">{{ lang('search') }}</h5>
			<div class="card-body">
				{{ Form::open(array('method'=>'get' )) }}
					@if(!empty($filters))
						<div class="row" >
						@foreach($filters as $inputName => $filter)
							
							<div class="col-sm-3">
								<div class="form-group">
									<label>{{ lang($filter['title']) }}</label>
									@if($filter['type'] == 'dropdown')
										<select name="{{ $inputName }}" class="form-control">
											<option value="">{{ lang('select_one') }}</option>
											<?php if(!empty($filter['data'])) { ?>
											<?php foreach($filter['data'] as $data) {   ?>
													
													<option value="{{ $data->{$filter['key']} }}" {!! (Input::get($inputName) == $data->{$filter['key']} ) ? 'selected="selected"' : '' !!}>{{ (isset($data->exists))?$data->getData($filter['value']):lang($data->{$filter['value']}) }}</option>	
												<?php } ?>
											<?php } ?>
										</select>
									@elseif($filter['type'] == 'date')
										<div class="input-group">
											<input type="text" id="{{ $inputName }}"  name="{{ $inputName }}" value="{{ Input::get($inputName) }}" class="form-control {{ !empty($filter['class'])? $filter['class']: '' }}">
										</div>
									@elseif($filter['type'] == 'datetime')
										<div class="input-group">
											<input type="text" id="{{ $inputName }}"  name="{{ $inputName }}" value="{{ Input::get($inputName) }}" class="form-control {{ !empty($filter['class'])? $filter['class']: '' }}">
										</div>
									@else
										<div class="input-group">
											<input type="text" id="{{ $inputName }}"  name="{{ $inputName }}" value="{{ Input::get($inputName) }}" class="form-control {{ !empty($filter['class'])? $filter['class']: '' }}">
										</div>
									@endif
								</div>
							</div>
						@endforeach
						</div>
					@endif
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group float-sm-right">
								<input type="submit" class="btn btn-info btn-flat" name="search" value="{{ lang('search') }}" />	
								<a href="{{ apa(@$resetURL)	 }}"><input type="button" name="filterNow" class=" btn btn-primary" value="{{ lang('reset') }}" /></a> 
							</div>
						</div>
					</div>
				
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>