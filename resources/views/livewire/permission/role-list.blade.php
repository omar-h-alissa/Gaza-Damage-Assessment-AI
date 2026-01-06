<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
    @foreach($roles as $role)
        <div class="col-md-4">
            <div class="card card-flush h-md-100">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ ucwords($role->name) }}</h2>
                    </div>
                </div>
                <div class="card-body pt-1">
                    <div class="fw-bold text-gray-600 mb-5">{{ __('menu.total_users') }}: {{ $role->users->count() }}</div>
                    <div class="d-flex flex-column text-gray-600">
                        @foreach($role->permissions->shuffle()->take(5) ?? [] as $permission)
                            <div class="d-flex align-items-center py-2">
                                {{-- استخدام ms-3 بدلاً من me-3 في العربية للرصاصة --}}
                                <span class="bullet bg-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></span>
                                {{ ucfirst($permission->name) }}
                            </div>
                        @endforeach

                        @if($role->permissions->count() > 5)
                            <div class='d-flex align-items-center py-2'>
                                <span class='bullet bg-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}'></span>
                                <em>{{ __('menu.and') }} {{ $role->permissions->count()-5 }} {{ __('menu.more') }}</em>
                            </div>
                        @endif

                        @if($role->permissions->count() === 0)
                            <div class="d-flex align-items-center py-2">
                                <span class='bullet bg-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}'></span>
                                <em>{{ __('menu.no_permissions_given') }}</em>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer flex-wrap pt-0">
                    <a href="{{ route('user-management.roles.show', $role) }}" class="btn btn-light btn-active-primary my-1 {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}">
                        {{ __('menu.view_role') }}
                    </a>
                    <button type="button" class="btn btn-light btn-active-light-primary my-1" data-role-id="{{ $role->id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                        {{ __('menu.edit_role') }}
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    <div class="col-md-4">
        <div class="card h-md-100">
            <div class="card-body d-flex flex-center">
                <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                    <img src="{{ image('illustrations/sketchy-1/4.png') }}" alt="" class="mw-100 mh-150px mb-7"/>
                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">
                        {{ __('menu.add_new_role') }}
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
