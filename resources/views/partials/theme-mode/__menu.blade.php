<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
    <div class="menu-item px-3 my-0">
        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
            <span class="menu-icon" data-kt-element="icon">{!! getIcon('night-day', 'fs-2') !!}</span>
            <span class="menu-title">{{ __('menu.light') }}</span>
        </a>
    </div>
    <div class="menu-item px-3 my-0">
        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
            <span class="menu-icon" data-kt-element="icon">{!! getIcon('moon', 'fs-2') !!}</span>
            <span class="menu-title">{{ __('menu.dark') }}</span>
        </a>
    </div>
    <div class="menu-item px-3 my-0">
        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
            <span class="menu-icon" data-kt-element="icon">{!! getIcon('screen', 'fs-2') !!}</span>
            <span class="menu-title">{{ __('menu.system') }}</span>
        </a>
    </div>
</div>
