@extends('admin.layouts.master')
@section('styles')
@parent
<style>
.border-green{
		border:2px solid #00a65a;
	}.border-red{
		border:2px solid #ff0000;
	}
</style>
@stop
@section('content')
  @section('bodyClass')
    @parent
        hold-transition skin-blue sidebar-mini
  @stop
     <div class="page-header">
		<h2 class="pageheader-title">Export Posts</h2>
	</div>
    <div class="col-sm-12">
            @include('admin.common.user_message')
        </div>
	{{ Form::open(array('url' => array(route('export-posts')),'files'=>true,'id'=>'add-form')) }}
		<div class="card mg-b-20">
				<div class="card">
					<div class="card-body">
					<div class="row mg-b-20 ">
							
							<div class="col-sm-6">
								<div class="form-group">
									<label for="post_type" class="col-form-label">Post Type</label>
									<select class="form-control" id="post_type" name="post_type">
										<option  value="">Select</option>
										@if(!empty($postTypes))
                                            @foreach($postTypes as $type)
                                              <option  value="{{$type->post_type}}">{{ucwords(str_replace('-',' ',$type->post_type))}}</option>
                                            @endforeach
                                        @endif
									</select>
								</div>
							</div>	 
                            <div class="col-sm-6">
								<div class="button-control-wrapper">
									<div class="form-group">
										<input class="btn btn-primary" type="submit" name="btnsubmit" value="Export"  />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
	{{ Form::close() }}
    
      
    <div class="page-header">
        <h2 class="pageheader-title">Import Post Data</h2>
    </div>
    <div class="card mg-b-20">
        {{Form::open([ "url" => route('import-posts'), "name" => "importform", "enctype" => "multipart/form-data", "style" => "text-align: left;margin: 0;" ])}}
        <div class="card">
            <div class="card-body">
                <div class="row mg-b-20 "> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="post_type" class="col-form-label">Upload List (.xlsx)</label>
                            <input style="opacity:1!important;" type="file" accept=".xlsx,.xls,.csv" name="post_import" class="form-control"/>
                        </div>
                    </div>	
                    <div class="col-sm-6">
                        <div class="button-control-wrapper">
                            <div class="form-group">
                                <button style="margin-top: 10px;" class="btn btn-md btn-primary">Import</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
            
        {{Form::close()}}
    </div> 
        
    
        
@stop
@section('scripts')
@parent

@stop