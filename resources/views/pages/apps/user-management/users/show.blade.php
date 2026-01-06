<x-default-layout>
    @section('title')
        {{ __('menu.users') }} - {{ $user->name }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.show', $user) }}
    @endsection

    <!-- Top Header Card -->
    <div class="card mb-6 mb-xl-9">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <!-- User Avatar -->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-150px symbol-fixed position-relative">
                        @if($user->profile_photo_url)
                            <img src="{{ $user->profile_photo_url }}" alt="image"
                                 class="border border-3 border-white shadow-sm"/>
                        @else
                            <div
                                class="symbol-label fs-1 fw-bold {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-primary text-primary', $user->name) }}">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-1">
                                <span class="text-gray-900 fs-2 fw-bold me-1">{{ $user->name }}</span>
                                <i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </div>
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <span class="d-flex align-items-center text-gray-500 me-5 mb-2">
                                    <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    {{ $user->address_city }}
                                </span>
                                <span class="d-flex align-items-center text-gray-500 mb-2">
                                    <i class="ki-duotone ki-calendar fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    {{ __('menu.last_login') }}: {{ $user->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex my-4">
                            <button class="btn btn-sm btn-light-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update_details">
                                <i class="ki-duotone ki-pencil fs-3"></i> {{ __('menu.edit') }}
                            </button>
                            <button class="btn btn-sm btn-light-danger" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update_password">
                                <i class="ki-duotone ki-key fs-3"></i> {{ __('menu.update_password') }}
                            </button>
                        </div>
                    </div>

                    <!-- Modern Stats Grid -->
                    <div class="d-flex flex-wrap">
                        <div class="border border-gray-300 border-dashed rounded min-w-150px py-3 px-4 me-6 mb-3">
                            <div class="fw-semibold fs-6 text-gray-500 mb-1">{{ __('menu.phone') }}</div>
                            <div class="fs-4 fw-bold text-gray-900"
                                 style="direction: ltr; text-align: left;">{{ $user->phone }}</div>
                        </div>
                        <div class="border border-gray-300 border-dashed rounded min-w-150px py-3 px-4 me-6 mb-3">
                            <div class="fw-semibold fs-6 text-gray-500 mb-1">{{ __('menu.family_members') }}</div>
                            <div class="fs-2 fw-bold text-gray-900">{{ $user->family_members }}</div>
                        </div>
                        <div class="border border-gray-300 border-dashed rounded min-w-150px py-3 px-4 me-6 mb-3">
                            <div class="fw-semibold fs-6 text-gray-500 mb-1">{{ __('menu.account_type') }}</div>
                            <div class="fs-4 fw-bold">
                                <span
                                    class="badge badge-light-primary fs-7 fw-bold">{{ strtoupper($user->roles->first()?->name ?? __('menu.standard')) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details and Documents Row -->
    <div class="row g-6 g-xl-9">
        <!-- Sidebar: Personal Info -->
        <div class="col-xl-4">
            <div class="card card-flush h-xl-100">
                <div class="card-header pt-7">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">{{ __('menu.personal_info') }}</span>
                    </h3>
                </div>
                <div class="card-body pt-5">
                    <div class="d-flex flex-stack mb-7">
                        <div class="fw-semibold text-gray-600 me-2">{{ __('menu.national_id') }}</div>
                        <div class="d-flex align-items-center">
                            <span class="text-gray-800 fw-bold fs-6 me-1">ID-{{ $user->national_id }}</span>
                            <button class="btn btn-icon btn-sm btn-active-color-primary"
                                    onclick="navigator.clipboard.writeText('{{ $user->national_id }}')"
                                    title="{{ __('menu.copy_id') }}">
                                <i class="ki-duotone ki-copy fs-5"></i>
                            </button>
                        </div>
                    </div>

                    <div class="separator separator-dashed mb-7"></div>

                    <div class="mb-7">
                        <div class="fw-semibold text-gray-600 mb-3">{{ __('menu.address') }}</div>
                        <div class="d-flex align-items-center bg-light-dark p-4 rounded-2">
                            <i class="ki-duotone ki-geolocation fs-1 text-primary me-4"></i>
                            <div class="fs-6 fw-semibold text-gray-700">
                                {{ $user->address_area }}<br/>
                                <span
                                    class="text-muted fs-7">{{ $user->address_street }}, {{ $user->address_details }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-xl-8">
            <!-- Quick Stats -->
            <div class="row g-5 mb-6">
                <div class="col-sm-4">
                    <div class="card card-flush h-100 bg-light-primary border-0">
                        <div class="card-body d-flex flex-column justify-content-center text-center py-6">
                            <span class="fs-2hx fw-bold text-primary">{{ $user->activities->count() }}</span>
                            <span class="fs-6 fw-semibold text-gray-600">{{ __('menu.total_activities') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card card-flush h-100 bg-light-danger border-0">
                        <div class="card-body d-flex flex-column justify-content-center text-center py-6">
                            <span class="fs-2hx fw-bold text-danger">{{ $user->reports->count() }}</span>
                            <span class="fs-6 fw-semibold text-gray-600">{{ __('menu.linked_reports') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card card-flush h-100 bg-light-success border-0">
                        <div class="card-body d-flex flex-column justify-content-center text-center py-6">
                            <span class="fs-2hx fw-bold text-success">
                                {{ $user->activities->where('created_at', '>=', now()->subDays(7))->count() }}
                            </span>
                            <span class="fs-6 fw-semibold text-gray-600">{{ __('menu.recent_activities_7d') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row for Timeline and Reports -->
            <div class="row g-6">
                <!-- Timeline Card -->
                <div class="col-lg-6">
                    <div class="card card-flush h-lg-100">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">{{ __('menu.activity_log') }}</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">{{ __('menu.real_time_sync') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-6">
                            <div class="timeline-label">
                                @forelse($user->activities()->latest()->take(4)->get() as $activity)
                                    <div class="timeline-item">
                                        <div class="timeline-label fw-bold text-gray-800 fs-7" style="width: 70px;">
                                            {{ $activity->created_at->format('H:i') }}
                                        </div>
                                        <div class="timeline-badge">
                                            <i class="bi {{ $activity->icon }} fs-3 text-{{ $activity->type }}"></i>
                                        </div>
                                        <div class="timeline-content ps-3">
                                            <span class="text-gray-800 fw-bold">{{ $activity->title }}</span>
                                            <div
                                                class="text-muted fs-8">{{ $activity->created_at->format('Y-m-d') }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <span class="text-muted fs-7">{{ __('menu.no_activities_found') }}</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reports Table Card -->
                <div class="col-lg-6">
                    <div class="card card-flush h-lg-100">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">{{ __('menu.technical_reports') }}</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">{{ __('menu.latest_tickets') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-3">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="min-w-100px">{{ __('menu.subject') }}</th>
                                        <th class="min-w-60px text-end">{{ __('menu.status') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($user->reports()->latest()->take(4)->get() as $report)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <a href="#"
                                                       class="text-gray-900 fw-bold text-hover-primary mb-1 fs-7">
                                                        {{ Str::limit($report->damage_description ?? __('menu.no_subject'), 20) }}
                                                    </a>
                                                    <span
                                                        class="text-muted fs-8">{{ $report->created_at->diffForHumans() }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                   <span class="badge
    {{ $report->status == 'approved' ? 'badge-light-success' : ($report->status == 'rejected' ? 'badge-light-danger' : 'badge-light-warning') }}
    fs-8 fw-bold">
    {{ __('menu.' . ($report->status ?? 'pending')) }}
</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2"
                                                class="text-center text-muted py-10 fs-7">{{ __('menu.no_reports_found') }}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.apps/user-management/users/modals/_update-details')
    @include('pages.apps/user-management/users/modals/_update-password')
</x-default-layout>
