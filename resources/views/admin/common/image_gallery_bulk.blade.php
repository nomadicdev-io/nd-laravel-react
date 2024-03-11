<div class="row mg-b-20">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="card">
            <div class="card-header">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section-block">
                        <h3 class="section-title">Upload Images</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <section class="basic_settings" id="postMediaWrapper">
                            <div class="row">
                                <div class="col-sm-12  fl fl-wrap fileUploadWrapper form-group">
                                    {!! getMultiPlUploadControlCopy(
                                        'Upload Gallery Image(s) (Max 2 MB)  (jpg,jpeg,png) ',
                                        'gallery',
                                        ['jpg', 'jpeg', 'png'],
                                        'image',
                                        'Select File',
                                        null,
                                        null,
                                        old('meta')['text']['gallery'] ?? '',
                                        $postType,
                                        1487,
                                        923,
                                    ) !!}
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
        <ul id="{{ !empty($galleryLister) ? $galleryLister : 'galleryWrapper' }}" class=" row myFileLister ">
            @if (!empty($postDetails))
                @if (isset($postDetails->media))

                    @foreach ($postDetails->media as $media)
                        <li class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 custCardWrapper gallery-grid ">
                            <div class="card card-figure has-hoverable">
                                <div class="topControls">

                                    <div class="control_">
                                        <a class="downloadImage" href="{{ PP($media->pm_file_hash) }}"> <span><i
                                                    class="fas fa-download "></i></span></a>
                                    </div>

                                    <div class="control_">


                                        <a href="#" class="link_ copy_icon_ "
                                            data-copy="{{ PP($media->pm_file_hash) }}"
                                            data-normal="{{ getFrontendAsset('images/copy.png') }}"
                                            data-coped="{{ getFrontendAsset('images/tick.png') }}">
                                            <img src="{{ getFrontendAsset('images/copy.png') }}" loading="lazy"
                                                alt="" width="25" height="25">
                                        </a>
                                    </div>

                                    <div class="control_">
                                        <a href="#" class="btn btn-reset text-muted delUploadImage" title="Delete"
                                            data-id="{{ $media->pm_id }}"><span class="fas fa-times-circle"></span></a>
                                    </div>
                                </div>
                                <figure class="figure"
                                    style="flex: 1;background: #ebebeb;display: flex;align-items: center;">
                                    <div class="figure-attachment adjustImage" style="width:100%">
                                        <img src="{{ PP($media->pm_file_hash) }}" width="100%" />
                                    </div>
                                </figure>
                                <input type="hidden" name="postMedia[gallery_file][]" value="{{ $media->pm_id }}">
                            </div>
                        </li>
                    @endforeach
                @endif
            @endif
        </ul>
    </div>
