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
<aside class="right-side">         
	<!-- Main content -->
	<section class="content">
		<div class="box ">
			<div class="col-sm-12">	
						
			<h3>Add New </h3>
					
			</div>
			<div class="box-body">
				<div class="clearfix"></div>
				<?php if(!empty($userMessage)) { echo $userMessage; } ?>	

				{{ Form::open(array('url' => array(Config::get('app.admin_prefix').'/country/create'),'files'=>true)) }}										

				<section class="basic_settings">
					<div class="row"> 	
						<div class="col-sm-6 form-group">
							<label>Country Name<em class="red">*</em></label>
							<input type="text" name="country_name" class="form-control" placeholder="" value="{{Input::old('country_name') ?? ""}}"  /> 
						</div>	
						
						<div class="col-sm-6 form-group">
							<label>Country Name [Arabic]<em class="red">*</em></label>
							<input type="text" name="country_name_arabic" class="form-control" placeholder="" value="{{Input::old('country_name_arabic') ?? "" }}" min="1"  dir="rtl"/> 
						</div>	
						
					</div>
					<div class="row"> 	
						<div class="col-sm-6 form-group">
							<label>ISO<em class="red">*</em></label>
							<input type="text" name="country_iso" class="form-control" placeholder="" value="{{Input::old('country_iso') ?? ""}}"  /> 
						</div>	
						
						<div class="col-sm-6 form-group">
							<label>ISO3<em class="red">*</em></label>
							<input type="text" name="country_iso_3" class="form-control" placeholder="" value="{{Input::old('country_iso_3') ?? "" }}" /> 
						</div>						
					</div>	
				</section>
				<section class="basic_settings">
					
					<div class="row"> 	
						

						<div class="col-sm-6 form-group">
							<label>Status<em class="red">*</em></label>
							<select name="country_status" class="form-control">
							  <option value="1" {!! (Input::old('country_status') ?? "" == '1' ) ? 'selected="selected"' : '' !!}>Activate</option>
							  <option value="2" {!! (Input::old('country_status') ?? "" == '2' ) ? 'selected="selected"' : '' !!}>Deactivate</option>
							 </select>
						</div>
						
					</div>
					
				</section>

				<div class="form-group"></div>
				
				<div class="form-group">
					 <input type="submit" name="createbtnsubmit" value="Submit"  class="btn btn-success btn-flat">
					 <a href="<?php echo asset(Config::get('app.admin_prefix').'/country'); ?>" class="btn btn-danger btn-flat">Close</a>
				</div>   

				{{ Form::close() }}

			</div> 				   <!-- /.box-body -->
			</div>
	</section><!-- /.content -->
</aside>
@stop

@section('scripts')
@parent


@stop