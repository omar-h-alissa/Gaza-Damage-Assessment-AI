<div class="card card-flush h-xl-100">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-boldest fs-3 mb-1 text-gray-800">{{ __('menu.damage_analysis_title') }}</span>
            <span class="text-muted mt-1 fw-semibold fs-7">
                {{ __('menu.analysis_description', ['count' => $stats['completed']]) }}
            </span>
        </h3>
    </div>
    <div class="card-body pt-0 ps-5 pe-5">
        <div id="kt_chart_damage_distribution" class="mt-10" style="height: 350px"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const element = document.getElementById('kt_chart_damage_distribution');
        if (!element) return;

        // تجهيز النصوص المترجمة من لارافيل لاستخدامها في الشارت
        const labelsLocale = {
            partial: "{{ __('menu.partial_damage') }}",
            major: "{{ __('menu.major_partial_damage') }}",
            total: "{{ __('menu.total_damage') }}",
            total_label: "{{ __('menu.total_reports_count') }}"
        };

        const rawData = [
            { label: labelsLocale.partial, value: {{ $damageDistribution['partial'] }}, color: '#3B82F6' },
            { label: labelsLocale.major, value: {{ $damageDistribution['severe_partial'] }}, color: '#F59E0B' },
            { label: labelsLocale.total, value: {{ $damageDistribution['total'] }}, color: '#EF4444' }
        ];

        const series = rawData.map(i => i.value);
        const labels = rawData.map(i => i.label);
        const colors = rawData.map(i => i.color);

        const options = {
            series: series,
            labels: labels,
            chart: {
                type: 'donut',
                height: 360,
                // أضفنا خط Cairo هنا ليتناسب مع باقي الموقع
                fontFamily: 'Cairo, Inter, sans-serif',
                toolbar: { show: false },
                animations: { enabled: true, easing: 'easeout', speed: 650 }
            },
            colors: colors,
            stroke: { width: 1.5, colors: ['#ffffff'] },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        labels: {
                            show: true,
                            name: { show: true, fontSize: '14px', fontWeight: 500, color: '#6B7280', offsetY: -5 },
                            value: {
                                show: true,
                                fontSize: '28px',
                                fontWeight: 800,
                                color: '#111827',
                                offsetY: 10,
                                formatter: function(val) { return val; }
                            },
                            total: {
                                show: true,
                                label: labelsLocale.total_label,
                                fontSize: '13px',
                                fontWeight: 700,
                                color: '#374151',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a,b)=>a+b,0).toLocaleString('{{ app()->getLocale() == "ar" ? "ar-EG" : "en-US" }}');
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                fontWeight: 500,
                // لضمان ترتيب العناصر في العربي بشكل صحيح
                direction: "{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
            },
            dataLabels: { enabled: false },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " {{ __('menu.report') }}";
                    }
                }
            }
        };

        const chart = new ApexCharts(element, options);
        chart.render();
    });
</script>
