<x-default-layout>

    @section('title')
        {{ __('menu.property') }} #{{ $property->id }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.properties.show', $property) }}
    @endsection

    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="d-flex flex-column flex-lg-row gap-10">

            <div class="flex-lg-row-fluid">

                <div class="card card-flush mb-8">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('menu.property_details') }}</h2>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('user-management.properties.edit', $property->id) }}"
                               class="btn btn-light btn-active-primary">
                                {{ __('menu.edit_property_btn') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="text-gray-700 fs-6">
                            <div class="mb-3">
                                <strong>{{ __('menu.owner') }}:</strong> {{ $property->property_owner }}
                            </div>

                            <div class="mb-3">
                                <strong>{{ __('menu.ownership') }}:</strong>
                                <span class="badge {{ $property->ownership_type == 'owned' ? 'badge-light-success' : 'badge-light-warning' }}">
                                    {{ $property->ownership_type == 'owned' ? __('menu.owned') : __('menu.rented') }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <strong>{{ __('menu.address') }}:</strong> {{ $property->address }}
                            </div>

                            <div class="mb-3">
                                <strong>{{ __('menu.floors') }}:</strong> {{ $property->floors_count ?? __('menu.na') }}
                            </div>

                            <div class="mb-3">
                                <strong>{{ __('menu.residents') }}:</strong> {{ $property->residents_count }}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card card-flush mb-8">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('menu.attachments') }}</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        @if($property->documents)
                            @php
                                $ext = strtolower(pathinfo($property->documents, PATHINFO_EXTENSION));
                                $url = asset('uploads/properties/' . $property->documents);
                            @endphp

                            {{-- عرض الصور --}}
                            @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                <div class="mb-4">
                                    <img src="{{ $url }}" class="img-fluid rounded border" style="max-height: 350px;">
                                </div>
                                <a href="{{ $url }}" target="_blank" class="btn btn-primary btn-sm">
                                    {{ __('menu.view_full_image') }}
                                </a>

                                {{-- عرض ملفات PDF --}}
                            @elseif($ext === 'pdf')
                                <div class="mb-4">
                                    <iframe src="{{ $url }}" width="100%" height="450px" class="rounded border"></iframe>
                                </div>
                                <a href="{{ $url }}" target="_blank" class="btn btn-primary btn-sm">
                                    {{ __('menu.open_pdf') }}
                                </a>

                            @else
                                <div class="alert alert-warning">
                                    {{ __('menu.unsupported_file') }}: <strong>{{ $ext }}</strong>
                                </div>
                            @endif
                        @else
                            <p class="text-muted">{{ __('menu.no_attachments') }}</p>
                        @endif
                    </div>
                </div>
            </div>


            <div class="w-100 w-lg-350px">
                <div class="card card-flush shadow-sm">
                    <div class="card-header pt-5 d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <h2 class="d-flex align-items-center">
                                {{ __('menu.reports_count') }}
                                <span class="text-gray-600 fs-6 {{ app()->getLocale() == 'ar' ? 'me-2' : 'ms-2' }}">
                                    ({{ $property->report ? 1 : 0 }})
                                </span>
                            </h2>
                        </div>

                        @if($property->report)
                            <a href="{{ route('user-management.reports.show', $property->report->id) }}"
                               class="btn btn-sm btn-primary">
                                {{ __('menu.view_report') }}
                            </a>
                        @else
                            <a href="{{ route('user-management.reports.index') }}"
                               class="btn btn-sm btn-success">
                                {{ __('menu.add_report') }}
                            </a>
                        @endif
                    </div>

                    <div class="card-body pt-0">
                        @if($property->report)
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle gs-2">
                                    <thead class="bg-light">
                                    <tr>
                                        <th class="fw-bold">{{ __('menu.report_id') }}</th>
                                        <th class="fw-bold">{{ __('menu.status') }}</th>
                                        <th class="fw-bold">{{ __('menu.created_at') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>#{{ $property->report->id }}</td>
                                        <td>
                                            <span class="badge badge-light-primary">
                                                {{ __('menu.' . $property->report->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $report->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">{{ __('menu.no_reports_found') }}</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-default-layout>
