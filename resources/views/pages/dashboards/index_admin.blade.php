<x-default-layout>

    @section('title')
        {{ __('menu.dashboard') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!--=============================================-->
    <!-- 1. الصف الأول: 4 بطاقات (3 وحدات لكل بطاقة) -->
    <!--=============================================-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">

        <!-- البطاقة 4 (25%) -->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" style="height: fit-content">
            @include('partials/widgets/lists/_widget-26')
        </div>

        <!-- البطاقة 1 (25% من العرض على XXL) -->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" style="height: fit-content">
            @include('partials/widgets/cards/_widget-20')
        </div>

        <!-- البطاقة 2 (25%) -->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" style="height: fit-content">
            @include('partials/widgets/cards/_widget-7')
        </div>

        <!-- البطاقة 3 (25%) -->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" style="height: fit-content">
            @include('partials/widgets/cards/_widget-17')
        </div>



    </div>
    <!--end::Row (الصف الأول)-->

    <!--========================================================-->
    <!-- 2. الصف الثاني: بطاقتان كبيرتان (6 وحدات لكل بطاقة) -->
    <!--========================================================-->

    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">

        <!-- البطاقة 10 (66%) -->
        <div class="col-xl">
            @include('partials/widgets/tables/_widget-14')
        </div>

    </div>


    <!--end::Row (الصف الثاني)-->

    <!--===================================================================================-->
    <!-- 4. الصف الرابع: بطاقة صغيرة (4 وحدات) وبطاقة كبيرة (8 وحدات) -->
    <!--===================================================================================-->
    <div class="row gx-5 gx-xl-10 mb-5 mb-xl-10">

        <!-- البطاقة 5 (50%) -->
        <div class="col-xxl-6 mb-5 mb-xl-10">
            @include('partials/widgets/charts/_widget-8')
        </div>

        <!-- البطاقة 6 (50%) -->
        <div class="col-xl-6 mb-5 mb-xl-10">
            @include('partials/widgets/tables/_widget-16')
        </div>

    </div>


        <div class="row gx-5 gx-xl-10 mb-5 mb-xl-10">
            <!-- أول بطاقة -->
            <div class="col-12 col-xl-6">
                <div class="card mt-10 card-bordered shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title fw-bold">{{ __('menu.most_damaged_areas') }}</h3>
                    </div>

                    <div class="card-body">
                        <div id="damage_areas_chart" style="height: 350px"></div>
                    </div>
                </div>
            </div>

            <!-- ثاني بطاقة -->


            <div class="col-12 col-xl-6">
                <div class="card mt-10 card-bordered shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title fw-bold">{{ __('menu.notifications') }}</h3>
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
                                                <span class="text-muted small">{{ $activity->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    {{ __('menu.no_notifications_yet') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--end::Row (الصف الرابع)-->

        <style>
            /* تنسيقات مخصصة للنمط المظلم */
            .card-title .text-white { color: #ffffff !important; }
            .text-muted { color: #a0a0a0 !important; }

            .apexcharts-canvas {
                margin: 0 auto;
            }
            .apexcharts-tooltip {
                direction: rtl !important;
                text-align: right !important;
                white-space: nowrap !important;
            }
            /* جعل التول تيب داكن ليتناسب مع الخلفية */
            .apexcharts-tooltip.apexcharts-theme-light {
                background: rgba(17, 17, 17, 0.9) !important;
                border: 1px solid #333 !important;
                color: #fff !important;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const topAreasData = @json($top5DamagedAreas);
                const isRtl = "{{ app()->getLocale() == 'ar' }}" === "1" || "{{ app()->getLocale() == 'ar' }}" === "true";

                if (!topAreasData || topAreasData.length === 0) return;

                const labels = topAreasData.map(a => a.area_name);
                const values = topAreasData.map(a => a.avg_damage);

                const element = document.getElementById('damage_areas_chart');
                if (!element) return;

                const options = {
                    series: [{
                        name: "{{ __('menu.damage_percentage') }}",
                        data: values
                    }],

                    chart: {
                        type: "bar",
                        height: 380,
                        toolbar: { show: false },
                        fontFamily: isRtl ? 'Cairo, sans-serif' : 'Inter, sans-serif',
                        foreColor: '#ffffff', // هذا يجعل جميع نصوص الشارت بيضاء
                        sparkline: { enabled: false },
                        parentHeightOffset: 0,
                    },

                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            columnWidth: "40%", // جعل العمود أنحف قليلاً ليعطي شكلاً أرشق
                            distributed: false,
                        }
                    },

                    // الألوان الزرقاء التي أعجبتك مع التدرج
                    colors: ["#3572d4"],
                    // fill: {
                    //     type: "gradient",
                    //     gradient: {
                    //         shade: "dark",
                    //         type: "vertical",
                    //         shadeIntensity: 0.5,
                    //         inverseColors: true,
                    //         opacityFrom: 1,
                    //         opacityTo: 0.8,
                    //         stops: [0, 100]
                    //     }
                    // },

                    dataLabels: {
                        enabled: true,
                        offsetY: -25,
                        style: {
                            fontSize: "12px",
                            fontWeight: "700",
                            colors: ["#ffffff"] // أرقام النسب فوق الأعمدة باللون الأبيض
                        },
                        formatter: (val) => val.toFixed(1) + "%"
                    },

                    xaxis: {
                        categories: labels,
                        position: 'bottom',
                        reversed: isRtl,
                        labels: {
                            show: true,
                            style: {
                                colors: '#5c5b5b', // لون أسماء المناطق رمادي فاتح
                                fontSize: "12px",
                                fontWeight: "600",
                            },
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },

                    yaxis: {
                        max: 100,
                        opposite: isRtl,
                        labels: {
                            style: {
                                colors: '#a0a0a0',
                                fontSize: "12px"
                            },
                            formatter: (val) => val + "%"
                        }
                    },

                    tooltip: {
                        theme: "dark", // تغيير الثيم لداكن
                        enabled: true,
                        x: { show: true },
                        y: {
                            formatter: (val) => `${val.toFixed(1)}%`
                        },
                        style: { fontSize: "14px" }
                    },

                    grid: {
                        borderColor: "#222222", // لون الخطوط الخلفية داكن جداً
                        strokeDashArray: 4,
                        padding: {
                            left: isRtl ? 20 : 0,
                            right: isRtl ? 0 : 20,
                            bottom: 20
                        }
                    }
                };

                new ApexCharts(element, options).render();
            });
        </script>



</x-default-layout>
