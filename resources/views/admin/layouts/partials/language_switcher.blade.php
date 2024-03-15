@php
    $changeLang = App::getLocale() == 'ar' ? 'en' : 'ar';
@endphp
<?php /*<div class="az-profile-menu adminLangSwitcher">
    <a href="{{ route('admin_language_switcher', [$changeLang]) }}" class="new">{{ App::getLocale() == 'ar'?'EN':'AR'}}</a>
    {{-- <a href="{{ route('admin_lang_switch', [$changeLang]) }}" class="new">{{ App::getLocale() == 'ar'?'EN':'AR'}}</a> --}}
</div><!-- az-header-notification --> */ ?>