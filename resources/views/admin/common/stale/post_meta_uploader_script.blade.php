<script>
var uploaders = []
var count =1,total;

function createAjaxFileUploader(URL){
    $('.singleuploader').each(function(i,v){
		var _this = $(this);
		var _type = $(this).attr('data-type');
		var _slug = $(this).attr('data-slug');
		var _name = $(this).attr('name');
		if(!_type){
			_type = 'default';
		}
        
		var uploader = new plupload.Uploader({
					runtimes : 'html5,flash,silverlight,html4',
					browse_button : $(this).attr('id'), // you can pass in id...					
					url : URL,					
					multi_selection : false,
					/* resize: {
						width: 100,
						height: 100
					  }, */
					filters : {
						max_file_size : '10mb',
						mime_types: [
							{title : "Pdf Document", extensions : "pdf"},
							{title : "Word Document", extensions : "doc"},
							{title : "Word Document", extensions : "docx"},
							{title : "Word Document", extensions : "odt"},
							{title : "Image file", extensions : "jpg"},
							{title : "Image file", extensions : "jpeg"},
							{title : "Image file", extensions : "png"},
							{title : "Image file", extensions : "svg"},
							{title : "Image file", extensions : "gif"},
						]
					},
					multipart_params : {
                        'controlName': _type,
                        'slug':_slug,
                        'name':_name
					},
					headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
					init: {
						PostInit: function() {
							
						},
						
						BeforeUpload:function (up,files){
							var status_before = files.status;
							_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
							_this.closest('.input_parent').find('.uploadPercentage').html('');				
							
							uploader.settings.url = URL;		
						
						},										
						FilesAdded: function(up, files) {

							_this.closest('.input_parent').find('.uploadFileName').html(files[0].name)
							_this.closest('.input_parent').find('input[type="file"]').attr('required',true)
							/* _this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').removeClass('uploaded')
							_this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').addClass('uploading') */
							uploader.start();
						},

						UploadProgress: function(up, file) {
							_this.closest('.input_parent').find('.uploadProgress').css({'width':file.percent+'%'});					
							_this.closest('.input_parent').find('.uploadPercentage').html(file.percent+'%');				
						},
						FileUploaded:function(up,file,response){
					
							var t = response.response;
							try{	
								var rt  = $.parseJSON(t);
								if(rt.status == true ){
									_this.closest('.input_parent').find('input[type="file"]').removeClass('error')
									_this.closest('.input_parent').find('input[type="file"]').next('label').hide()
									_this.closest('.input_parent').find('input[type="file"]').attr('required',false)
									_this.closest('.input_parent').find('.filename').val(rt.data.fileName);
									_this.closest('.input_parent').find('.original_name').val(file.name);
									var basePath = '{{ asset("storage/app/post/uploads") }}/';
									var downloadPath = '{{ apa("post_media_download") }}/';
									var fileHTML, fileType;
									fileType=_type;
								   
									if(typeof rt.data.fileType != 'undefined'){
										fileType = rt.data.fileType;
									}else if(typeof rt.fileType != 'undefined'){
										fileType = rt.fileType;
									}
									if(typeof fileType == 'undefined' && typeof rt.data.type != 'undefined'){
										fileType = rt.data.type;
									}
									
									if(jQuery.inArray(rt.data.mimeType, ['image/jpeg','image/png','image/gif']) !== -1){
										fileHTML = '<div class="uploadPreview"><div class="upImgWrapper"><input type="hidden" name="postMedia['+rt.data.fieldName+'][]" value="'+rt.data.id+'" /><span class="delUploadImage" data-id="'+
												 rt.data.id+'"><i class="fa fa-times-circle"></i></span><img src="'+
												 basePath+rt.data.fileName+'" class="uploadPreview"/></div>'+
												 '<div class="clearfix"></div></div>';                                    
									}else{
										fileHTML = '<div class="uploadPreview filePreview"><div class="upImgWrapper"><input type="hidden" name="postMedia['+rt.data.fieldName+'][]" value="'+rt.data.id+'" /><span class="delUploadImage" data-id="'+
												 rt.data.fileName+'"><i class="fa fa-times-circle"></i></span><a target="_blank" href="'+
												 downloadPath+rt.data.id+'">Download</a></div>'+
												 '<div class="clearfix"></div></div>';      
									}
									
									fileHTML += '';
									_this.closest('.fileUploadWrapper').find('.uploadPreview').remove();  
									_this.closest('.input_parent').before(fileHTML);
								}else{
									_this.closest('.input_parent').find('.uploadFileName').val('');
									_this.closest('.input_parent').find('.original_name').val('');
									_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
									_this.closest('.input_parent').find('.uploadPercentage').html('');
									
									if(typeof swal == 'undefined'){ 
										alert(" {{ Lang::get('messages.invalid_file') }} ");
									}else{
										swal.fire({
											  title: "{{Lang::get('messages.error')}}",
											  text: rt.response,
											  type: "warning",
											  confirmButtonText: "{{Lang::get('messages.ok')}}",
											  confirmButtonColor:'#000',
											  closeOnConfirm: false
											})
									}
									
								}
							}catch(ex){					
						
								Swal.fire({
									text: 'Network Error Occured. Please try again.',
									type: 'error',
								});
								_this.closest('.input_parent').find('.uploadFileName').html('');
								_this.closest('.input_parent').find('.filename').val('');
								_this.closest('.input_parent').find('.original').val('');
								_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
								_this.closest('.input_parent').find('.uploadPercentage').html('');
							}
						},
						UploadComplete:function(up,files){
							//$('#loader').hide();
							// $('.uploadWrapperParent').addClass('uploaded')
							uploader.splice();
						},
						Error: function(up, err) {

							
							if(typeof swal == 'undefined'){ 
                                alert(" {{ Lang::get('messages.invalid_file') }} ");
                            }else{
                                swal.fire({
									  title: "{{Lang::get('messages.error')}}",
									  text: "{!! Lang::get('messages.invalid_file') !!} : "+err.message,
									  type: "warning",
									  confirmButtonText: "{{Lang::get('messages.ok')}}",
									  confirmButtonColor:'#000',
									  closeOnConfirm: false
								});
                            }
							
						}
					}
				});
			
	
				uploader.init();

				uploaders.push(uploader);
			
		});   
}

