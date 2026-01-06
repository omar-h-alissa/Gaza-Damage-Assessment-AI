<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
   data-kt-menu-trigger="click"
   {{-- تعديل مكان ظهور القائمة برمجياً --}}
   data-kt-menu-placement="{{ app()->getLocale() == 'ar' ? 'bottom-start' : 'bottom-end' }}">
    {{ __('menu.actions') }}
    <i class="ki-duotone ki-down fs-5 {{ app()->getLocale() == 'ar' ? 'me-1' : 'ms-1' }}"></i>
</a>

<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
    <div class="menu-item px-3">
        <a href="{{ route('user-management.users.show', $user) }}" class="menu-link px-3">
            {{ __('menu.view') }}
        </a>
    </div>
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3" data-kt-user-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" data-kt-action="update_row">
            {{ __('menu.edit') }}
        </a>
    </div>
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3" data-kt-user-id="{{ $user->id }}" data-kt-action="delete_row">
            {{ __('menu.delete') }}
        </a>
    </div>
</div>
