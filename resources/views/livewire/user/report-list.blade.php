<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">

    <div class="col-md-4">
        <div class="card h-md-100">
            <div class="card-body d-flex flex-center">
                <button type="button" class="btn btn-clear d-flex flex-column flex-center"
                        data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_report">
                    <img src="{{ image('illustrations/sketchy-1/4.png') }}" alt="" class="mw-100 mh-150px mb-7"/>
                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">{{ __('menu.add_new_report') }}</div>
                </button>
            </div>
        </div>
    </div>
    @foreach($reports as $report)
        <div class="col-md-4">
            <div class="card card-flush h-md-100">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('menu.report_number') }} #{{ $report->id }}</h2>
                    </div>
                    <div class="card-toolbar">
                        <span class="badge badge-light-{{ $report->status == 'approved' ? 'success' : ($report->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ __('menu.' . $report->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body pt-1">
                    <div class="mb-3">
                        <strong class="text-gray-700">{{ __('menu.damage_type') }}:</strong>
                        <div class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $report->damage_type)) }}</div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-gray-700">{{ __('menu.description') }}:</strong>
                        <div class="text-gray-600">{{ Str::limit($report->damage_description, 80, '...') }}</div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-gray-700">{{ __('menu.reported_by') }}:</strong>
                        <div class="text-gray-600">{{ $report->user->name ?? __('menu.unknown_user') }}</div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-gray-700">{{ __('menu.property') }}:</strong>
                        <div class="text-gray-600">{{ $report->property->address ?? __('menu.na') }}</div>
                    </div>
                </div>
                <div class="card-footer flex-wrap pt-0">
                    <a href="{{ route('user-management.reports.show', $report->id) }}"
                       class="btn btn-light btn-active-info my-1 {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}">
                        {{ __('menu.view') }}
                    </a>

                    <button
                        wire:click="deleteRepot({{ $report->id }})"
                        class="btn btn-light-danger my-1"
                        onclick="return confirm('{{ __('menu.delete_report_confirm') }}')">
                        {{ __('menu.delete') }}
                    </button>
                </div>
            </div>
        </div>
    @endforeach

</div>
