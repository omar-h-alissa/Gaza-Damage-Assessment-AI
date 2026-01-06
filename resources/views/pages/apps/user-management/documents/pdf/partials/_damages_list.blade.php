<table class="table">
    <thead>
    <tr>
        <th>ID البلاغ</th>
        <th>ID العقار</th>
        <th>اسم مقدم البلاغ</th>
        <th>عنوان العقار</th>
        <th>شدة الضرر(تقييم مقدم البلاغ)</th>
        <th>تحليل الذكاء الاصطناعي(AI Analysis)</th>
        <th>تاريخ البلاغ</th>
    </tr>
    </thead>
    <tbody>
    {{-- المتغير $reports هنا هو $report_data الممرر من generatePdf --}}
    @foreach($reports as $report)
        <tr>
            <td>{{ $report->id }}</td>
            <td>{{ $report->property->id ?? 'N/A' }}</td>
            <td>{{ $report->user->name ?? 'N/A' }}</td>
            <td>{{ $report->property->address ?? 'غير متوفر' }}</td>
            <td>
                @php
                    $damageType = $report->damage_type;
                    $arabicDamageType = match ($damageType) {
                        'partial' => 'جزئي',
                        'total' => 'كلي',
                        'severe_partial' => 'جزئي شديد',
                        default => 'غير محدد',
                    };
                @endphp
                {{ $arabicDamageType }}
            </td>
            <td>

                {{ $report->ai_analysis_data['percentage'] }}% ({{ $report->ai_analysis_data['state'] }})
            </td>
            <td>{{ $report->created_at->format('Y-m-d') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