</div>
@section('scripts')
    @parent
    @include('admin.common.common_gallery_scripts')

    <script>
        //    "#galleryWrapper", "{{ apa('post_media_download') }}/", "{{ asset('storage/post') }};

        var basePath = "{{ asset('storage/post/') }}";
        var downloadPath = "{{ apa('post_media_download') }}";
        var resultDivID = "#galleryWrapper";
        $('.multiuploaderCopy').each(function(i, v) {
            var _this = $(this);
            var _type = $(this).attr('data-type');
            var _slug = $(this).attr('data-slug');
            var _name = $(this).attr('name');
            if (!_type) {
                _type = 'default';
            }

            var uploader = new plupload.Uploader({
                runtimes: 'html5,flash,silverlight,html4',
                browse_button: $(this).attr('id'), // you can pass in id...
                url: "{{ route('post_media_create', ['slug' => 'media-bulk']) }}",
                multi_selection: true,
                /* resize: {
                	width: 100,
                	height: 100
                  }, */
                filters: {
                    max_file_size: '10mb',
                    mime_types: [{
                            title: "Pdf Document",
                            extensions: "pdf"
                        },
                        {
                            title: "Word Document",
                            extensions: "doc"
                        },
                        {
                            title: "Word Document",
                            extensions: "docx"
                        },
                        {
                            title: "Word Document",
                            extensions: "odt"
                        },
                        {
                            title: "Image file",
                            extensions: "jpg"
                        },
                        {
                            title: "Image file",
                            extensions: "jpeg"
                        },
                        {
                            title: "Image file",
                            extensions: "png"
                        },
                        {
                            title: "Image file",
                            extensions: "svg"
                        },
                        {
                            title: "Image file",
                            extensions: "gif"
                        },
                    ]
                },
                multipart_params: {
                    'controlName': _type,
                    'slug': _slug,
                    'name': _name
                },
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                },
                init: {
                    PostInit: function() {

                    },

                    BeforeUpload: function(up, files) {
                        var status_before = files.status;
                        _this.closest('.input_parent').find('.uploadProgress').css({
                            'width': '0%'
                        });
                        _this.closest('.input_parent').find('.uploadPercentage').html('');

                        uploader.settings.url = URL;

                    },
                    FilesAdded: function(up, files) {

                        _this.closest('.input_parent').find('.uploadFileName').html(files[0].name)
                        _this.closest('.input_parent').find('input[type="file"]').attr('required', true)
                        /* _this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').removeClass('uploaded')
                        _this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').addClass('uploading') */
                        uploader.start();
                    },

                    UploadProgress: function(up, file) {
                        _this.closest('.input_parent').find('.uploadProgress').css({
                            'width': file.percent + '%'
                        });
                        _this.closest('.input_parent').find('.uploadPercentage').html(file.percent +
                            '%');
                    },
                    FileUploaded: function(up, file, response) {

                        var t = response.response;

                        try {
                            var rt = $.parseJSON(t);
                            if (rt.status == true) {
                                _this.closest('.input_parent').find('input[type="file"]').removeClass(
                                    'error')
                                _this.closest('.input_parent').find('input[type="file"]').next('label')
                                    .hide()
                                _this.closest('.input_parent').find('input[type="file"]').attr(
                                    'required', false)
                                _this.closest('.input_parent').find('.filename').val(rt.data.fileName);
                                _this.closest('.input_parent').find('.original_name').val(file.name);

                                var fileHTML, fileType;
                                fileType = _type;

                                if (typeof rt.data.fileType != 'undefined') {
                                    fileType = rt.data.fileType;
                                } else if (typeof rt.fileType != 'undefined') {
                                    fileType = rt.fileType;
                                }
                                if (typeof fileType == 'undefined' && typeof rt.data.type !=
                                    'undefined') {
                                    fileType = rt.data.type;
                                }

                                if (jQuery.inArray(rt.data.mimeType, ['image/jpeg', 'image/png',
                                        'image/gif', 'image/svg+xml'
                                    ]) !== -1) {
                                    /* fileHTML = '<div class="uploadPreview"><div class="upImgWrapper"><input type="hidden" name="postMedia['+rt.data.fieldName+'][]" value="'+rt.data.id+'" /><span class="delUploadImage" data-id="'+
                                    		 rt.data.id+'"><i class="fa fa-times-circle"></i></span><img src="'+
                                    		 basePath+rt.data.fileName+'" class="uploadPreview"/></div>'+
                                    		 '<div class="clearfix"></div></div>';  */
                                    fileHTML = createFileHolderBulk('image', basePath, rt.data);
                                } else if (jQuery.inArray(rt.data.mimeType, ['application/pdf']) !== -
                                    1) {
                                    /* fileHTML = '<div class="uploadPreview filePreview"><div class="upImgWrapper"><input type="hidden" name="postMedia['+rt.data.fieldName+'][]" value="'+rt.data.id+'" /><span class="delUploadImage" data-id="'+
                                    		 rt.data.fileName+'"><i class="fa fa-times-circle"></i></span><span class="fileIconDisplayer"><i class="fa fa-file-pdf"></i></span><a target="_blank" href="'+
                                    		 downloadPath+rt.data.id+'">Download</a></div>'+
                                    		 '<div class="clearfix"></div></div>';  */
                                    fileHTML = createFileHolderBulk('pdf', basePath, rt.data);
                                } else if (jQuery.inArray(rt.data.mimeType, [
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                                    ]) !== -1) {
                                    /* fileHTML = '<div class="uploadPreview filePreview"><div class="upImgWrapper"><input type="hidden" name="postMedia['+rt.data.fieldName+'][]" value="'+rt.data.id+'" /><span class="delUploadImage" data-id="'+
                                    		 rt.data.fileName+'"><i class="fa fa-times-circle"></i></span><span class="fileIconDisplayer"><i class="far fa-file-word"></i></span>	<a target="_blank" href="'+
                                    		 downloadPath+rt.data.id+'">Download</a></div>'+
                                    		 '<div class="clearfix"></div></div>'; */
                                    fileHTML = createFileHolderBulk('word', basePath, rt.data);
                                } else {
                                    /* fileHTML = '<div class="uploadPreview filePreview"><div class="upImgWrapper"><input type="hidden" name="postMedia['+rt.data.fieldName+'][]" value="'+rt.data.id+'" /><span class="delUploadImage" data-id="'+
                                    		 rt.data.fileName+'"><i class="fa fa-times-circle"></i></span><span class="fileIconDisplayer"><i class="fa fa-file"></i></span><a target="_blank" href="'+
                                    		 downloadPath+rt.data.id+'">Download</a></div>'+
                                    		 '<div class="clearfix"></div></div>';  */
                                    fileHTML = createFileHolderBulk('file', basePath, rt.data);
                                }

                                fileHTML += '';
                                _this.closest('.fileUploadWrapper').find('.uploadPreview').remove();
                                $(resultDivID).append(fileHTML);
                            } else {
                                _this.closest('.input_parent').find('.uploadFileName').val('');
                                _this.closest('.input_parent').find('.original_name').val('');
                                _this.closest('.input_parent').find('.uploadProgress').css({
                                    'width': '0%'
                                });
                                _this.closest('.input_parent').find('.uploadPercentage').html('');

                                if (typeof swal == 'undefined') {
                                    alert(" {{ Lang::get('messages.invalid_file') }} ");
                                } else {
                                    swal.fire({
                                        title: "{{ Lang::get('messages.error') }}",
                                        text: rt.response,
                                        type: "warning",
                                        confirmButtonText: "{{ Lang::get('messages.ok') }}",
                                        confirmButtonColor: '#000',
                                        closeOnConfirm: false
                                    })
                                }

                            }
                        } catch (ex) {

                            alert(ex);
                            Swal.fire({
                                text: 'Network Error Occured. Please try again.',
                                type: 'error',
                            });
                            _this.closest('.input_parent').find('.uploadFileName').html('');
                            _this.closest('.input_parent').find('.filename').val('');
                            _this.closest('.input_parent').find('.original').val('');
                            _this.closest('.input_parent').find('.uploadProgress').css({
                                'width': '0%'
                            });
                            _this.closest('.input_parent').find('.uploadPercentage').html('');
                        }
                    },
                    UploadComplete: function(up, files) {
                        //$('#loader').hide();
                        // $('.uploadWrapperParent').addClass('uploaded')
                        uploader.splice();
                    },
                    Error: function(up, err) {


                        if (typeof swal == 'undefined') {
                            alert(" {{ Lang::get('messages.invalid_file') }} ");
                        } else {
                            swal.fire({
                                title: "{{ Lang::get('messages.error') }}",
                                text: "{!! Lang::get('messages.invalid_file') !!} : " + err.message,
                                type: "warning",
                                confirmButtonText: "{{ Lang::get('messages.ok') }}",
                                confirmButtonColor: '#000',
                                closeOnConfirm: false
                            });
                        }

                    }
                }
            });


            uploader.init();

            // uploaders.push(uploader);

        });

        $(document).ready(function() {


            function deleteFile($elem, fileId) {
                if (!fileId) {
                    console.log("Invalid File name");
                    return false;
                }

                var url = window.postMediaDelURL + fileId;

                PGSADMIN.utils.sendAjax(
                    url,
                    "GET", {},
                    function(response) {
                        if ($.fn.sticky && response.msgClass) {
                            $.sticky(response.message, {
                                classList: response.msgClass,
                                position: "top-center",
                                speed: "slow",
                            });
                        }
                        if (response.status) {
                            var $uploadHTML = $elem
                                .closest(".form-group")
                                .find(".uploadControlWrapper");
                            if (
                                $uploadHTML.hasClass("uploadControlWrapper")
                            ) {
                                $uploadHTML
                                    .find(".uploadPercentage")
                                    .html("");
                                $uploadHTML
                                    .find(".uploadFileName")
                                    .html("");
                                $uploadHTML
                                    .find(".uploadProgress")
                                    .css({
                                        width: "0%"
                                    });
                                $uploadHTML.find(".filename").val("");
                                $uploadHTML.find(".original_name").val("");
                            }
                            $elem.closest("li").remove();
                            $elem.parent().remove();
                        }
                    }
                );
            }

            $("body").on("click", ".delUploadImage", function(e) {

                e.preventDefault();
                var $elem = $(this);
                if (typeof Swal == "undefined") {
                    if (confirm("Are you sure?")) {
                        deleteFile($elem, $elem.attr("data-id"));
                    }
                } else {
                    Swal.fire({
                        title: window.appTrans.areYouSure,
                        text: window.appTrans.cannotRevert,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: window.appTrans.yes,
                    }).then((result) => {
                        if (result.value) {
                            deleteFile($elem, $elem.attr("data-id"));
                        }
                    });
                }
            });
        });

        function createFileHolderBulk(type, basePath, data, downloadPath) {


            switch (type) {
                case "image":
                    dispElement =
                        '<img src="' +
                        basePath + '/' +
                        data.fileName +
                        '" alt="" class="img-fluid imageCenter">';
                    break;
                case "video":
                    dispElement = data.name ?
                        '<img src="' +
                        basePath + '/' +
                        data.fileName +
                        '" alt="" class="img-fluid imageCenter">' :
                        '<img src="https://img.youtube.com/vi/' +
                        data.video +
                        '/hqdefault.jpg" alt="" class="img-fluid imageCenter">';

                    break;

                default:
                    dispElement =
                        '<span class="fa-stack fa-lg">' +
                        '<i class="fa fa-square fa-stack-2x text-primary"></i>' +
                        '<i class="fa fa-file-' +
                        type +
                        ' fa-stack-1x fa-inverse"></i>' +
                        "</span>";
                    break;
            }
            return (
                '<li class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 custCardWrapper gallery-grid">' +
                '<div class="card card-figure has-hoverable">' +
                '<div class="topControls">' +
                '<div class="control_"><a class="downloadImage" href="' + downloadPath + '/' + data.id +
                '"> <span><i class="fas fa-download "></i></span></a></div>' +

                '<div class="control_"> <a href="#" class="link_ copy_icon_ "  data-copy="' + basePath + '/' + data
                .fileName +
                '"     data-normal = "{{ getFrontendAsset('images/copy.png') }}"   data-coped = "{{ getFrontendAsset('images/tick.png') }}" ></div>' +

                '<div class="control_"><a href="#" class="btn btn-reset text-muted delUploadImage" title="Delete" data-id="' +
                data.id +
                '">' +
                '<span class="fas fa-times-circle"></span>' +
                '</a></div>' +
                '</div>' +
                '<figure class="figure" 	style="flex: 1;background: #ebebeb;display: flex;align-items: center;">' +
                '<div class="figure-attachment adjustImage" style="width:100%">' +
                '<img src = "' + basePath + '/' + data.fileName + '" width="100%" /> ' +

                '</div>' +
                '</figure>' +
                '<input type="hidden" name="postMedia[gallery_file][]" value="' + data.id + '">' +


                '</div>' +
                '</li>'
            );
        }


        $(function() {


            function fallbackCopyTextToClipboard(text) {
                var textArea = document.createElement("textarea");
                textArea.value = text;

                // Avoid scrolling to bottom
                textArea.style.top = "0";
                textArea.style.left = "0";
                textArea.style.position = "fixed";

                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    console.log('Fallback: Copying text command was ' + msg);
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }

                document.body.removeChild(textArea);
            }

            function copyTextToClipboard(text, btn, normalImg, tickImg) {

                btn.querySelector('img').src = tickImg;
                setTimeout(() => {
                    btn.querySelector('img').src = normalImg;
                }, 1000);
                if (!navigator.clipboard) {
                    fallbackCopyTextToClipboard(text);
                    return;
                }
                navigator.clipboard.writeText(text).then(function() {

                    /* btn.querySelector('img').src = tickImg;
                     setTimeout(() => {
                         btn.querySelector('img').src = normalImg;
                     }, 1000);*/
                }, function(err) {
                    //console.error('Async: Could not copy text: ', err);
                });
            }

            var copyBobBtn = document.querySelectorAll('[data-copy]');
            copyBobBtn.forEach((btn) => {
                var content_ = btn.dataset.copy
                btn.addEventListener('click', function(event) {
                    event.preventDefault();
                    var normalImg = btn.dataset.normal;
                    var tickImg = btn.dataset.coped;

                    copyTextToClipboard(content_, btn, normalImg, tickImg);
                });
            });


        })
    </script>
@stop
