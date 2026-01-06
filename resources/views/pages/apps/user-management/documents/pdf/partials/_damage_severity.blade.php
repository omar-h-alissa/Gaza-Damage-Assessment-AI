<table class="table">
    <thead>
    <tr>
        <th>شدة الضرر (Severity)</th>
        <th>العدد الكلي للبلاغات</th>
    </tr>
    </thead>
    <tbody>
    {{-- المتغير $severity هنا هو $report_data الممرر من generatePdf --}}
    @foreach($severity as $item)
        <tr>
            <td>
                @php
                    // التصحيح الحاسم: استخدام damage_type بدلاً من severity
                    $damageType = $item->damage_type;

                    $arabicDamageType = match ($damageType) {
                        'partial' => 'جزئي',
                        'total' => 'كلي',
                        'severe_partial' => 'جزئي شديد',
                        default => 'غير محدد',
                    };
                @endphp
                {{ $arabicDamageType }}
            </td>
            <td>{{ $item->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
