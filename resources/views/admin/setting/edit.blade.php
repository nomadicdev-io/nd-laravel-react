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
            <h2 class="pageheader-title">Edit {{ strip_tags($postDetails->getData('post_title')) }}</h2>
        </div>
    </div>
</div>
{{ Form::open(['url' => [apa('post/' . $postType . '/edit/' . $postDetails->getData('post_id'))], 'files' => true, 'id' => 'add-form']) }}
<input type="hidden" name="post[type]" value="{{ $postType }}" />
<div class="row">

    <!-- ============================================================== -->
    <!-- striped table -->
    <!-- ============================================================== -->
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <section class="basic_setting">

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="alert alert-light border text-primary bg-light"> Basic Settings </h5>
                        </div>
                    </div>
                    <div class="row">

                        @php
                            $uploaders = [
                                [
                                    'label' => 'Upload main logo (Max 2 MB)',
                                    'control_name' => 'logo_main',
                                    'type' => 'image',
                                    'old_file_name' => $postDetails->getMeta('logo_main'),
                                    'required' => false,
                                    'mimes' => ['jpg', 'jpeg', 'png', 'svg'],
                                ],
                                [
                                    'label' => 'Upload secondary logo (Max 2 MB)',
                                    'control_name' => 'logo_secondary',
                                    'type' => 'image',
                                    'old_file_name' => $postDetails->getMeta('logo_secondary'),
                                    'required' => false,
                                    'mimes' => ['jpg', 'jpeg', 'png', 'svg'],
                                ],
                            ];
                            
                        @endphp

                        @foreach ($uploaders as $uploaderData)
                            <div class="col-sm-6 form-group">
                                @include('admin.common.file_upload.uploader', $uploaderData)
                            </div>
                        @endforeach

                    </div>

                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="post_title" class="col-form-label">Website name <em>*</em></label>
                            <input type="text" name="post[title]" id="post_title" class="form-control" placeholder=""
                                value="{{ $postDetails->post_title }}" required />
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="title_arabic" class="col-form-label">Website name [Arabic]<em>*</em></label>
                            <input type="text" name="post[title_arabic]" id="post_title_arabic" dir="rtl"
                                class="form-control" placeholder="" value="{{ $postDetails->post_title_arabic }}"
                                required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="enquiry_send_email" class="col-form-label">Email(s) to receive Enquiry</label>
                            <textarea id="enquiry_send_email" name="meta[text][enquiry_send_email]" class="form-control"> {{ $postDetails->getMeta('enquiry_send_email') }} </textarea>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Menu Position</label>
                                <select class="form-control" name="meta[text][admin_menu_position]">
                                    <option value="left" {!! $postDetails->getMeta('admin_menu_position') == 'left' ? ' selected="selected"' : '' !!}>Left</option>
                                    <option value="top" {!! $postDetails->getMeta('admin_menu_position') == 'top' ? ' selected="selected"' : '' !!}>Top</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Default Language</label>
                                <select class="form-control" name="meta[text][default_lang]">
                                    <option value="en" {!! $postDetails->getMeta('default_lang') == 'en' ? ' selected="selected"' : '' !!}>English</option>
                                    <option value="ar" {!! $postDetails->getMeta('default_lang') == 'ar' ? ' selected="selected"' : '' !!}>Arabic</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Disable Language</label>
                            <div class="col-sm-4 custom-control custom-radio">
                                <input type="radio" name="meta[text][disable_language]" id="customRadio1"
                                    class="custom-control-input" value="en" <?php echo $postDetails->getMeta('disable_language') == 'en' ? 'checked' : ''; ?>>
                                <label class="custom-control-label w-100" for="customRadio1">English</label>
                            </div>
                            <div class="col-sm-4 custom-control custom-radio">
                                <input type="radio" name="meta[text][disable_language]" id="customRadio2"
                                    class="custom-control-input" value="ar" <?php echo $postDetails->getMeta('disable_language') == 'ar' ? 'checked' : ''; ?>>
                                <label class="custom-control-label w-100" for="customRadio2">Arabic</label>
                            </div>
                            <div class="col-sm-4 custom-control custom-radio">
                                <input type="radio" name="meta[text][disable_language]" id="customRadio3"
                                    class="custom-control-input" value="none" <?php echo $postDetails->getMeta('disable_language') == 'none' ? 'checked' : ''; ?>>
                                <label class="custom-control-label w-100" for="customRadio3">None</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="alert alert-light border text-primary bg-light">Social Media Links</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Twitter Link</label>
                                <input type="text" name="meta[text][twitter_link]" class="form-control"
                                    value="{{ $postDetails->getMeta('twitter_link') }}" placeholder="" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Instagram Link</label>
                                <input type="text" name="meta[text][instagram_link]"
                                    value="{{ $postDetails->getMeta('instagram_link') }}" class="form-control"
                                    placeholder="" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Facebook Link </label>
                                <input type="text" name="meta[text][facebook_link]"
                                    value="{{ $postDetails->getMeta('facebook_link') }}" class="form-control"
                                    placeholder="" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>LinkedIn Link</label>
                                <input type="text" name="meta[text][linkedin_link]"
                                    value="{{ $postDetails->getMeta('linkedin_link') }}" class="form-control"
                                    placeholder="" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Youtube Link</label>
                                <input type="text" name="meta[text][youtube_link]"
                                    value="{{ $postDetails->getMeta('youtube_link') }}" class="form-control"
                                    placeholder="" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="alert alert-light border text-primary bg-light">Theme Color </h5>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>CMS Theme Color </label>
                                <input type="color" name="meta[text][theme_color]"
                                    value="{{ $postDetails->getMeta('theme_color') }}" class="form-control"
                                    placeholder="" />
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="alert alert-light border text-primary bg-light"> Google Analytics </h5>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Google Analytics Tag (ID)</label>
                                <input type="text" name="meta[text][google_analytics]"
                                    value="{{ $postDetails->getMeta('google_analytics') }}" class="form-control"
                                    placeholder="" />
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="alert alert-light border text-primary bg-light"> Contact Details </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="meta[text][contact_email]"
                                    value="{{ $postDetails->getMeta('contact_email') }}" class="form-control"
                                    placeholder="" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="meta[text][contact_phone]"
                                    value="{{ $postDetails->getMeta('contact_phone') }}" class="form-control"
                                    placeholder="" />
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location</label>
                                <textarea name="meta[text][location]" class="form-control" placeholder="Location">{{ $postDetails->getMeta('location') }}</textarea>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location [arabic]</label>
                                <textarea dir="rtl" name="meta[text][location_arabic]" class="form-control" placeholder="Location">{{ $postDetails->getMeta('location_arabic') }}</textarea>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="alert alert-light border text-primary bg-light"> Home page title </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Home Page Title</label>
                                <textarea name="meta[text][home_page_title]" class="form-control" placeholder="Page title for the homepage">{{ $postDetails->getMeta('home_page_title') }}</textarea>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Home Page Title [arabic]</label>
                                <textarea dir="rtl" name="meta[text][home_page_title_arabic]" class="form-control"
                                    placeholder="Page title for the homepage in arabic">{{ $postDetails->getMeta('home_page_title_arabic') }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Home Page Description</label>
                                <textarea name="meta[text][home_page_description]" class="form-control" placeholder="Page title for the homepage">{{ $postDetails->getMeta('home_page_description') }}</textarea>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Home Page Description [arabic]</label>
                                <textarea dir="rtl" name="meta[text][home_page_description_arabic]" class="form-control"
                                    placeholder="Page title for the homepage in arabic">{{ $postDetails->getMeta('home_page_description_arabic') }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Site meta keywords</label>
                                <input type="text" value="{{ $postDetails->getMeta('site_meta_keyword') }}"
                                    name="meta[text][site_meta_keyword]" class="form-control"
                                    placeholder="site meta keyword">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Site meta author</label>
                                <input type="text" value="{{ $postDetails->getMeta('site_meta_author') }}"
                                    name="meta[text][site_meta_author]" class="form-control"
                                    placeholder="site meta keyword">
                            </div>
                        </div>
                    </div>

                </section>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="button-control-wrapper">
                            <div class="form-group">
                                <input class="btn btn-primary " type="submit" name="updatebtnsubmit"
                                    value="Save" />
                                @if ($singlePost)
                                    <a href="{{ route('admin_dashboard') }}" class="btn btn-danger">Close</a>
                                @else
                                    <a href="{{ route('post_index', $postType) }}" class="btn btn-danger">Close</a>
                                @endif
                            </div>
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
<script src="{{ asset('assets/admin/lib/tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
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
        //PGSADMIN.utils.createMediaUploader("{{ route('post_media_create', ['slug' => $postType]) }}","#galleryWrapper" ,"{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/" );
        PGSADMIN.utils.createAjaxFileUploader("{{ route('post_media_create', ['slug' => $postType]) }}",
            "{{ apa('post_media_download') }}/", "{{ asset('storage/post/') }}/");

        //PGSADMIN.utils.youtubeVideoThumbUploader('changeImage',"{{ route('post_media_create', ['slug' => $postType]) }}", "{{ asset('storage/post/') }}/","#galleryWrapper");

        $('#post_tags').tagsinput({
            confirmKeys: [13, 188]
        });

        $('body').on('keydown', '.bootstrap-tagsinput input', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 9 || keyCode === 13) {
                e.preventDefault();
                $("#post_tags").tagsinput('add', $(this).val());
                $(this).val('');
                return false;
            }
        });

    });
</script>
@stop
