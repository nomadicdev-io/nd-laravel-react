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
				<h2 class="pageheader-title">Add Language</h2>
			</div>
		</div>
	</div> 
    {{ Form::open(['url'=>route('add-language'),'id'=>'createEventForm']) }}
    <div class="card mg-b-20">
       
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12">
                            @include('admin.common.user_message')
                            <div class="clearfix"></div>
                            @if(!empty($languages))
							<div class="row form-group">
								<div class="col-sm-6">
									<label for="locale" class="col-form-label">locale<em>*</em></label>
									<input type="text" name="locale" id="locale" value="{{ old('locale')?? "" }}" class="form-control" placeholder="" required/>
								</div>
                                <div class="col-sm-6">
									<label for="name" class="col-form-label">name<em >*</em></label>
									<input type="text" name="name" id="name" value="{{ old('name')?? "" }}" class="form-control" placeholder="" required/>
								</div>
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
									<input type="submit" name="createbtnsubmit" id="createbtnsubmit" value="Add" class="btn btn-success btn-flat">
									<a href="{{ route('translate_index') }}" class="btn btn-danger  btn-flat">Close</a>
								</div>
                            </div>
                        </div>
                    </div>
            {{ Form::close() }}
            <div class="card mg-b-20">
            <div class="card">
                        <div class="card-body">
                            <div class="table-responsive-md">
                                
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl.No:</th>
                                            <th>Locale</th>
                                            <th>Name</th>
                                            <th width="135px">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if( !empty($languages) && $languages->isNotEmpty() )
                                            @foreach($languages as $key => $langItem)
                                                <tr>
                                                    <td> {{++$key}} </td>
                                                    <td> {{$langItem->locale}}</td>
                                                    <td>{{$langItem->name}}</td>
                                                    <td  class="manage">
                                                         <div class="btn-icon-list">
                                                                <a href="{{ apa('translator/delete-lang/'.$langItem->getId() ,true) }}" class="deleteRecord" title="Delete"><i class="fas fa-trash "></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else

                                            <tr>
                                                <td colspan="4" style="text-align:center">No records found!</td>
                                            </tr>

                                        @endif

                                    </tbody>
                                </table>
                                
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