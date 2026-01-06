<div class="app-header-menu app-header-mobile-drawer align-items-stretch"
     data-kt-drawer="true"
     data-kt-drawer-name="app-header-menu"
     data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true"
     data-kt-drawer-width="250px"
     data-kt-drawer-direction="{{ app()->getLocale() == 'ar' ? 'start' : 'end' }}"
     data-kt-drawer-toggle="#kt_app_header_menu_toggle"
     data-kt-swapper="true"
     data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
     data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">

    <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">

        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
             data-kt-menu-placement="{{ app()->getLocale() == 'ar' ? 'bottom-end' : 'bottom-start' }}"
             class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
          <span class="menu-link">
             <span class="menu-title">{{ __('menu.dashboard') }}</span>
             <span class="menu-arrow d-lg-none"></span>
          </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-850px">
                @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/header/_menu/__dashboards')
            </div>
        </div>
        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
             data-kt-menu-placement="{{ app()->getLocale() == 'ar' ? 'bottom-end' : 'bottom-start' }}"
             class="menu-item menu-lg-down-accordion me-0 me-lg-2">
          <span class="menu-link">
             <span class="menu-title">{{ __('menu.pages') }}</span>
             <span class="menu-arrow d-lg-none"></span>
          </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0">
                @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/header/_menu/__pages')
            </div>
        </div>
    </div>
</div>
