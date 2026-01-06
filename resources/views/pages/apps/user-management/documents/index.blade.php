<x-default-layout>

    @section('title')
        {{ __('menu.documents') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.documents.index') }}
    @endsection

    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="row g-5 g-xl-8">

            @php
                $reports = [
                    [
                        'title' => __('menu.report_properties_title'),
                        'desc'  => __('menu.report_properties_desc'),
                        'icon'  => 'bi-house-gear',
                        'route' => 'user-management.documents.properties_by_damage'
                    ],
                    [
                        'title' => __('menu.report_damages_title'),
                        'desc'  => __('menu.report_damages_desc'),
                        'icon'  => 'bi-exclamation-diamond',
                        'route' => 'user-management.documents.damagesPdf'
                    ],
                    [
                        'title' => __('menu.report_severity_title'),
                        'desc'  => __('menu.report_severity_desc'),
                        'icon'  => 'bi-fire',
                        'route' => 'user-management.documents.severityPdf'
                    ],
                    [
                        'title' => __('menu.report_hotspots_title'),
                        'desc'  => __('menu.report_hotspots_desc'),
                        'icon'  => 'bi-geo-alt',
                        'route' => 'user-management.documents.areasPdf'
                    ],
                    [
                        'title' => __('menu.report_timeline_title'),
                        'desc'  => __('menu.report_timeline_desc'),
                        'icon'  => 'bi-calendar-event',
                        'route' => 'user-management.documents.reports_by_date'
                    ],
                    [
                        'title' => __('menu.report_unassessed_title'),
                        'desc'  => __('menu.report_unassessed_desc'),
                        'icon'  => 'bi-house-x',
                        'route' => 'user-management.documents.noReportsPdf'
                    ],
                ];
            @endphp

            @foreach($reports as $report)
                <div class="col-xl-4 col-md-6">
                    <div class="card card-flush h-100 shadow-sm">
                        <div class="card-body d-flex flex-column justify-content-between">

                            <div>
                                <div class="symbol symbol-45px mb-5">
                                    <span class="symbol-label bg-light-danger">
                                        <i class="bi {{ $report['icon'] }} fs-2x text-danger"></i>
                                    </span>
                                </div>

                                <h3 class="fw-bold mb-2">{{ $report['title'] }}</h3>
                                <p class="text-muted fs-6">{{ $report['desc'] }}</p>
                            </div>

                            <a href="{{ route($report['route']) }}"
                               class="btn btn-danger fw-semibold w-100 mt-4">
                                <i class="bi bi-file-earmark-arrow-down {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i>
                                {{ __('menu.download_pdf') }}
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-xl-4 col-md-6">
                <div class="card card-flush h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">

                        <div>
                            <div class="symbol symbol-45px mb-5">
                                <span class="symbol-label bg-light-danger">
                                    <i class="bi bi-file-earmark fs-2x text-danger"></i>
                                </span>
                            </div>

                            <h3 class="fw-bold mb-2">{{ __('menu.single_property_report') }}</h3>
                            <p class="text-muted fs-6">{{ __('menu.single_property_desc') }}</p>
                        </div>

                        <form action="{{ route('user-management.documents.property_full_details') }}"
                              method="POST" class="mt-3">
                            @csrf

                            <input type="number"
                                   name="property_id"
                                   class="form-control form-control-solid mb-3"
                                   placeholder="{{ __('menu.property_id_placeholder') }}"
                                   required>

                            <button class="btn btn-danger w-100 fw-semibold">
                                <i class="bi bi-file-earmark-arrow-down {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i>
                                {{ __('menu.download_pdf') }}
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-flush h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">

                        <div>
                            <div class="symbol symbol-45px mb-5">
                                <span class="symbol-label bg-light-danger">
                                    <i class="bi bi-bar-chart fs-2x text-danger"></i>
                                </span>
                            </div>

                            <h3 class="fw-bold mb-2">{{ __('menu.general_analytics_report') }}</h3>
                            <p class="text-muted fs-6">{{ __('menu.general_analytics_desc') }}</p>
                        </div>

                        <a href="{{ route('user-management.documents.analyticsPdf') }}"
                           class="btn btn-danger fw-semibold w-100 mt-4">
                            <i class="bi bi-file-earmark-arrow-down {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i>
                            {{ __('menu.download_pdf') }}
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>

</x-default-layout>
