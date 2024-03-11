@extends('admin.layouts.master')
@section('styles')
@parent
<style>

</style>
@stop
@section('content')
  @section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
  @stop
    <div class="card mg-b-20">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Add Translations</h2>
			</div>
		</div>
	</div> 
    {{ Form::open(['url'=>route('create_translation'),'id'=>'createEventForm']) }}
            <div class="card mg-b-20">
                <div class="card">
                    <div class="col-sm-12 card-header form-header">
                        <div class="row align-items-center">
                            <small>Fields marked (<em>*</em>) Are mandatory</small>
                        </div>
                    </div>

              
                    <div class="card-body">
                        <div class="col-sm-12">
                            @include('admin.common.user_message')
                            <div class="clearfix"></div>
                            @if(!empty($languages))
							<div class="row form-group">
								<div class="col-sm-6">
									<label class="col-form-label">Key<em>*</em></label>
									<input type="text" name="key" value="{{ old('key')?? "" }}" class="form-control" placeholder="" required/>
								</div>

								<div class="col-sm-6">
									<label class="col-form-label">Type<em>*</em></label>
									<select name="type" class="form-control" required>
										<option value="messages">Messages</option>
										<option value="validation">Validation</option>
										<option value="months">Months</option>
									</select>
								</div>

							</div>
							<div class="row form-group">
								@foreach($languages as $language)
											<?php $oldText = old('text') ?? "";?>
											<div class="col-sm-6">
												<label class="col-form-label"> {{ $language->name }} Text<em>*</em></label>
												<input type="text" name="text[{{ $language->locale }}]" dir="{{ ($language->locale == 'ar') ? 'rtl' : 'ltr' }}" value="" class="form-control " placeholder="" required />
											</div>
								@endforeach
							</div>
						@endif

                        </div>
                    </div>
                </div>
           </div>
           <div class="card mg-b-20">
                <div class="col-sm-12">
                    <div class="button-control-wrapper">
                        <div class="form-group">
                            <input type="submit" name="createbtnsubmit" id="createbtnsubmit" value="Publish" class="btn btn-success btn-flat">
                            <a href="{{ route('translate_index') }}" class="btn btn-danger  btn-flat">Close</a>
                        </div>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
@stop

@section('scripts')
@parent
<script>
 $(document).ready(function(){
     $('#createEventForm').validate();

 });
</script>

@stop