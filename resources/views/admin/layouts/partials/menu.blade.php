<ul class="nav">
    <li class="nav-item {{ get_admin_menu_active_class($currentURI, ['dashboard']) }}">
        <a class="nav-link" href="{{ apa('dashboard') }}"><i
                class="typcn typcn-chart-area-outline"></i>{{ lang('dashboard') }}</a>
    </li>
    @php
        $monLinks = [
            [
                'title' => 'CMS',
                'slug' => 'cms',
                'link' => apa('dashboard'),
                'icon' => 'typcn typcn-folder',
                'permissions' => ['Manage CMS'],
                'children' => [
                    [
                        'title' => 'Menu',
                        'slug' => 'menu',
                        'link' => apa('post/menu'),
                        'icon' => 'typcn typcn-th-menu-outline ',
                        'permissions' => ['Manage Menu'],
                    ],
                    [
                        'title' => 'Home',
                        'slug' => '#',
                        'link' => apa('post'),
                        'icon' => 'typcn typcn-home-outline',
                        'permissions' => ['Manage Home'],
                        'children' => [
                            [
                                'title' => 'Banner',
                                'slug' => 'banner',
                                'link' => apa('post/banner'),
                                'icon' => 'typcn typcn-image',
                                'permissions' => ['Manage Banner'],
                            ],
                        ],
                    ],
        
                    [
                        'title' => 'Terms And Conditions',
                        'slug' => 'terms-and-conditions',
                        'icon' => 'typcn icon typcn-pen',
                        'link' => apa('post/terms-and-conditions'),
                        'permissions' => ['Manage Terms And Conditions'],
                    ],
                    [
                        'title' => 'Privacy Policy',
                        'slug' => 'privacy-policy',
                        'link' => apa('post/privacy-policy'),
                        'icon' => 'typcn icon typcn-pen',
                        'permissions' => ['Manage Privacy Policy'],
                    ],
                ],
            ],
        ];
    @endphp
    @foreach ($monLinks as $item)
        @if (Auth::user() &&
                (Auth::user()->hasAnyPermission($item['permissions']) ||
                    Auth::user()->hasAnyRole(['Super Admin', 'System Administrator'])))
            <li class="nav-item sp-nav-item {{ get_admin_menu_active_class($currentURI, [$item['slug']]) }}">

                @if (!isset($item['children']))
                    <a class="nav-link" href="{{ $item['link'] }}"><i class=""></i>{{ $item['title'] }}</a>
                @else
                    <a class="nav-link with-sub {{ get_admin_menu_active_class($currentURI, [$item['slug']]) }}"
                        href="#"><i
                            class=" {{ $item['icon'] }} active-before transition active"></i>{{ $item['title'] }}</a>
                    <ul class="submenu {{ $menuPosition == 'top' ? 'az-menu-sub' : 'nav-sub' }}">
                        @foreach ($item['children'] as $childItem)
                            @if (!isset($childItem['children']))
                                <li
                                    class="nav-item {{ get_admin_menu_active_class($currentURI, [$childItem['slug']]) }}">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI, [$childItem['slug']]) }}"
                                        href="{{ $childItem['link'] }}"><i
                                            class=" {{ $childItem['icon'] }}"></i>{{ $childItem['title'] }}</a>
                                </li>
                            @else
                                <li
                                    class="nav-item sub-nav-item {{ get_admin_menu_active_class($currentURI, [$childItem['slug']]) }}">
                                    <a class="nav-link with-sub {{ get_admin_menu_active_class($currentURI, [$childItem['slug']]) }}"
                                        href="#"><i
                                            class=" {{ $childItem['icon'] }} active-before transition active"></i>{{ $childItem['title'] }}</a>
                                    <ul
                                        class="submenu-2 {{ $menuPosition == 'top' ? 'az-menu-sub-2' : 'nav-sub-2' }} list-hidden">
                                        @foreach ($childItem['children'] as $childItemRow)
                                            <li
                                                class="nav-item  {{ get_admin_menu_active_class($currentURI, [$childItemRow['slug']]) }}">
                                                <a class="nav-link  {{ get_admin_menu_active_class($currentURI, [$childItemRow['slug']]) }}"
                                                    href="{{ $childItemRow['link'] }}"><i
                                                        class=" {{ $childItemRow['icon'] }}"></i>{{ $childItemRow['title'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif

            </li>
        @endif
    @endforeach
    @if (Auth::user()->hasAnyRole(['Super Admin', 'System Administrator']))
   <li class="nav-item sp-nav-item ">
	<a class="nav-link  with-sub {{ get_admin_menu_active_class($currentURI, ['users', 'roles', 'permissions', 'audit-logs', 'custom-post']) }}"
	href="#"><i    class="  active-before transition active"></i>{{ lang('manage_privileges') }}</a>
	<ul class="submenu {{ $menuPosition == 'top' ? 'az-menu-sub' : 'nav-sub' }}">
		<li class="nav-item sub-nav-item {{ get_admin_menu_active_class($currentURI, ['roles']) }}">
		<a class="nav-link  {{ get_admin_menu_active_class($currentURI, ['roles']) }}"
		href="{{ apa('roles') }}" ><i class="fas fa-user-tag"></i> {{ lang('roles') }}</a>
		</li>
		<li class="nav-item sub-nav-item {{ get_admin_menu_active_class($currentURI, ['permissions']) }}">
		<a class="nav-link  {{ get_admin_menu_active_class($currentURI, ['permissions']) }}"
		href="{{ apa('permissions') }}" ><i class="fas fa-user-tag"></i> {{ lang('permissions') }}</a>
		</li>
		<li class="nav-item sub-nav-item {{ get_admin_menu_active_class($currentURI, ['audit-logs']) }}">
		<a class="nav-link  {{ get_admin_menu_active_class($currentURI, ['audit-logs']) }}"
		href="{{ apa('audit-logs') }}" ><i class="fas fa-user-tag"></i> {{ lang('audit_logs') }}</a>
		</li>
		 @env('development')
		 <li class="nav-item sub-nav-item {{ get_admin_menu_active_class($currentURI, ['add-post-type']) }}">
		<a class="nav-link  {{ get_admin_menu_active_class($currentURI, ['add-post-type']) }}"
		href="{{ apa('add-post-type') }}" ><i class="fas fa-user-tag"></i> {{ lang('add_post_type') }}</a>
		</li>
		<li class="nav-item sub-nav-item {{ get_admin_menu_active_class($currentURI, ['mail-templates']) }}">
		<a class="nav-link  {{ get_admin_menu_active_class($currentURI, ['mail-templates']) }}"
		href="{{ route('admin_mailtemplate') }}" ><i class="fas fa-user-tag"></i> {{ lang('mail-templates') }}</a>
		</li>
		@endenv
	</ul>
	</li>
    @endif
</ul>
