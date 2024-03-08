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
 <div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{ $pageTitle }} 
				<?php /*<a class="float-sm-right" href="{{ apa('hub-manager') }}"><button class="btn btn-outline-dark btn-flat">Hub Manager</button></a></h2> */ ?>
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="col-sm-12 card-header form-header">
                    <div class="row align-items-center">
                        <h5>Fields marked (<em>*</em>) Are mandatory</h5> 
                    </div>
                </div>
                
               {{ Form::open(['url'=>route('create_translation'),'id'=>'createEventForm']) }}
                    <div class="card-body">
                        <div class="col-sm-12">
                            @include('admin.common.user_message')
                            <div class="clearfix"></div>
                            @if(!empty($languages))
							<div class="row form-group">
								<div class="col-sm-6">
									<label>Key<em class="red">*</em></label>
									<input type="text" name="key" value="{{ old('key') }}" class="form-control" placeholder="" required/>
								</div>
							
								<div class="col-sm-6">
									<label>Type<em class="red">*</em></label>
									<select name="type" class="form-control" required>
										<option value="messages">Messages</option>
										<option value="validation">Validation</option>
										<option value="months">Months</option>
									</select>
								</div>
							
							</div>
							<div class="row form-group">
								@foreach($languages as $language)
											<?php $oldText = old('text'); ?>
											<div class="col-sm-6">
												<label> {{ $language->name }} Text<em class="red">*</em></label>
												<input type="text" name="text[{{ $language->locale }}]" dir="{{ ($language->locale == 'ar') ? 'rtl' : 'ltr' }}" value="{{ $oldText[$language->locale] }}" class="form-control " placeholder="" required />
											</div>
								
									
								@endforeach
							</div>
						@endif
                                
                        </div>
                    </div>
                    
                    <div class="row">
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
            </div>
        </div>
    </div>
 </div>  
@stop

@section('scripts')
@parent
<script>
 $(document).ready(function(){
     $('#createEventForm').validate();

 });
</script>

@stop