<div class="card card-flush h-md-100">
    <div class="card-header pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">{{ __('menu.last_reports') }}</span>
        </h3>
        <div class="card-toolbar">
            <a href="{{ route('user-management.reports.index') }}" class="btn btn-sm btn-light">{{ __('menu.reports') }}</a>
        </div>
    </div>
    <div class="card-body pt-6">
        <div class="table-responsive">
            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                <thead>
                <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                    <th class="p-0 pb-3 min-w-50px">{{ __('menu.id') }}</th>
                    <th class="p-0 pb-3 min-w-175px">{{ __('menu.report') }}</th>
                    <th class="p-0 pb-3 min-w-125px">{{ __('menu.ai_analysis') }}</th>
                    <th class="p-0 pb-3 min-w-100px text-start">{{ __('menu.status') }}</th>
                    <th class="p-0 pb-3 min-w-125px">{{ __('menu.date') }}</th>
                    <th class="p-0 pb-3 min-w-50px text-end">{{ __('menu.view') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($latestReports as $report)
                    <tr>
                        <td>
                            <span class="text-gray-600 fw-bold fs-6">{{ $report->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-3">
                                    <img src="{{ $report->user->profile_photo_url ?? asset('stock/600x600/default.jpg') }}" alt=""/>
                                </div>
                                <div class="d-flex justify-content-start flex-column">
                                    <a href="{{ route('user-management.reports.show', $report->id) }}"
                                       class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                                        {{ $report->damage_type_data }}
                                    </a>
                                    <span class="text-gray-400 fw-semibold d-block fs-7">{{ $report->user->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-gray-600 fw-bold fs-6">{{ $report->ai_analysis_data['percentage'] ?? '—' }}%</span>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'in_process' => 'primary',
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                ];
                                $color = $statusColors[$report->status] ?? 'secondary';
                            @endphp
                            {{-- لاحظ استخدام __() لترجمة الحالة القادمة من قاعدة البيانات --}}
                            <span class="badge py-3 px-4 fs-7 badge-light-{{ $color }}">
                                {{ __('menu.' . $report->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="text-gray-600 fw-bold fs-6">
                                {{ $report->created_at->format('Y-m-d') }}
                            </span>
                        </td>

                        <td class="text-end">
                            <a href="{{ route('user-management.reports.show', $report->id) }}"
                               class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                {{-- قمنا بعكس الأيقونة برمجياً باستخدام كلاس mirror-rtl الذي أنشأناه سابقاً --}}
                                {!! getIcon('black-right', 'fs-2 text-gray-500 mirror-rtl') !!}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
