<x-default-layout>

    @section('title')
        {{ __('menu.dashboard') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <div class="container">

        <!-- Page Title -->
        <div class="d-flex justify-content-between align-items-center mb-10">
            <h1 class="fw-bold">{{ __('menu.user_dashboard') }}</h1>
            <a href="{{ route('user-management.reports.index') }}" class="btn btn-primary btn-lg">
                + {{ __('menu.create_new_report') }}
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="row g-5">
            <div class="col-md-3">
                <div class="card card-bordered shadow-sm">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3">{{ __('menu.stats.total_reports') }}</h4>
                        <div class="fs-1 fw-bolder text-primary">{{ $totalReports }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-bordered shadow-sm">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3">{{ __('menu.stats.pending_review') }}</h4>
                        <div class="fs-1 fw-bolder text-warning">{{ $pendingReports }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-bordered shadow-sm">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3">{{ __('menu.stats.in_progress') }}</h4>
                        <div class="fs-1 fw-bolder text-info">{{ $inProgressReports }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-bordered shadow-sm">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3">{{ __('menu.stats.completed') }}</h4>
                        <div class="fs-1 fw-bolder text-success">{{ $completedReports }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports Table -->
        <div class="card mt-10 shadow-sm card-bordered">
            <div class="card-header">
                <h3 class="card-title fw-bold">{{ __('menu.recent_reports') }}</h3>
            </div>
            <div class="card-body">
                @if($reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-row-bordered align-middle">
                            <thead>
                            <tr class="fw-bold text-muted">
                                <th>{{ __('menu.table.id') }}</th>
                                <th>{{ __('menu.table.type') }}</th>
                                <th>{{ __('menu.table.date') }}</th>
                                <th>{{ __('menu.table.status') }}</th>
                                <th>{{ __('menu.table.ai_percentage') }}</th>
                                <th>{{ __('menu.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td>#{{ $report->id }}</td>
                                    <td>  {{ $report->damage_type_data }}</td>
                                    <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if($report->status == 'pending')
                                            <span class="badge badge-light-warning">{{ __('menu.pending') }}</span>
                                        @elseif($report->status == 'rejected')
                                            <span class="badge badge-light-danger">{{ __('menu.rejected') }}</span>
                                        @elseif($report->status == 'approved')
                                            <span class="badge badge-light-success">{{ __('menu.approved') }}</span>
                                        @else
                                            <span class="badge badge-light-primary">{{ __('dashboard.' . $report->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->ai_analysis_data['percentage'] ?? '—' }}%</td>
                                    <td>
                                        <a href="{{ route('user-management.reports.show', $report->id) }}" class="btn btn-sm btn-light-primary">
                                            {{ __('menu.table.view') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        {{ __('menu.no_reports') }}
                    </div>
                @endif
            </div>
        </div>


        <!-- Activity Timeline -->
        <div class="card mt-10 card-bordered shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">{{ __('menu.activity_timeline') }}</h3>
            </div>
            <div class="card-body">
                <div class="scroll-y pe-3" style="max-height: 300px">
                    @if($activities->count() > 0)
                        <div class="timeline timeline-border-dashed">
                            @foreach($activities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-line"></div>
                                    <div class="timeline-icon">
                                        <i class="bi {{ $activity->icon }} fs-3 text-{{ $activity->type }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <span class="fw-bold">{{ $activity->title }}</span>
                                        <span class="text-muted small mx-2">{{ $activity->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            {{ __('menu.no_activities') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-default-layout>
