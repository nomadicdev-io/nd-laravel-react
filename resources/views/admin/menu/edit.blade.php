@extends('admin.layouts.master')
@section('styles')
@parent
<style>
 .trdisabled{ color:#b5b5b5}
</style>
@stop
@section('content')
  @section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
  @stop
  <div class="az-content-breadcrumb">
    <span>{{lang('master_records')}}</span>
    <span>Create Menu</span>
  </div>

    <div class="row row-xs mg-b-20">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Edit
					<a class="float-sm-right btn btn-outline-dark btn-flat" href="{{ apa('post/menu') }}"><span>Back</span></a></h2>
            </div>
        </div>
    </div>
	<div class="row row-xs mg-b-20">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="col-sm-12 card-header form-header">
                    <div class="row align-items-center">
                        <h5>Fields marked (<em>*</em> ) are mandatory</h5>
                    </div>
                </div>

				{{ Form::open(array('url' => apa('post/menu/edit/'.$postDetails->post_id),'files'=>true)) }}
				<div class="card-body">
					 <div class="col-sm-12">
                            @include('admin.common.user_message')
							<section class="">
								<div class="row">
									<div class="col-sm-12 form-group">
										<label>Parent Menu<em class="red">*</em></label>
										{!! @$menuDropdown !!}
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 form-group">
										<label>Menu Name<em class="red">*</em></label>
										<input type="text" name="post[title]" class="form-control" placeholder="" value="{{ $postDetails->post_title }}"  required />
									</div>

									<div class="col-sm-6 form-group">
										<label>Menu Name [Arabic]<em class="red">*</em></label>
										<input type="text" name="post[title_arabic]" class="form-control" placeholder="" value="{{ $postDetails->post_title_arabic }}"  dir="rtl" required />
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 form-group">
										<label>Menu Large Name</label>
										<input type="text" name="meta[text][large_title]" class="form-control" placeholder="" value="{{ $postDetails->getMeta('large_title') }}"  />
									</div>

									<div class="col-sm-6 form-group">
										<label>Menu Large Name [Arabic]</label>
										<input type="text" name="meta[text][large_title_arabic]" class="form-control" placeholder="" value="{{ $postDetails->getMeta('large_title_arabic') }}"  dir="rtl"/>
									</div>
								</div>


								<div class="row">
									<div class="col-sm-6 form-group">
										<label>Custom Slug</label>
										<input type="text" name="meta[text][menu_slug_url]" class="form-control" placeholder="" value="{{ $postDetails->getMeta('menu_slug_url') }}"  />
									</div>
									<div class="col-sm-6 form-group">
										<label>Menu Icon Class</label>
										<input type="text" name="meta[text][icon_class]" class="form-control" placeholder="" value="{{ $postDetails->getMeta('icon_class') }}"  />
									</div>

								</div>



							</section>
							<section class="basic_settings">
								<h3>Menu Settings</h3>
								<div class="row">
									<div class="col-sm-6">
										<table class="table table-striped table-bordered">
											<thead>
												<tr>
													<th style="width: 10px;text-align:center">Select</th>
													<th>Setting</th>
												</tr>
											</thead>
											<tbody>
												<tr>
												   <td class="text-center">
														<input {{ $postDetails->getMeta('show_in_main_menu') == 1 ? 'checked' : '' }} name="meta[text][show_in_main_menu]" type="checkbox" value="1">
												   </td>
												   <td>
													   {{ Form::label('show_in_main_menu', 'Show in main menu') }}<br>
												   </td>
												</tr>
												<tr>
												   <td class="text-center">
														<input {{ $postDetails->getMeta('show_in_footer_menu') == 1 ? 'checked' : '' }} name="meta[text][show_in_footer_menu]" type="checkbox" value="1">
												   </td>
												   <td>
													   {{ Form::label('show_in_footer_menu', 'Show in footer menu') }}<br>
												   </td>
												</tr>

												<tr>
												   <td class="text-center">
														<input {{ $postDetails->getMeta('is_hash_link') == 1 ? 'checked' : '' }} id="fullHash" name="meta[text][is_hash_link]" type="checkbox" value="1">
												   </td>
												   <td>
													   {{ Form::label('is_hash_link', 'Set hash link') }}<br>
												   </td>
												</tr>
												<tr id="homeHashTR">
												   <td class="text-center">
														<input {{ $postDetails->getMeta('is_hash_link_in_home_only') == 1 ? 'checked' : '' }}  id="homehash" name="meta[text][is_hash_link_in_home_only]" type="checkbox" value="1">
												   </td>
												   <td>
													   {{ Form::label('is_hash_link_in_home_only', 'Show hash link in home only') }}<br>
												   </td>
												</tr>
												<tr>
												   <td class="text-center">
														<input {{ $postDetails->getMeta('visible_to_auth_user') == 1 ? 'checked' : '' }} name="meta[text][visible_to_auth_user]" type="checkbox" value="1">
												   </td>
												   <td>
													   {{ Form::label('visible_to_auth_user', 'Visible to Authenticated User?') }}<br>
												   </td>
												</tr>
											</tbody>
										 </table>
									</div>
								</div>
							</section>
							<section class="basic_settings">
								<div class="row">
									 <div class="col-sm-6 form-group">
										<label>Menu Display Priority</label>
										<input type="number" name="post[priority]" class="form-control" placeholder="" value="{{ $postDetails->post_priority  }}"  min="1" />
									</div>
									<div class="col-sm-6 form-group">
										<label>Status<em class="red">*</em></label>
										<select name="post[status]" class="form-control">
										  <option value="1" {!! ($postDetails->post_status == '1' ) ? 'selected="selected"' : '' !!}>Activate</option>
										  <option value="2" {!! ($postDetails->post_status  == '2' ) ? 'selected="selected"' : '' !!}>Deactivate</option>
										 </select>
									</div>
								</div>
							</section>

						<div class="form-group">
							 <input type="submit" name="updatebtnsubmit" value="Submit"  class="btn btn-success btn-flat">
							 <a href="{{  apa('post/menu') }}" class="btn btn-danger btn-flat">Close</a>
						</div>

					</div>
				</div>

			{{ Form::close() }}

            </div>
        </div>
    </div>

@stop

@section('scripts')
@parent
<script>
 $(document).ready(function(){

 	 @if(!empty($postDetails->post_parent_id))
	 	 $("#menu_parent_id").val('{{ $postDetails->post_parent_id}}');
	 	 $("#menu_parent_id").select2({});
 	 @endif

     $('#post-form').validate();
	 $('#fullHash').on('change',function(){
        if($('#fullHash').is(':checked')){
            $('#homehash').attr('disabled',true);
            $('#homeHashTR').addClass('trdisabled');
        }else{
            $('#homehash').attr('disabled',false);
             $('#homeHashTR').removeClass('trdisabled');
        }
    });

	$('select[name="categories"]').val('{{$postDetails->mm_parent_id}}')
});

</script>
@stop