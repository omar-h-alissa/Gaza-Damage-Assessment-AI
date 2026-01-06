<div class="menu-state-bg menu-extended overflow-hidden overflow-lg-visible" data-kt-menu-dismiss="true">
    <div class="row">
        <div class="col-lg-8 mb-3 mb-lg-0 py-3 px-3 py-lg-6 px-lg-6">
            <div class="row">

                <div class="col-lg-6 mb-3">
                    <div class="menu-item p-0 m-0">
                        <a href="{{ route('dashboard') }}" class="menu-link active">
                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}">{!! getIcon('element-11', 'text-primary fs-1') !!}</span>
                            <span class="d-flex flex-column">
                         <span class="fs-6 fw-bold text-gray-800">{{ __('menu.default') }}</span>
                         <span class="fs-7 fw-semibold text-muted">{{ __('menu.reports_stats') }}</span>
                      </span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="menu-item p-0 m-0">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}">{!! getIcon('basket', 'text-danger fs-1') !!}</span>
                            <span class="d-flex flex-column">
                         <span class="fs-6 fw-bold text-gray-800">{{ __('menu.ecommerce') }}</span>
                         <span class="fs-7 fw-semibold text-muted">{{ __('menu.sales_reports') }}</span>
                      </span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="menu-item p-0 m-0">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}">{!! getIcon('abstract-44', 'text-info fs-1') !!}</span>
                            <span class="d-flex flex-column">
                         <span class="fs-6 fw-bold text-gray-800">{{ __('menu.projects') }}</span>
                         <span class="fs-7 fw-semibold text-muted">{{ __('menu.tasks_charts') }}</span>
                      </span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="menu-item p-0 m-0">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}">{!! getIcon('abstract-42', 'text-danger fs-1') !!}</span>
                            <span class="d-flex flex-column">
                         <span class="fs-6 fw-bold text-gray-800">{{ __('menu.pos_system') }}</span>
                         <span class="fs-7 fw-semibold text-muted">{{ __('menu.campaigns') }}</span>
                      </span>
                        </a>
                    </div>
                </div>

            </div>

            <div class="separator separator-dashed mx-5 my-5"></div>

            <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-2 mx-5">
                <div class="d-flex flex-column {{ app()->getLocale() == 'ar' ? 'ms-5' : 'me-5' }}">
                    <div class="fs-6 fw-bold text-gray-800">{{ __('menu.landing_template') }}</div>
                    <div class="fs-7 fw-semibold text-muted">{{ __('menu.landing_desc') }}</div>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary fw-bold">{{ __('menu.explore') }}</a>
            </div>
        </div>

        <div class="menu-more bg-light col-lg-4 py-3 px-3 py-lg-6 px-lg-6 rounded-start">
            <h4 class="fs-6 fs-lg-4 text-gray-800 fw-bold mt-3 mb-3 {{ app()->getLocale() == 'ar' ? 'me-4' : 'ms-4' }}">
                {{ __('menu.more_dashboards') }}
            </h4>

            <div class="menu-item p-0 m-0">
                <a href="{{ route('dashboard') }}" class="menu-link py-2">
                    <span class="menu-title">الخدمات اللوجستية</span>
                </a>
            </div>
            <div class="menu-item p-0 m-0">
                <a href="{{ route('dashboard') }}" class="menu-link py-2">
                    <span class="menu-title">تحليلات الموقع</span>
                </a>
            </div>
            <div class="menu-item p-0 m-0">
                <a href="{{ route('dashboard') }}" class="menu-link py-2">
                    <span class="menu-title">الأداء المالي</span>
                </a>
            </div>
            <div class="menu-item p-0 m-0">
                <a href="{{ route('dashboard') }}" class="menu-link py-2">
                    <span class="menu-title">العملات الرقمية</span>
                </a>
            </div>
        </div>
    </div>
</div>
