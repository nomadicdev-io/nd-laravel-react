<div class="row mg-b-20">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
		<div class="card">
			<div class="card-header">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="section-block">
						<h3 class="section-title">Upload Entity Logo</h3>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<section class="basic_settings" id="postMediaWrapper">
							<div class="row"> 
								<div class="col-sm-12  fl fl-wrap fileUploadWrapper form-group">
									{!! getMultiPlUploadControl('Upload Gallery Image(s) (Max 2 MB)  (jpg,jpeg,webp,png) ','entity_logo',['jpg','jpeg','webp','png'],'image','Select File',null,null,old('meta')['text']['gallery'] ?? "",$postType,1487,923) !!}
								</div>
							</div>								
						</section>
					</div>
				</div>
			</div>
			<div class="card-footer  p-0 text-center d-flex justify-content-center">
				<p>Files will be automatically uploaded. Can select multiple files</p>
			</div>
		</div>
	</div>
	
</div>


<div class="card mg-b-20">
<div class="card">
	<ul id="{{ (!empty($galleryLister)) ? $galleryLister: 'galleryWrapper' }}" class=" row myFileLister">
		@if(!empty($postDetails))
			@if(isset($postDetails->entityLogo))
				
				@foreach($postDetails->entityLogo as $media)
				   {!! galleryItem($media,'entity_logo_file') !!}
				@endforeach
			@endif
		@endif
	</ul>
</div>
</div>
@section('scripts') 
@parent
	@include('admin.common.common_gallery_scripts')
@stop