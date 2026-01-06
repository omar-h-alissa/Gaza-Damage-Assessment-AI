<div class="card card-flush h-xl-100">
    <div class="card-header border-0 pt-5 d-flex flex-column">
        <h3 class="card-title fs-2 fw-bold text-dark">{{ __('menu.performance_title') }}</h3>
        <span class="text-muted fs-7">{{ __('menu.performance_subtitle') }}</span>
    </div>

    <div class="card-body py-5 d-flex flex-column gap-10">

        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-55px bg-light-primary rounded me-5 d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-time fs-1 text-primary"></i>
                </div>
                <div>
                    <span class="fw-bold fs-4 text-dark d-block">{{ __('menu.avg_processing_time') }}</span>
                    <span class="text-muted fw-semibold fs-6">{{ __('menu.avg_processing_subtitle') }}</span>
                </div>
            </div>
            <div class="text-end">
                <span class="fs-2 fw-bold text-primary">
                    {{ number_format($stats['completed'] > 0 ? ($stats['in_progress'] + $stats['pending']) / $stats['completed'] : 0, 1) }}
                </span>
                <span class="fs-5 text-muted">{{ __('menu.days') }}</span>
            </div>
        </div>

        <div class="separator separator-dashed"></div>

        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-55px bg-light-success rounded me-5 d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-chart-simple-3 fs-1 text-success"></i>
                </div>
                <div>
                    <span class="fw-bold fs-4 text-dark d-block">{{ __('menu.current_month_completions') }}</span>
                    <span class="text-muted fw-semibold fs-6">
                        {{ __('menu.last_month_subtitle', ['count' => $reportsGrowth[count($reportsGrowth) - 2] ?? 0]) }}
                    </span>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <div class="text-end me-4">
                    <span class="fs-2 fw-bold text-success">{{ $reportsGrowth[count($reportsGrowth) - 1] ?? 0 }}</span>
                    <span class="fs-5 text-muted">{{ __('menu.reports') }}</span>
                </div>
                @php
                    $last = $reportsGrowth[count($reportsGrowth) - 2] ?? 0;
                    $current = $reportsGrowth[count($reportsGrowth) - 1] ?? 0;
                    $percent = $last > 0 ? (($current - $last) / $last) * 100 : 0;
                @endphp
                <span class="badge bg-light-success text-success fw-bold px-4 py-2 fs-7 d-flex align-items-center">
                    <i class="ki-duotone ki-arrow-up fs-5 me-1 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}"></i>
                    {{ number_format($percent, 1) }}%
                </span>
            </div>
        </div>

        <div class="separator separator-dashed"></div>

        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-55px bg-light-info rounded me-5 d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-pin-location fs-1 text-info"></i>
                </div>
                <div>
                    <span class="fw-bold fs-4 text-dark d-block">{{ __('menu.avg_damage_index') }}</span>
                    <span class="text-muted fw-semibold fs-6">{{ __('menu.avg_damage_subtitle') }}</span>
                </div>
            </div>
            <div class="text-end">
                <span class="fs-2 fw-bold text-info">{{ number_format($averageDamageIndex, 1) }}%</span>
            </div>
        </div>

        <div class="separator separator-dashed"></div>

        @if($topDamagedArea && $topDamagedArea['area_name'])
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-55px bg-light-danger rounded me-5 d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-fire fs-1 text-danger"></i>
                    </div>
                    <div>
                        <span class="fw-bold fs-4 text-gray-800 d-block">{{ __('menu.top_damaged_area') }}</span>
                        <span class="text-muted fw-semibold fs-6">
                            {{ __('menu.top_damaged_subtitle', [
                                'area' => $topDamagedArea['area_name'],
                                'avg' => number_format($topDamagedArea['avg_damage'], 1)
                            ]) }}
                        </span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="fs-2 fw-bold text-danger">{{ number_format($topDamagedArea['reports_count']) }}</span>
                    <span class="fs-5 text-muted d-block mt-n1">{{ __('menu.reports') }}</span>
                </div>
            </div>
        @else
            <div class="p-5 bg-light-primary rounded text-center">
                <span class="text-primary fw-bold">{{ __('menu.no_data_area') }}</span>
            </div>
        @endif
    </div>
</div>
