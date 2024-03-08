<div class="az-sidebar" @if(!empty($websiteSettings) && $websiteSettings->getMeta('theme_color'))
    style="background-color: {{$websiteSettings->getMeta('theme_color')}}" @endif >
    <div class="az-sidebar-header">
        <a href="{{ asset('/') }}" class="az-logo"><img class="logo-img"
                src="{{ (!empty($websiteSettings) && !empty($websiteSettings->getMeta('logo_main'))) ? PP($websiteSettings->getMeta('logo_main')) : asset('assets/frontend/images/laravel.svg') }}"
                alt=""></a>
    </div><!-- az-sidebar-header -->
    <div class="az-sidebar-body">
        @include('admin.layouts.partials.menu')
    </div><!-- az-sidebar-body -->
</div>