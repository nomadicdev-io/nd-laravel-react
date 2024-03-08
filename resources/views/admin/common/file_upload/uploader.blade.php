<?php
$path = empty($path) ? 'app/public/post/' : $path;

if(empty($mimes)){
	$mimes = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
	if ($type == 'file') {
		$mimes = ['pdf', 'docx', 'doc', 'xls', 'xlsx'];
	}
}

$dimensions = \Config::get('pgsimagedimensions');

$width = $height = false;
$dimensionStr = '';

$dimensionKey = $control_name . '_file';

if (isset($dimensions[$dimensionKey])) {

	if (isset($dimensions[$dimensionKey]['width'])) {
		$width = $dimensions[$dimensionKey]['width'];
		$height = $dimensions[$dimensionKey]['height'];
	}
	if (isset($dimensions[$dimensionKey]['large'])) {
		$width = $dimensions[$dimensionKey]['large']['width'];
		$height = $dimensions[$dimensionKey]['large']['height'];
	}
}
if(empty($size)){
	$size="2mb";
}
if (!empty($width)) {
	$dimensionStr = ' <strong class="imageDims">('.strtoupper($size).')[' . $width . 'px X ' . $height . 'px] ['.(implode(",", $mimes)).']</strong>'; 
} else {
	$dimensionStr = ' <strong class="imageDims">('.strtoupper($size).')['.(implode(",", $mimes)).']</strong>';
}

$requiredLabel = ($required) ? '<em class = "mandatory">*</em>' : '';
?>
<label class = "fl-start col-form-label">{!! $label.' '.$dimensionStr !!} {!! $requiredLabel !!}</label>
	@if(!empty($old_file_name) && File::exists(storage_path($path.$old_file_name)))
		<div class="uploadPreview img_uploaded">
			@if($type=="video")
			<div class="upImgWrapper">
			    <span class="delUploadImage" data-name="{{ $old_file_name }}" data-id="{{ $old_file_name }}">
					<i class="fa fa-times-circle"></i>
				</span>
			    <video width="320" height="150"  controls class="uploadPreview ">
					<source src="{{ PP($old_file_name) }}" type="video/mp4">
					Your browser does not support the video tag.
				</video>
				</div>
			@else
			<div class="upImgWrapper">
				<span class="delUploadImage" data-name="{{ $old_file_name }}" data-id="{{ $old_file_name }}">
					<i class="fa fa-times-circle"></i>
				</span>
				@if($type=="image")
				    <img src="{{ PT($old_file_name) }}" class="uploadPreview"/>
					<a target="_blank" href="{{ PPO($old_file_name)  }}" download class="uploadPreview upload-preview-download" > <i class="fa fa-download" aria-hidden="true"></i></a>
				@elseif($type=="video")		
				<video height="200" controls="controls" preload="none"  ><source src="{{ PT($old_file_name) }}" >Your browser does not support the video tag.</video>																																					 
            @else
				
			
					<img src="{{ asset('assets/admin/images/file.png') }}" class="uploadPreview"/>
					<a target="_blank" href="{{ apa('download-post-file/'.$old_file_name) }}" class="uploadPreview"> View/Download</a>

				@endif
			</div>
			@endif
			<div class="clearfix"></div>
		</div>
	@endif
<div class = "uploadControlWrapper input_parent">
	<input type = "file" class = "form-control singleuploader" data-size="{{$size}}" data-slug="{{ $postType }}" data-allowed="{{ (implode(",", $mimes)) }}" data-type="{{ $type }}" title = "Select File" id = "{{ $control_name.'_file' }}" name = "{{$control_name.'_file' }}" {{ (($required==true && empty($old_file_name))? " required ": '' ) }} />
	<div class = "choose">
		<div class = "choose-btn">{{ !empty($btnLabel) ? $btnLabel : 'Select File' }}</div>
		<div class = "choose-file uploadFileName"></div>
		<div class = "uploadPercentage"></div>
		<div class = "uploadProgressWrapper">
			<div class = "uploadProgress" ></div>
		</div>
	</div>
	<input class = "filename" type="hidden" id="{{$control_name}}" value="{{ ((!empty($old_file_name))? $old_file_name:'') }}" name="meta[text][{{$control_name}}]" placeholder="">
    <input class = "original_name" type="hidden" id="{{ $control_name.'_tmp' }}" value="" name="{{ $control_name.'_tmp' }}" placeholder="">
</div>