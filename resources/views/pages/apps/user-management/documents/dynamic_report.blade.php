<!DOCTYPE html >
<html lang="ar" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $report_title }}</title>
    <style>
        /* CSS مُضمن بسيط للطباعة */
        body {
            /* التعديل الحاسم: وضع الخطوط العربية المتوافقة مع Dompdf (مثل Amiri أو Tahoma) كأولوية */
            font-family: 'cairo', sans-serif;
            font-size: 10px;
            direction: rtl; /* دعم اللغة العربية */
            text-align: right;
            line-height: 1.5;
        }
        h1 {
            text-align: center;
            color: #1a4a75; /* لون أزرق داكن */
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            font-size: 20px;
            font-weight: bold;

        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: right; }
        th { background-color: #f7f7f7; color: #333; font-weight: bold; }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
        .section-title { font-size: 14px; margin-top: 20px; margin-bottom: 10px; color: #333; font-weight: bold; }
    </style>
</head>
<body>

<div style="text-align: center; margin-bottom: 10px;">
    <img src="{{ image('logos/damage_icon.png') }}" alt="Logo" style="height: 60px;">
</div>

<h1>{{ $report_title }}</h1>

<div style="margin-bottom: 20px;">
    <p><strong>تاريخ الإصدار:</strong> {{ now()->format('Y-m-d H:i') }}</p>
</div>

@switch($report_type)
    @case('properties_list')
        @include('pages.apps.user-management.documents.pdf.partials._properties_list', ['properties' => $report_data])
        @break

    @case('damages_list')
        @include('pages.apps.user-management.documents.pdf.partials._damages_list', ['reports' => $report_data])
        @break

    @case('damage_severity')
        @include('pages.apps.user-management.documents.pdf.partials._damage_severity', ['severity' => $report_data])
        @break

    @case('area_density')
        @include('pages.apps.user-management.documents.pdf.partials._area_density', ['areas' => $report_data])
        @break

    @case('timeline')
        @include('pages.apps.user-management.documents.pdf.partials._timeline', ['timeline' => $report_data])
        @break

    @case('no_reports')
        @include('pages.apps.user-management.documents.pdf.partials._no_reports', ['properties' => $report_data])
        @break

    @case('single_property')
        @include('pages.apps.user-management.documents.pdf.partials._single_property', ['property' => $report_data])
        @break


    @case('general_analytics')
        @include('pages.apps.user-management.documents.pdf.partials._general_analytics', ['data' => $report_data])
        @break

    @default
        <p style="color: red; text-align: center;">خطأ: لم يتم تعريف نوع التقرير.</p>
@endswitch

<div class="footer">
    هذا التقرير تم إنشاؤه آلياً من نظام إدارة الوثائق والأضرار.
</div>
</body>
</html>
