<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersAssignedRoleDataTable;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// تم إضافة DB لاستخدامه في بعض الاستعلامات
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Spatie\Permission\Models\Role;

class DocumentManagementController extends Controller
{
    /**
     * اسم ملف الـ View الموحد لجميع تقارير PDF.
     * @var string
     */
    protected $pdfView = 'pages.apps.user-management.documents.dynamic_report';

    private function generatePdf(string $fileName, string $title, string $type, $data)
    {
        $html = view($this->pdfView, [
            'report_data' => $data,
            'report_title' => $title,
            'report_type' => $type,
        ])->render();

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'fontDir' => array_merge($fontDirs, [
                storage_path('fonts'),
            ]),
            'fontdata' => $fontData + [
                    'cairo' => [
                        'R' => 'Cairo-Regular.ttf',
                        'B' => 'Cairo-Bold.ttf',
                        'useOTL' => 0xFF,
                    ],
                ],
            'default_font' => 'cairo',
        ]);

        $mpdf->SetDirectionality('rtl');
        $mpdf->WriteHTML('<html lang="ar" dir="rtl"></html>');
        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output($fileName, 'S'),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function index()
    {
        return view('pages.apps.user-management.documents.index');
    }

    /* --------------------------------------------------------
      1. تقرير العقارات
    -------------------------------------------------------- */
    public function propertiesPdf()
    {
        $properties = Property::with('report')->get();


        return $this->generatePdf(
            'damage_reports.pdf',
            'تقرير قائمة العقارات',
            'properties_list',
            $properties
        );


    }

    /* --------------------------------------------------------
        2. تقرير البلاغات
    -------------------------------------------------------- */
    public function damagesPdf()
    {
        $reports = Report::with('property')->get();

        return $this->generatePdf(
            'damage_reports.pdf',
            'تقرير قائمة البلاغات',
            'damages_list',
            $reports
        );
    }

    /* --------------------------------------------------------
        3. تقرير شدة الأضرار
    -------------------------------------------------------- */
    public function severityPdf()
    {
        $severity = Report::selectRaw('damage_type, COUNT(*) as total')
            ->groupBy('damage_type')
            ->get();

        return $this->generatePdf(
            'damage_severity_report.pdf',
            'تقرير شدة الأضرار',
            'damage_severity',
            $severity
        );
    }


    /* --------------------------------------------------------
        4. تقرير المناطق الأكثر تضررًا
    -------------------------------------------------------- */
    public function areasPdf()
    {
        $caseStatement = "
            CASE
                WHEN latitude BETWEEN 31.2000 AND 31.2800 THEN 'محافظة رفح'
                WHEN latitude BETWEEN 31.2801 AND 31.3600 THEN 'محافظة خان يونس'
                WHEN latitude BETWEEN 31.3601 AND 31.4400 THEN 'محافظة المنطقة الوسطى'
                WHEN latitude BETWEEN 31.4401 AND 31.5450 THEN 'محافظة غزة الكبرى'
                WHEN latitude BETWEEN 31.5451 AND 31.6000 THEN 'محافظة شمال غزة'
                ELSE 'منطقة غير مصنفة'
            END AS area_name
        ";

        $areas = DB::table('properties')
            ->select(DB::raw($caseStatement))
            ->selectRaw('COUNT(*) AS total_properties')
            // حساب إجمالي البلاغات: استعلام فرعي لجمع عدد البلاغات لكل عقار ضمن المجموعة
            ->selectRaw('SUM((SELECT COUNT(*) FROM reports WHERE reports.property_id = properties.id)) AS total_reports')
            ->groupBy('area_name') // التجميع على الاسم المستعار area_name
            ->get();

        return $this->generatePdf(
            'area_damage_density.pdf',
            'تقرير كثافة الأضرار حسب المنطقة',
            'area_density',
            $areas
        );
    }


    /* --------------------------------------------------------
        5. تقرير البلاغات حسب التاريخ (Timeline)
    -------------------------------------------------------- */
    public function reportsByDate()
    {
        $timeline = Report::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->generatePdf(
            'timeline_report.pdf',
            'تقرير التتبع الزمني للبلاغات',
            'timeline',
            $timeline
        );
    }


    /* --------------------------------------------------------
        7. تقرير العقارات غير المقيّمة (بدون بلاغات)
    -------------------------------------------------------- */
    public function noReportsPdf()
    {
        $properties = Property::doesntHave('report')->get();

        return $this->generatePdf(
            'properties_without_reports.pdf',
            'تقرير العقارات غير المُبلّغ عنها',
            'no_reports',
            $properties
        );
    }


    /* --------------------------------------------------------
        8. تقرير عقار مُحدد
    -------------------------------------------------------- */
    public function propertyFullDetails(Request $request)
    {
        $property = Property::with('report')
            ->where('id', $request->property_id)
            ->first();

        if (!$property) {
            return back()->with('error', 'The requested property does not exist');

        }

        return $this->generatePdf('property_' . $property->id . '_report.pdf', 'تقرير مفصل للعقار رقم ' . $property->id, 'single_property', $property);
    }


    public function analyticsPdf()
    {
        // 1️⃣ أرقام عامة
        $totalProperties = Property::count();
        $totalReports = Report::count();
        $areasConfig = config('areas');

        $propertiesWithReports = Property::has('report')->count();
        $avgReportsPerProperty = $totalProperties > 0
            ? round($totalReports / $totalProperties, 2)
            : 0;

        // 2️⃣ شدة الأضرار
        $severityStats = Report::selectRaw('damage_type, COUNT(*) as total')
            ->groupBy('damage_type')
            ->get();

        $areasStats = collect($areasConfig)->map(function ($area) {

            $propertiesCount = Property::whereBetween('latitude', [$area['lat_min'], $area['lat_max']])
                ->whereBetween('longitude', [$area['lng_min'], $area['lng_max']])
                ->count();

            $reportsCount = Report::whereHas('property', function ($q) use ($area) {
                $q->whereBetween('latitude', [$area['lat_min'], $area['lat_max']])
                    ->whereBetween('longitude', [$area['lng_min'], $area['lng_max']]);
            })->count();

            return [
                'area_name' => $area['name'],
                'properties_count' => $propertiesCount,
                'reports_count' => $reportsCount,
            ];
        })
            ->sortByDesc('reports_count')
            ->values();


        // 5️⃣ التحليل الزمني
        $timeline = Report::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 6️⃣ حالة البلاغات (إذا عندك status)
        $statusStats = Report::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // 📦 تجميع كل البيانات
        $data = [
            'summary' => [
                'totalProperties' => $totalProperties,
                'totalReports' => $totalReports,
                'propertiesWithReports' => $propertiesWithReports,
                'avgReportsPerProperty' => $avgReportsPerProperty,
            ],
            'severity' => $severityStats,
            'areas' => $areasStats,
            'timeline' => $timeline,
            'status' => $statusStats,
        ];

        return $this->generatePdf(
            'analytics_report.pdf',
            'التقرير الشامل لتحليل الأضرار',
            'general_analytics',
            $data
        );
    }


}
