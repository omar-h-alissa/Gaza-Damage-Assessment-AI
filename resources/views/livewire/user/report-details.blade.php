<div>
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="d-flex flex-column flex-lg-row">

            <!-- Sidebar: Report Details -->
            <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
                <div class="card card-flush">
                    <div class="card-header border-0 pt-5">
                        <div class="card-title flex-column">
                            <h2 class="mb-0 fs-2 fw-bold">{{ __('menu.report_details') }} #{{ $report->id }}</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="d-flex flex-column text-gray-600 gap-3">
                            <div class="d-flex align-items-center">
                                <span
                                    class="bullet bg-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></span>
                                <strong>{{ __('menu.property_address') }}:</strong> {{ $report->property->address }}
                            </div>
                            <div class="d-flex align-items-center">
                                <span
                                    class="bullet bg-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></span>
                                <strong>{{ __('menu.owner') }}:</strong> {{ $report->property->property_owner }}
                            </div>
                            <div class="d-flex align-items-center">
                                <span
                                    class="bullet bg-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></span>
                                <strong>{{ __('menu.damage_type') }}:</strong> {{ ucfirst($report->damage_type) }}
                            </div>
                            <div class="d-flex align-items-center">
                                <span
                                    class="bullet bg-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></span>
                                <strong>{{ __('menu.report_date') }}
                                    :</strong> {{ $report->created_at->format('Y-m-d') }}
                            </div>
                        </div>
                    </div>

                    @if($report->status === 'pending')
                        <div class="card-footer pt-0 text-center">
                            <button wire:click="deleteRepot({{ $report->id }})" class="btn btn-sm btn-light-danger"
                                    onclick="return confirm('{{ __('menu.delete_confirmation') }}')">
                                <i class="ki-duotone ki-trash fs-5"></i> {{ __('menu.delete') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-lg-row-fluid {{ app()->getLocale() == 'ar' ? 'me-lg-10' : 'ms-lg-10' }}">
                <div class="card card-flush mb-6 mb-xl-9 shadow-sm">
                    <div class="card-header pt-5 border-0 d-flex justify-content-between align-items-center">
                        <h2 class="card-title fw-bold text-primary">{{ __('menu.report_info') }}</h2>

                        @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                            @if($report->status === 'pending')
                                <div class="d-flex gap-2">
                                    <button wire:click="approve({{ $report->id }})" class="btn btn-success btn-sm">
                                        {{ __('menu.approve') }}
                                    </button>
                                    <button wire:click="openRejectModal" class="btn btn-danger btn-sm">
                                        {{ __('menu.reject') }}
                                    </button>
                                </div>
                            @else
                                <span
                                    class="badge {{ $report->status=='approved' ? 'bg-success' : ($report->status=='rejected' ? 'bg-danger' : 'bg-warning') }} text-white fw-bold px-4 py-2">
                                    {{ __('menu.' . $report->status) }}
                                </span>
                            @endif
                        @else
                            <span
                                class="badge {{ $report->status=='approved' ? 'bg-success' : ($report->status=='rejected' ? 'bg-danger' : 'bg-warning') }} text-white fw-bold px-4 py-2">
                                {{ __('menu.' . $report->status) }}
                            </span>
                        @endif
                    </div>

                    <div class="card-body pt-0">
                        @if($report->status === 'rejected' && $report->reject_reason)
                            <div
                                class="alert alert-danger d-flex align-items-start p-5 mb-8 border-dashed border-danger">
                                <i class="ki-duotone ki-information-5 fs-2hx text-danger {{ app()->getLocale() == 'ar' ? 'ms-4' : 'me-4' }}"></i>
                                <div>
                                    <h4 class="fw-bold text-danger mb-2">{{ __('menu.rejection_reason') }}</h4>
                                    <div class="fs-6">{{ $report->reject_reason }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Description -->
                        <div class="mb-10">
                            <h4 class="fw-bold text-gray-800 mb-3 border-bottom pb-2">{{ __('menu.damage_description') }}</h4>
                            <p class="text-gray-700 fs-6 lh-lg">{{ $report->damage_description }}</p>
                        </div>

                        <!-- Photos -->
                        <div class="mb-10">
                            <h4 class="fw-bold text-gray-800 mb-4">{{ __('menu.damage_photos') }}</h4>
                            @if($report->images->count())
                                <div class="row g-5">
                                    @foreach($report->images as $img)
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="overlay overflow-hidden rounded shadow-sm border">
                                                <div class="overlay-wrapper">
                                                    <img src="{{ asset('storage/' . $img->path) }}"
                                                         class="w-100 rounded img-clickable h-150px"
                                                         style="object-fit: cover;" data-bs-toggle="modal"
                                                         data-bs-target="#photoModal"
                                                         data-src="{{ asset('storage/' . $img->path) }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning border-dashed d-flex align-items-center">
                                    <i class="ki-duotone ki-warning fs-2hx text-warning me-3"></i>
                                    {{ __('menu.no_photos') }}
                                </div>
                            @endif
                        </div>

                        <!-- AI Analysis Section -->
                        {{--
  AI Analysis Component
  Supports RTL/LTR and Localization
--}}

                        <div class="mb-10 mt-5">
                            <!-- Header with AI Icon -->
                            <div class="d-flex align-items-center mb-6">
                                <div class="symbol symbol-40px {{ app()->getLocale() == 'ar' ? 'ms-4' : 'me-4' }}">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="ki-duotone ki-artificial-intelligence fs-1 text-primary">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="fw-bold text-gray-900 mb-0">{{ __('menu.ai_analysis') }}</h4>
                                    <span class="text-muted fs-7 fw-semibold">{{ __('menu.ai_engine_info') }}</span>
                                </div>
                            </div>

                            @if(isset($report->ai_analysis_data))
                                @php
                                    $percentage = (int)($report->ai_analysis_data['percentage'] ?? 0);

                                    // Configuration based on damage level
                                    if($percentage >= 70) {
                                        $statusColor = "#f1416c";
                                        $statusBg = "bg-light-danger";
                                        $statusText = __('menu.critical_damage');
                                        $pulseClass = "pulse-danger";
                                    } elseif($percentage >= 30) {
                                        $statusColor = "#ffc700";
                                        $statusBg = "bg-light-warning";
                                        $statusText = __('menu.significant_damage');
                                        $pulseClass = "pulse-warning";
                                    } else {
                                        $statusColor = "#50cd89";
                                        $statusBg = "bg-light-success";
                                        $statusText = __('menu.minor_damage');
                                        $pulseClass = "pulse-success";
                                    }
                                @endphp

                                <style>
                                    .ai-card-glass {
                                        background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.4) 100%);
                                        backdrop-filter: blur(10px);
                                        border: 1px solid rgba(255, 255, 255, 0.3);
                                        border-radius: 20px;
                                        transition: transform 0.3s ease;
                                    }

                                    .ai-card-glass:hover {
                                        transform: translateY(-5px);
                                    }

                                    .circular-chart {
                                        display: block;
                                        margin: 10px auto;
                                        max-width: 120px;
                                        max-height: 120px;
                                    }

                                    .circle-bg {
                                        fill: none;
                                        stroke: #eee;
                                        stroke-width: 2.8;
                                    }

                                    .circle {
                                        fill: none;
                                        stroke-width: 2.8;
                                        stroke-linecap: round;
                                        animation: progress 1.5s ease-out forwards;
                                    }

                                    @keyframes progress {
                                        0% {
                                            stroke-dasharray: 0 100;
                                        }
                                    }

                                    .percentage-text {
                                        fill: #333;
                                        font-family: sans-serif;
                                        font-size: 0.5em;
                                        text-anchor: middle;
                                        font-weight: bold;
                                    }

                                    /* RTL Adjustment for border-start */
                                    [dir="rtl"] .border-start-4 {
                                        border-left: 0 !important;
                                        border-right: 4px solid !important;
                                    }
                                </style>

                                <div class="row g-7">
                                    <!-- Left Tool: Circular Progress -->
                                    <div class="col-md-5">
                                        <div
                                            class="ai-card-glass p-8 h-100 d-flex flex-column align-items-center justify-content-center shadow-sm">
                                            <svg viewBox="0 0 36 36" class="circular-chart">
                                                <path class="circle-bg"
                                                      d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                                <path class="circle" stroke="{{ $statusColor }}"
                                                      stroke-dasharray="{{ $percentage }}, 100"
                                                      d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                                <text x="18" y="20.35" class="percentage-text">{{ $percentage }}%</text>
                                            </svg>
                                            <div class="text-center mt-4">
                                                <span
                                                    class="fw-bold fs-5 text-gray-800 d-block">{{ __('menu.damage_percentage') }}</span>
                                                <span
                                                    class="text-muted fs-7">{{ __('menu.visual_confidence') }}: 94%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Tool: Status Insight -->
                                    <div class="col-md-7">
                                        <div class="ai-card-glass p-8 h-100 shadow-sm border-start-4"
                                             style="{{ app()->getLocale() == 'ar' ? 'border-right' : 'border-left' }}: 4px solid {{ $statusColor }} !important;">
                                            <div class="d-flex justify-content-between align-items-start mb-4">
                                                <div>
                                                    <span
                                                        class="fs-7 text-uppercase fw-bold text-muted ls-1 d-block mb-1">{{ __('menu.system_assessment') }}</span>
                                                    <h3 class="fw-bolder text-gray-900 mb-0"
                                                        style="color: {{ $statusColor }} !important;">
                                                        {{ $statusText }}
                                                    </h3>
                                                </div>
                                                <div class="pulse {{ $pulseClass }}">
                                                    <span class="pulse-ring"></span>
                                                    <span
                                                        class="badge {{ $statusBg }} text-white p-3 h-40px w-40px d-flex align-items-center justify-content-center rounded-circle">
                                <i class="ki-duotone ki-shield-search fs-2" style="color: {{ $statusColor }}"></i>
                            </span>
                                                </div>
                                            </div>

                                            <div class="separator separator-dashed my-5"></div>

                                            <div class="d-flex flex-column gap-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-duotone ki-check-circle fs-3 text-success {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                                    <span class="text-gray-600 fs-7">{{ __('menu.identified_pattern') }}: <b
                                                            class="text-gray-800">{{ __('menu.structural_stress') }}</b></span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-duotone ki-check-circle fs-3 text-success {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                                    <span class="text-gray-600 fs-7">{{ __('menu.recommended_action') }}: <b
                                                            class="text-gray-800">{{ __('menu.onsite_verification') }}</b></span>
                                                </div>
                                            </div>

                                            <div class="mt-8">
                                                <div class="d-flex flex-stack mb-2">
                                                    <span
                                                        class="text-muted fs-8 fw-bold">{{ __('menu.risk_threshold') }}</span>
                                                    <span class="text-gray-800 fs-8 fw-bolder">
                                {{ $percentage >= 50 ? __('menu.high_risk') : __('menu.stable') }}
                            </span>
                                                </div>
                                                <div class="h-4px w-100 bg-light mb-2 rounded">
                                                    <div class="rounded h-4px"
                                                         style="width: {{ $percentage }}%; background-color: {{ $statusColor }};"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
