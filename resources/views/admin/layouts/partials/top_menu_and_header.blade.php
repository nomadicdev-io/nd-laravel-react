<div class="az-header">
  <div class="container">
      <div class="az-header-left">
        <a target="_blank" class="navbar-brand adminHeaderSiteName" href="{{ asset('/') }}">
          {{ @$websiteSettings->post_title }}
        </a>
        <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
      </div><!-- az-header-left -->
      <div class="az-header-menu">
        <div class="az-header-menu-header">
          <a target="_blank" class="navbar-brand adminHeaderSiteName" href="{{ asset('/') }}">
            {{ @$websiteSettings->post_title }}
          </a>
          <a href="" class="close">&times;</a>
        </div><!-- az-header-menu-header -->
        @include('admin.layouts.partials.menu')
      </div><!-- az-header-menu -->
      <div class="az-header-right">
        @include('admin.layouts.partials.language_switcher')
        {{-- @include('admin.layouts.partials.common_header_notification') --}}
        @include('admin.layouts.partials.common_header_dropdown')
      </div><!-- az-header-right -->
  </div><!-- container -->
</div><!-- az-header -->