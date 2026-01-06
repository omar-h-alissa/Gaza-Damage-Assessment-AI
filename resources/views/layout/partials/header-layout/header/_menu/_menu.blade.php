<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
    <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">

        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
          <span class="menu-link">
             <span class="menu-title">{{ __('menu.dashboards') }}</span>
             <span class="menu-arrow d-lg-none"></span>
          </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-850px">
                @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/header-layout/header/_menu/__dashboards')
            </div>
        </div>

        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2">
          <span class="menu-link">
             <span class="menu-title">{{ __('menu.pages') }}</span>
             <span class="menu-arrow d-lg-none"></span>
          </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0">
                @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/header-layout/header/_menu/__pages')
            </div>
        </div>

        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
          <span class="menu-link">
             <span class="menu-title">{{ __('menu.apps') }}</span>
             <span class="menu-arrow d-lg-none"></span>
          </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">

                <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                <span class="menu-link">
                   <span class="menu-icon">{!! getIcon('rocket', 'fs-2') !!}</span>
                   <span class="menu-title">{{ __('menu.projects') }}</span>
                   <span class="menu-arrow"></span>
                </span>
                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                        <div class="menu-item"><a class="menu-link" href="{{ route('dashboard') }}"><span class="menu-title">{{ __('menu.my_projects') }}</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="{{ route('dashboard') }}"><span class="menu-title">{{ __('menu.view_project') }}</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="{{ route('dashboard') }}"><span class="menu-title">{{ __('menu.targets') }}</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="{{ route('dashboard') }}"><span class="menu-title">{{ __('menu.budget') }}</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="{{ route('dashboard') }}"><span class="menu-title">{{ __('menu.users') }}</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="{{ route('dashboard') }}"><span class="menu-title">{{ __('menu.files') }}</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="{{ route('dashboard') }}"><span class="menu-title">{{ __('menu.activity') }}</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="{{ route('dashboard') }}"><span class="menu-title">{{ __('menu.settings') }}</span></a></div>
                    </div>
                </div>

                <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                <span class="menu-link">
                   <span class="menu-icon">{!! getIcon('handcart', 'fs-2') !!}</span>
                   <span class="menu-title">{{ __('menu.ecommerce') }}</span>
                   <span class="menu-arrow"></span>
                </span>
                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                        <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                            <span class="menu-link"><span class="menu-title">{{ __('menu.catalog') }}</span><span class="menu-arrow"></span></span>
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                                <div class="menu-item"><a class="menu-link" href="#"><span class="menu-title">{{ __('menu.products') }}</span></a></div>
                                <div class="menu-item"><a class="menu-link" href="#"><span class="menu-title">{{ __('menu.categories') }}</span></a></div>
                                <div class="menu-item"><a class="menu-link" href="#"><span class="menu-title">{{ __('menu.add_product') }}</span></a></div>
                                <div class="menu-item"><a class="menu-link" href="#"><span class="menu-title">{{ __('menu.add_category') }}</span></a></div>
                            </div>
                        </div>
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion menu-sub-indention">
                            <span class="menu-link"><span class="menu-title">{{ __('menu.sales') }}</span><span class="menu-arrow"></span></span>
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item"><a class="menu-link" href="#"><span class="menu-title">{{ __('menu.orders_listing') }}</span></a></div>
                                <div class="menu-item"><a class="menu-link" href="#"><span class="menu-title">{{ __('menu.add_order') }}</span></a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                <span class="menu-link">
                   <span class="menu-icon">{!! getIcon('chart', 'fs-2') !!}</span>
                   <span class="menu-title">{{ __('menu.support_center') }}</span>
                   <span class="menu-arrow"></span>
                </span>
                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                        <div class="menu-item"><a class="menu-link" href="#"><span class="menu-title">{{ __('menu.overview') }}</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="#"><span class="menu-title">{{ __('menu.faq') }}</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="#"><span class="menu-title">{{ __('menu.contact_us') }}</span></a></div>
                    </div>
                </div>

                <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                <span class="menu-link">
                   <span class="menu-icon">{!! getIcon('shield-tick', 'fs-2') !!}</span>
                   <span class="menu-title">{{ __('menu.user_management') }}</span>
                   <span class="menu-arrow"></span>
                </span>
                </div>

            </div>
        </div>

    </div>
</div>