$(document).ready(function(){
	
    function deleteFile($elem, fileId){
		
        if(!fileId) { console.log('Invalid File name'); return false; }
        var url = "{{ apa('post_media/delete') }}/"+fileId;
       
        PGSADMIN.utils.sendAjax(url,'GET',{},function(response){
		 
             $.sticky(response.message,{classList:response.msgClass,position:'top-center',speed:'slow'});
			 
             if(response.status){
				console.log($elem);
                var $uploadHTML = $elem.closest('.fileUploadWrapper').find('.uploadControlWrapper');
                if($uploadHTML.hasClass('uploadControlWrapper')){
                    $uploadHTML.find('.uploadPercentage').html('');
                    $uploadHTML.find('.uploadFileName').html('');
                    $uploadHTML.find('.uploadProgress').css({'width':'0%'});
                    $uploadHTML.find('.filename').val('');
                    $uploadHTML.find('.original_name').val('');
                    $elem.parent().remove();
                }                    
             }
        });
    }
    
    $('.fileUploadWrapper').on('click','.delUploadImage',function(e){
        e.preventDefault();
        var $elem = $(this);
        if(typeof Swal == 'undefined'){ 
            if(confirm('Are you sure?')){
                deleteFile($elem, $elem.attr('data-id'));
            }
        }else{
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes !'
				}).then((result) => {
					if (result.value) {
						deleteFile($elem, $elem.attr('data-id'));
					}
				});
        }

        
    });
});


</script>