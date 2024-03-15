<div class="az-header">
    <div class="container-fluid">
        <div class="az-header-left">
                <a href="" id="azSidebarToggle" class="az-header-menu-icon"><span></span></a>
        </div><!-- az-header-left -->

        <div class="log_box">
                    <a href="{{ asset('/') }}" class="az-logo"><img class="logo-img" src="{{ (!empty($websiteSettings) && !empty($websiteSettings->getMeta('logo_main'))) ? PP($websiteSettings->getMeta('logo_main')) :asset('assets/frontend/images/laravel.svg')  }}" alt=""></a>
        </div>

        <div class="az-header-right">
            @include('admin.layouts.partials.language_switcher')
            {{-- @include('admin.layouts.partials.common_header_notification') --}}
            @include('admin.layouts.partials.common_header_dropdown')
        </div><!-- az-header-right -->
    </div><!-- container -->
</div>