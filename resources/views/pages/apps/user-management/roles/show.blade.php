<x-default-layout>

    @section('title')
        {{ __('menu.roles') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.roles.show', $role) }}
    @endsection

    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
                <div class="card card-flush">
                    <div class="card-header">
                        <div class="card-title">
                            <h2 class="mb-0">{{ ucwords($role->name) }}</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-column text-gray-600">
                            @foreach($role->permissions->shuffle()->take(7) as $permission)
                                <div class="d-flex align-items-center py-2">
                                    {{-- استخدام me-3 أو ms-3 حسب اللغة للرصاصة (Bullet) --}}
                                    <span class="bullet bg-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></span>
                                    {{ ucfirst($permission->name) }}
                                </div>
                            @endforeach

                            @if($role->permissions->count() > 7)
                                <div class="d-flex align-items-center py-2">
                                    <span class='bullet bg-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}'></span>
                                    <em>{{ __('menu.and') }} {{ $role->permissions->count()-7 }} {{ __('menu.more') }}</em>
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
                    <div class="card-footer pt-0">
                        <button type="button" class="btn btn-light btn-active-primary" data-role-id="{{ $role->id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                            {{ __('menu.edit_role') }}
                        </button>
                    </div>
                </div>
            </div>
            {{-- تبديل الهامش من اليسار إلى اليمين في حال العربية --}}
            <div class="flex-lg-row-fluid {{ app()->getLocale() == 'ar' ? 'me-lg-10' : 'ms-lg-10' }}">
                <div class="card card-flush mb-6 mb-xl-9">
                    <div class="card-header pt-5">
                        <div class="card-title">
                            <h2 class="d-flex align-items-center">
                                {{ __('menu.users_assigned') }}
                                <span class="text-gray-600 fs-6 {{ app()->getLocale() == 'ar' ? 'me-1' : 'ms-1' }}">({{ $role->users->count() }})</span>
                            </h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:permission.role-modal></livewire:permission.role-modal>
    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush

</x-default-layout>
