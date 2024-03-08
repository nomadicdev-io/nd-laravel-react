@extends('admin.layouts.master')
@section('styles')
@parent
@stop
@section('content')
@section('bodyClass')
@parent 
hold-transition skin-blue sidebar-mini
@stop

    <div class="card mg-b-20">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Create {{ucwords(str_replace('-',' ',$postType))}}</h2>
			</div>
		</div>
	</div> 
	{{ Form::open(array('url' => array(apa('post/'.$postType.'/add')),'files'=>true,'id'=>'add-form')) }}
		<input type="hidden" name="post[type]" value="{{$postType}}" />		
		
			<div class="col-sm-12">
				@include('admin.common.user_message')
			</div>
			<!-- ============================================================== -->
			<!-- striped table -->
			<!-- ============================================================== -->
			<div class="card mg-b-20">
				<div class="card">
					<div class="card-body">							
						<section class="basic_settings">
						    <div class="row mg-b-20 "> 	
									<div class="col-sm-6">
										<div class="form-group">
											<label for="post_seo_parent_id" class="col-form-label">Which Page?<em>*</em></label>
											<select class="form-control" id="post_seo_parent_id" name="post[seo_parent_id]" required>
												<option value="">Select page</option>
												
												@if(!empty($pagesArr))
													@foreach($pagesArr as $key=>$pages)
														<optgroup label="{{ucwords(str_replace('-',' ',$key))}}">
														    @foreach($pages as $page)
															   <option value="{{ $page['id'] }}">{{$page['title'] }}</option>
															@endforeach
														</optgroup>
													@endforeach
												@endif
												
											</select>
										</div>
									</div>
							</div>
						    <div class="row mg-b-20 "> 	
							
								<div class="col-sm-6 form-group">
									<label for="post_title" class="col-form-label"> Title <em>*</em></label>
									<input type="text" name="post[title]" id="post_title" class="form-control" placeholder="" value="{{ old('post_title') ?? "" }}" required/>
								</div>	
								<div class="col-sm-6 form-group">
									<label for="title_arabic" class="col-form-label">Title [Arabic]<em>*</em></label>
									<input type="text" name="post[title_arabic]" id="post_title_arabic" dir="rtl" class="form-control" placeholder="" value="{{ old('post_title_arabic') ?? "" }}" required />
								</div> 
								<div class="col-sm-6 form-group">
							         	<label for="seo_description" class="col-form-label">Seo Description Tag <small>(Separated by comma)</small></label>
                                        <input id="seo_description" name="meta[text][seo_description]" type="text" value="" class="form-control">
								</div>
								<div class="col-sm-6 form-group">
								        <label for="seo_canonical" class="col-form-label">Seo Canonical Tag </label>
                                        <input id="seo_canonical" name="meta[text][seo_canonical]" type="text" value="" class="form-control">
								</div>
								
							</div>
							
						</section>	
					</div>
				</div>
			</div>
			<div class="card mg-b-20">
				<div class="card">
					<div class="card-body">							
						<section class="basic_settings">
							<div class="section-block">
								<h3 class="section-title">Open Graph tags</h3>
					        </div>
						    <div class="row mg-b-20 "> 	
								
								
								    <div class="col-sm-6 form-group">
                                        <label for="og_title" class="col-form-label">og:title</label>
                                        <input id="og_title" name="meta[text][og_title]" type="text" value="" class="form-control">
                                    </div>
									<div class="col-sm-6 form-group">
                                        <label for="og_title_arabic" class="col-form-label">og:title [Arabic]</label>
                                        <input id="og_title_arabic" dir="rtl" name="meta[text][og_title_arabic]" type="text" value="" class="form-control">
                                    </div>
									<div class="col-sm-6 form-group">
                                        <label for="og_type" class="col-form-label">og:type</label>
                                        <input id="og_type" name="meta[text][og_type]" type="text" value="" class="form-control">
                                    </div>
									<div class="col-sm-6 form-group">
                                        <label for="og_locale" class="col-form-label">og:locale (optional)</label>
                                        <input id="og_locale" name="meta[text][og_locale]" type="text" value="" class="form-control">
                                    </div>
									<div class="col-sm-6 form-group">
                                        <label for="og_site_name" class="col-form-label">og:site_name (optional)</label>
                                        <input id="og_site_name" name="meta[text][og_site_name]" type="text" value="" class="form-control">
                                    </div>
									<div class="col-sm-6 form-group">
                                        <label for="og_site_name_arabic" class="col-form-label">og:site_name (optional) [Arabic]</label>
                                        <input id="og_site_name_arabic" dir="rtl" name="meta[text][og_site_name_arabic]" type="text" value="" class="form-control">
                                    </div>
									<div class="col-sm-6 form-group">
                                        <label for="og_image" class="col-form-label">og:image</label>
                                        <input id="og_image" name="meta[text][og_image]" type="text" value="" class="form-control">
                                    </div>
									<div class="col-sm-6 form-group">
                                        <label for="og_image_alt" class="col-form-label">og:image:alt (optional)</label>
                                        <input id="og_image_alt" name="meta[text][og_image_alt]" type="text" value="" class="form-control">
                                    </div>
									<div class="col-sm-6 form-group">
                                        <label for="og_description" class="col-form-label">og:description (optional)</label>
                                        <input id="og_description" name="meta[text][og_description]" type="text" value="" class="form-control">
                                    </div>
									<div class="col-sm-6 form-group">
                                        <label for="og_description_arabic" class="col-form-label">og:description (optional) [Arabic]</label>
                                        <input id="og_description_arabic" dir="rtl" name="meta[text][og_description_arabic]" type="text" value="" class="form-control">
                                    </div>
                                
							</div>
							
						</section>	
					</div>
				</div>
			</div>
			<div class="card mg-b-20">
				<div class="card">					
					<div class="card-body">
						<h3>Twitter tags</h3>
						<section class="basic_settings">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group english">
											<label for="twitter_card" class="col-form-label">twitter:card</label>
											<input id="twitter_card" name="meta[text][twitter_card]" type="text" value="" class="form-control">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group english">
											<label for="twitter_title" class="col-form-label">twitter:title</label>
											<input id="twitter_title" name="meta[text][twitter_title]" type="text" value="" class="form-control">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group english">
											<label for="twitter_description" class="col-form-label">twitter:description</label>
											<input id="twitter_description" name="meta[text][twitter_description]" type="text" value="" class="form-control">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group english">
											<label for="twitter_url" class="col-form-label">twitter:url</label>
											<input id="twitter_url" name="meta[text][twitter_url]" type="text" value="" class="form-control">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group english">
											<label for="twitter_image" class="col-form-label">twitter:image</label>
											<input id="twitter_image" name="meta[text][twitter_image]" type="text" value="" class="form-control">
										</div>
									</div>
								</div>
						</section>
					</div>
				</div>
			</div>


		<div class="card mg-b-20">
				<div class="card">
					<div class="card-body">
					<div class="row mg-b-20 ">
							
							<div class="col-sm-6">
								<div class="form-group">
								       <label for="meta_robots" class="col-form-label">Robots Meta Tag</label>
										<select class="form-control" id="meta_robots" name="meta[text][meta_robots]" >
											<option value="">Select</option>
											<option value="index, follow">index, follow</option>
											<option value="noindex, follow">noindex, follow</option>
											<option value="noindex, nofollow">noindex, nofollow</option>
											<option value="index, nofollow">index, nofollow</option>
										</select>
								</div>
							</div>	 
								 
							<div class="col-sm-6">
								<div class="form-group">
									<label for="post_status" class="col-form-label">Status</label>
									<select class="form-control" id="post_status" name="post[status]">
										<option {{ ( old('post')['status'] ?? "" == 1 )? 'selected' : '' }} value="1">Publish</option>
										<option {{ ( old('post')['status'] ?? "" == 2 )? 'selected' : '' }} value="2">Unpublish</option>
									</select>
								</div>
							</div>	 
						</div>
						<div class="row mg-b-20 ">
							<div class="col-sm-12">
								<div class="button-control-wrapper">
									<div class="form-group">
										<input class="btn btn-primary" type="submit" name="btnsubmit" value="Save"  />
										<a href="{{ route('post_index',$postType) }}" class="btn btn-danger">Close</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
	{{ Form::close() }}

@stop

@section('scripts') 
@parent
<script src="{{  asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
@include('admin.common.common_gallery_scripts')
<script>
	window.onload = function() {
		$("#videoGalleryUpload").hide();
	}
</script>
<script>
$(document).ready(function() {	
	PGSADMIN.utils.createEnglishArticleEditor();
	PGSADMIN.utils.createArabicArticleEditor();	
	PGSADMIN.utils.createMediaUploader("{{ route('post_media_create',['slug'=>$postType]) }}","#galleryWrapper" ,"{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/" );
	PGSADMIN.utils.createAjaxFileUploader("{{ route('post_media_create',['slug'=>$postType]) }}" ,"{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/" );
	



});
</script>
@stop