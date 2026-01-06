<table class="table">
    <thead>
    <tr>
        <th>اسم المنطقة</th>
        <th>إجمالي العقارات في المنطقة</th>
        <th>إجمالي البلاغات في المنطقة</th>
        <th>متوسط البلاغات لكل عقار</th>
    </tr>
    </thead>
    <tbody>
    {{-- المتغير $areas هنا هو $report_data الممرر من generatePdf --}}
    @foreach($areas as $area)
        <tr>
            {{-- نستخدم 'name' كما تم تسميته في الاستعلام JSON_EXTRACT --}}
            <td>{{ $area->area_name ?? 'غير محدد' }}</td>
            <td>{{ $area->total_properties }}</td>
            <td>{{ $area->total_reports }}</td>
            <td>
                @if ($area->total_properties > 0)
                    {{-- حساب النسبة: إجمالي البلاغات / إجمالي العقارات --}}
                    {{ number_format($area->total_reports / $area->total_properties, 2) }}
                @else
                    0.00
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
