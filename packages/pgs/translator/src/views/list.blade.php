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
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Translation List
						<a class="pull-right" href="{{ route('create_translation') }}"><button class="btn btn-success btn-flat">Create New Translation</button></a>

					</h2>
                </div>
            </div>
        </div>
        <div class="row">
			<div class="col-sm-12">
				@include('admin.common.user_message')
			</div>
            <!-- ============================================================== -->
            <!-- striped table -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="col-sm-12 card-header my-table-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6"><h5 class="">{{ $translations->count() }} results found.</h5></div>
                            <?php /*<div class="col-sm-6"><h5 class="text-right">Showing {{ $hubList->currentPage() }} of {{  $hubList->total() }} pages</h5></div> */?>
                        </div>
                    </div>
					 <div class="col-sm-12" style="margin-top:10px;">
						{{Form::open(array('method'=>'get','url'=>route('translate_index'),'id'=>"filterForm"))}}
							<div class="row">

								<div class="col-sm-4 form-group">
									<label>Type </label>
									<select name="search_type" id="search_type" class="form-control">
										<option value="">All</option>
										<option value="messages" {{ request()->input('search_type') == 'messages' ? 'selected' : '' }}>Messages</option>
										<option value="validation" {{ request()->input('search_type') == 'validation' ? 'selected' : '' }}>Validation</option>
										<option value="months" {{ request()->input('search_type') == 'months' ? 'selected' : '' }}>Months</option>
								</select>
								</div>

								<div class="col-sm-4 form-group">
									<label>Locale </label>
									<select name="search_locale" id="search_locale" class="form-control">
										<option value="">All</option>
										@if(!empty($languages))
											@foreach($languages as $language)
												<option value="{{ $language->locale }}" {{ request()->input('search_locale') == $language->locale ? 'selected' : '' }}>{{ $language->name }}</option>
											@endforeach

										@endif
								</select>
								</div>


								<div class="col-sm-4 form-group">
								<label>Filter By Key</label>
									<input class="form-control" type="text" name="search_key" id="search_key" value="{{ request()->input('search_key') }}" placeholder="" />
								</div>

								<div class="col-sm-4 form-group">
									<label>Filter By Text</label>
									<input class="form-control" type="text" name="search_text" id="search_text" value="{{ request()->input('search_text') }}" placeholder="" />
								</div>

								<div class="col-sm-4 btnflex">
									<br/>
									<input type="submit" name="search" value="search" class="btn btn-success"/>
								</div>



							</div>
						</div>
						{{Form::close()}}
                    <div class="card-body">
                        <div class="table-responsive-md">
							<?php if (!empty($translations) && is_object($translations)) {?>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
										<th>Sl.No:</th>
										<th>Type</th>
										<th>Key</th>
										<th>Language</th>
										<th>Text</th>
										<th width="135px">Options</th>
									</tr>
                                </thead>
                                <tbody>
									@if( !empty($translations) && !$translations->isEmpty() )
										@foreach($translations as $key => $translation)
											<tr>
												<td> {{ $translations->firstItem() + $key }} </td>
												<td> {!! $translation->group !!}</td>
												<td> {!! $translation->item !!}</td>
												<td> {!! $translation->locale !!}</td>
												<td> <input class="form-control translate" data-id="{{ $translation->getId() }}" type="text" name="translation[{{ $translation->getId() }}]" value='{!! $translation->text !!}' dir="{{ ($translation->locale == 'ar') ? 'rtl' : 'ltr' }}" /></td>

												<td  class="manage">
													<ul>

														<li>
															<a href="{{ apa('translator/delete/'.$translation->getId() ,true) }}" class="deleteRecord" title="Delete"><i class="fas fa-trash "></i></a> <br/>

														</li>
													</ul>
												</td>
											</tr>
										@endforeach
											<tr>
												<td colspan="8">{{ $translations->links() }}</td>
											</tr>
									@else

										<tr>
											<td colspan="8" style="text-align:center">No records found!</td>
										</tr>

									@endif

                                </tbody>
                            </table>
							<?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end striped table -->
            <!-- ============================================================== -->
        </div>



     </div>
@stop
@section('scripts')
@parent
<script>
	$(function(){
		function isArabic(str){
			var arabic = /[\u0600-\u06FF]/;
			return arabic.test(str);
		}

		$('#search_text').on('change',function(){
			var tt= $(this).val();
			if(isArabic(tt)){
				$('#search_text').attr('dir','rtl');
			}else{
				$('#search_text').attr('dir','ltr');
			}
		});

		$("#search_text").bind("paste", function(e){
			var tt= $(this).val();
			if(isArabic(tt)){
				$('#search_text').attr('dir','rtl');
			}else{
				$('#search_text').attr('dir','ltr');
			}
		});

		$('.translate').on('change',function(){
			var _this = $(this);
			var _url = "{{ route('update_translation') }}";
			var _data = {
				token:'{{ csrf_token() }}',
				id:$(this).attr('data-id'),
				value:$(this).val(),
			}
			PGSADMIN.utils.sendAjax(_url,'GET',_data,function(response){
				if(response.status){
					_this.addClass('border-green');
				}else{
					_this.addClass('border-red');
				}

				setTimeout(function(){
					_this.removeClass('border-green border-red');
				},5000);
			});

		});
	})
</script>
@stop