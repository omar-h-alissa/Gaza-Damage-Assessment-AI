{{-- =========================
    1️⃣ الملخص العام
========================= --}}
<div class="section-title">الملخص العام</div>

<table class="table summary-table">
    <tr>
        <th>إجمالي العقارات</th>
        <td>{{ $data['summary']['totalProperties'] }}</td>
    </tr>
    <tr>
        <th>إجمالي البلاغات</th>
        <td>{{ $data['summary']['totalReports'] }}</td>
    </tr>
    <tr>
        <th>العقارات التي تحتوي بلاغات</th>
        <td>{{ $data['summary']['propertiesWithReports'] }}</td>
    </tr>
    <tr>
        <th>متوسط البلاغات لكل عقار</th>
        <td>{{ $data['summary']['avgReportsPerProperty'] }}</td>
    </tr>
</table>

{{-- =========================
    2️⃣ توزيع أنواع الأضرار
========================= --}}
<div class="section-title">توزيع أنواع الأضرار</div>

<table class="table">
    <thead>
    <tr>
        <th>نوع الضرر</th>
        <th>عدد البلاغات</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['severity'] as $row)
        <tr>
            @php
                // التصحيح الحاسم: استخدام damage_type بدلاً من severity
                $damageType = $row->damage_type;

                $arabicDamageType = match ($damageType) {
                    'partial' => 'جزئي',
                    'total' => 'كلي',
                    'severe_partial' => 'جزئي شديد',
                    default => 'غير محدد',
                };
            @endphp
            <td>{{ $arabicDamageType }}</td>
            <td>{{ $row->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- =========================
    3️⃣ المناطق الأكثر تضررًا
========================= --}}
<div class="section-title">تحليل الأضرار حسب المناطق</div>

<table class="table">
    <thead>
    <tr>
        <th>المنطقة</th>
        <th>عدد العقارات</th>
        <th>عدد البلاغات</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['areas'] as $area)
        <tr>
            <td>{{ $area['area_name'] }}</td>
            <td>{{ $area['properties_count'] }}</td>
            <td>{{ $area['reports_count'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


<div class="section-title">التتبع الزمني للبلاغات</div>

<table class="table">
    <thead>
    <tr>
        <th>التاريخ</th>
        <th>عدد البلاغات</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['timeline'] as $row)
        <tr>
            <td>{{ $row->date }}</td>
            <td>{{ $row->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- =========================
    6️⃣ حالة البلاغات
========================= --}}
<div class="section-title">حالة البلاغات</div>

<table class="table">
    <thead>
    <tr>
        <th>الحالة</th>
        <th>العدد</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['status'] as $row)
        <tr>
            <td>  @if($row->status == 'approved')
                    {{ __('menu.approved') }}
                @elseif($row->status == 'rejected')
                    {{ __('menu.rejected') }}
                @else
                    {{ $row->status }}
                    {{ __('menu.pending') }}
                @endif</td>
            <td>{{ $row->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
