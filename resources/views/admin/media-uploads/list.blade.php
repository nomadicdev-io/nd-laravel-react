@extends('admin.layouts.master')
@section('content')
@section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
@stop

<div class="az-content-breadcrumb">
    <span>{{ lang('master_records') }}</span>
    <span>{{ ucwords(str_replace('-', ' ', $postType)) }}</span>
</div>
<div class="row row-xs mg-b-20">
    <div class="col">
        <div class="az-content-label mg-b-5">Manage {{ ucwords(str_replace('-', ' ', $postType)) }}</div>
        <p class="mg-b-20">Total {{ $post_items->count() }} records</p>
    </div>
    @if ($buttons['add'])
        <div class="col-sm-2 col-md-2">
            <a href="{{ route('post_create', $postType) }}"
                class="btn btn-sm btn-az-primary btn-block">{{ lang('create_new') }}</a>

        </div>
    @endif
</div>
@include('admin.common.filter_search')
@include('admin.common.user_message')
<ul class=" row myFileLister">
    @foreach ($post_items as $item)
        @php
            if (!empty($item->getMeta('media_youtube'))) {
                $copyURl = $item->getMeta('media_youtube');
            } else {
                $copyURl = PP($item->getMeta('media_doc'));
            }
        @endphp
        <li class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 custCardWrapper gallery-grid ">
            <div class="card card-figure has-hoverable">
                <div class="row topControls flex" style="padding:10px; align-items: center;">
                    <div class="col-sm-4"> <a href="#" class="link_ copy_icon_ " data-copy="{{ $copyURl }}"
                            data-normal="{{ getFrontendAsset('images/copy.png') }}"
                            data-coped="{{ getFrontendAsset('images/tick.png') }}">
                            <img src="{{ getFrontendAsset('images/copy.png') }}" loading="lazy" alt=""
                                width="25" height="25">
                        </a> </div>
                    <div class="col-sm-4">
                        {!! getAdminActionIcons($buttons, $postType, $item) !!}
                    </div>
                </div>

                <figure class="figure" style="flex: 1;background: #ebebeb;display: flex;align-items: center;">
                    <div class="figure-attachment adjustImage" style="width:100%">
                        @if (!empty($item->getMeta('media_youtube')))
                            <img src="{{ youtubeImageFromUrl($item->getMeta('media_youtube')) }}" width="100%" />
                        @else
                            @if (!empty($item->getmedia) && $item->getmedia->pm_extension == 'mp4')
                                <video playsinline="" controls width="100%">
                                    <source src="{{ PP($item->getMeta('media_doc')) }}" type="video/mp4">
                                </video>
                            @else
                                <img src="{{ PP($item->getMeta('media_doc')) }}" width="100%" />
                            @endif
                        @endif


                    </div>
                </figure>
                <div class="row topControls flex" style="padding:10px;">

                    <div class="col-sm-12">
                        {!! $item->post_title !!}
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>




<div class="pagenation-wrapper">
    {!! $post_items->appends(request()->all())->links('pagination::bootstrap-4') !!}
</div>
</div><!-- table-responsive -->
@stop

@section('scripts')
@parent

<script>
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
