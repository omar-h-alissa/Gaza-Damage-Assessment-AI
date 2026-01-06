<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
         data-kt-scroll-activate="true" data-kt-scroll-height="auto"
         data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
         data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu"
             data-kt-menu="true" data-kt-menu-expand="false">

            <div data-kt-menu-trigger="click"
                 class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
                    <span class="menu-title">{{ __('menu.dashboards') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">{{ __('menu.home') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('menu.apps') }}</span>
                </div>
            </div>

            @can('super_admin' || 'admin')
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
                    <span class="menu-title">{{ __('menu.user_management') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('user-management.users.*') ? 'active' : '' }}" href="{{ route('user-management.users.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">{{ __('menu.users') }}</span>
                            </a>
                        </div>
                        @can('super_admin')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('user-management.roles.*') ? 'active' : '' }}" href="{{ route('user-management.roles.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('menu.roles') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('user-management.permissions.*') ? 'active' : '' }}" href="{{ route('user-management.permissions.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('menu.permissions') }}</span>
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
            @endcan

            <div data-kt-menu-trigger="click"
                 class="menu-item menu-accordion {{ request()->routeIs('user-management.properties.*') ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
                    <span class="menu-title">{{ __('menu.property_management') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('user-management.properties.index') ? 'active' : '' }}" href="{{ route('user-management.properties.index') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">{{ __('menu.properties') }}</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('user-management.properties.map') ? 'active' : '' }}" href="{{ route('user-management.properties.map') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">{{ __('menu.map') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div data-kt-menu-trigger="click"
                 class="menu-item menu-accordion {{ request()->routeIs('user-management.reports.*') ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
                    <span class="menu-title">{{ __('menu.report_management') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('user-management.reports.index') ? 'active' : '' }}" href="{{ route('user-management.reports.index') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">{{ __('menu.reports') }}</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('user-management.reports.map') ? 'active' : '' }}" href="{{ route('user-management.reports.map') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">{{ __('menu.map') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            @can('super_admin')
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ request()->routeIs('user-management.documents.*') ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
                    <span class="menu-title">{{ __('menu.document') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('user-management.documents.index') ? 'active' : '' }}" href="{{ route('user-management.documents.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">{{ __('menu.reports') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan

        </div>
    </div>
</div>
