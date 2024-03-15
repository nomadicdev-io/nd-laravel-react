<div class="dropdown az-profile-menu">
    <a href="#" style="font-size: 22px;"><i class="typcn icon typcn-cog-outline"></i></a>
    <div class="dropdown-menu">
        <div class="az-dropdown-header d-sm-none">
        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
        </div>
        <div class="az-header-profile">
        <h6>{{  Auth::user()->name }}</h6>
        </div><!-- az-header-profile -->
        <a href="{{ route('admin_change_password') }}" class="dropdown-item"><i class="typcn typcn-time"></i>{{ lang('change_password') }}</a>

        @if(Auth::user()->hasAnyRole(['Super Admin', 'System Administrator']))
        <a href="{{ asset(\Config::get('app.admin_prefix').'/post/setting') }}" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> {{ lang('settings') }}</a>
        @endif

        <a href="{{ asset(\Config::get('app.admin_prefix').'/logout') }}" class="dropdown-item"><i class="typcn typcn-power-outline"></i> {{ lang('sign_out') }}</a>
    </div><!-- dropdown-menu -->
</div>