<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digital Wellbeing::Browsing Files</title>
    
    {{ HTML::style('assets/admin/vendor/fonts/fontawesome/css/fontawesome-all.css') }}
    {{ HTML::style('assets/editor/css/file-upload-window-style.css') }}
    <script>
        // Helper function to get parameters from the query string.
        function getUrlParam( paramName ) {
            var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
            var match = window.location.search.match( reParam );

            return ( match && match.length > 1 ) ? match[1] : null;
        }
        // Simulate user action of selecting a file to be returned to CKEditor.
        function returnFileUrl(fileUrl) {

            var funcNum = getUrlParam( 'CKEditorFuncNum' );
           // var fileUrl = '../assets/test/arts.jpg';
            window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
            window.close();
        }
    </script>
	<script>
		window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
		window.baseURL = "{{ asset('/') }}";
		window.adminPrefix = "{{ Config::get('app.admin_prefix') }}/";
	</script>
</head>
<body>
    <div class="frame-wrapper">
        <div class="file-manager-row">
            <div class="right-panel">
                <div class="blocks-gallery">
                    <?php foreach($filemanagerFiles as $myFile){ ?>
                    <div class="block">
						<span class="delUploadImage" data-id="{{ $myFile->pm_id }}"><i class="fa fa-times-circle"></i></span>
						
                        <div class="inner" onclick="returnFileUrl('{{ asset('storage/app/public/post/'.$myFile->pm_file_hash) }}')">
                            <?php if(in_array($myFile->pm_extension,['jpg','jpeg','gif','png','svg','bmp'])){ ?>
                                <img src="{{ asset('storage/app/public/post/'.$myFile->pm_file_hash) }}" />
                            <?php }else if(in_array($myFile->pm_extension,['pdf'])){ ?>
                                <img src="{{ asset('assets/admin/images/pdf.png') }}" />    
                            <?php }else if(in_array($myFile->pm_extension,['mp3,mp4'])){ ?>
                                <img src="{{ asset('assets/admin/images/audio.png') }}" />   
                            <?php } ?>
                            <div class="details">
                                <span class="title">{{ $myFile->pm_original_filename }}</span>
                                <span class="sub-title">{{ date('d F,Y h:i A',strtotime($myFile->pm_created_at)) }}</span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php /*
                    <div class="block">
                        <div class="inner ">
                            <div class="folder">
                                <span class="folder-name">Videos</span>
                            </div>

                        </div>
                    </div>
                    */ ?>
                    
                </div>
                <div class="editorPagination"> {{ $filemanagerFiles->appends(Input::except('page'))->links() }}</div>
            </div>
        </div>
    </div>
    <?php /*
    <ul class="imageWrapper">
        <?php foreach($filemanagerFiles as $myFile){ ?>
             <li onclick="returnFileUrl('{{ asset('assets/test/'.$myFile['basename']) }}')">
                <img src="{{ asset('assets/test/'.$myFile['basename']) }}" />
            </li>
        <?php } ?>
    </ul>
    */?>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/jquery/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/pgs/js/admin.js') }}"></script>
<script>
$(document).ready(function(){
	
    function deleteFile($elem, fileId){
		
        if(!fileId) { console.log('Invalid File name'); return false; }
        var url = "{{ apa('post_media/delete') }}/"+fileId;
       
        PGSADMIN.utils.sendAjax(url,'GET',{},function(response){
			 
             if(response.status){
				$elem.parent().remove();                
             }
        });
    }
    
    $('.block').on('click','.delUploadImage',function(e){
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

</body>
</html>