<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Property;
use App\Models\Report;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
class DashboardController extends Controller
{


    public function index_user(): View
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        // جلب كل التقارير الخاصة بالمستخدم الحالي
        $reports = Report::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // حساب إحصائيات للـ Stats Cards
        $totalReports = $reports->count();
        $pendingReports = $reports->where('status', 'pending')->count();
        $inProgressReports = $reports->where('status', 'in_progress')->count();
        $completedReports = $reports->where('status', 'approved')->count();
        $activities = Activity::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5) // آخر 5 أنشطة
            ->get();

        return view('pages.dashboards.index_user', compact('reports',
            'reports',
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'completedReports',
            'activities'));
    }

    public function index_admin(): View
    {
        addVendors(['apexcharts']);

        // 0) الإحصائيات الأساسية
        $stats = [
            'users' => User::count(),
            'reports' => Report::count(),
            'properties' => Property::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'in_progress' => Report::where('status', 'in_progress')->count(),
            'completed' => Report::where('status', 'approved')->count(),
        ];

        $latestReports = Report::with('user')->orderBy('id', 'asc')->limit(10)->get();
        $activities = Activity::orderBy('id', 'desc')->limit(20)->get();

        // 1) نمو المستخدمين
        $usersGrowthMonths = [];
        $usersGrowth = [];
        $start = now()->subMonths(5);

        for ($i = 0; $i < 6; $i++) {
            $month = $start->copy()->addMonths($i);
            $usersGrowthMonths[] = $month->format('M');
            $usersGrowth[] = User::whereMonth('created_at', $month->format('m'))->count();
        }

        // 2) إحصائيات العقارات والمناطق (الجزء المعدل للغتين)
        $propertyStats = [
            'total_properties' => Property::count(),
            'properties_with_reports' => Property::has('report')->count(),
            'properties_without_reports' => Property::doesntHave('report')->count(),
        ];

        $areas = config('areas');

        $reports = Report::select('reports.id', 'reports.ai_analysis', 'properties.latitude', 'properties.longitude')
            ->join('properties', 'properties.id', '=', 'reports.property_id')
            ->whereNotNull('reports.ai_analysis')
            ->whereNotNull('properties.latitude')
            ->get();

        // تجميع التقارير وحساب متوسط الضرر لكل منطقة باستخدام "المفتاح" (Name)
        $areaReports = $reports->map(function ($report) use ($areas) {
            $reportLatitude = (float) $report->latitude;
            $reportLongitude = (float) $report->longitude;
            $damagePercentage = (float) data_get(json_decode($report->ai_analysis, true), 'percentage');

            $areaKey = null; // نستخدم مفتاح المنطقة البرمجي (slug)
            foreach ($areas as $area) {
                if (
                    $reportLatitude >= $area['lat_min'] &&
                    $reportLatitude <= $area['lat_max'] &&
                    $reportLongitude >= $area['lng_min'] &&
                    $reportLongitude <= $area['lng_max']
                ) {
                    $areaKey = $area['name']; // مثلاً: 'rafah_governorate'
                    break;
                }
            }

            return [
                'area_key' => $areaKey,
                'damage' => $damagePercentage,
            ];
        })
            ->filter(fn ($item) => $item['area_key'] !== null)
            ->groupBy('area_key');

        // تحويل البيانات لإحصائيات جاهزة للعرض مع الترجمة
        $areaStats = $areaReports->map(function ($reportsInArea, $areaKey) {
            return [
                'area_key'   => $areaKey,
                // نترجم الاسم هنا ليتم استخدامه في المصفوفات النهائية
                'area_name'  => __('areas.' . $areaKey),
                'avg_damage' => round($reportsInArea->avg('damage'), 1),
                'reports_count' => $reportsInArea->count(),
            ];
        })
            ->sortByDesc('avg_damage');

        // أ. المنطقة الأكثر تضرراً
        $topDamagedArea = $areaStats->first() ?: [
            'area_name' => __('areas.unknown'), // تأكد من إضافة 'unknown' في ملف اللغة
            'avg_damage' => 0,
            'reports_count' => 0,
        ];

        // ب. أعلى 5 مناطق للرسم البياني (سيكون الاسم مترجماً جاهزاً للـ ApexCharts)
        $top5DamagedAreas = $areaStats->take(5)->values()->all();

        // 3) أنواع البلاغات
        $reportTypes = Report::select('damage_type')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('damage_type')
            ->pluck('total', 'damage_type');

        // 4) نمو البلاغات
        $reportsGrowthMonths = [];
        $reportsGrowth = [];
        for ($i = 0; $i < 6; $i++) {
            $month = $start->copy()->addMonths($i);
            $reportsGrowthMonths[] = $month->format('M');
            $reportsGrowth[] = Report::whereMonth('created_at', $month->format('m'))->count();
        }

        // 5) توزيع الضرر
        $damageTypes = ['partial', 'severe_partial', 'total'];
        $damageDistribution = Report::select('damage_type')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('damage_type')
            ->pluck('total', 'damage_type')
            ->toArray();

        foreach ($damageTypes as $type) {
            if (!isset($damageDistribution[$type])) {
                $damageDistribution[$type] = 0;
            }
        }

        $averageDamageIndex = Report::whereNotNull('ai_analysis')
            ->whereRaw('JSON_VALID(ai_analysis)')
            ->select(DB::raw('AVG(CAST(JSON_EXTRACT(ai_analysis, "$.percentage") AS DECIMAL(5,2))) as avg_damage'))
            ->value('avg_damage');

        $averageDamageIndex = round((float) $averageDamageIndex, 1);

        return view('pages.dashboards.index_admin', compact(
            'stats', 'latestReports', 'activities', 'usersGrowth', 'usersGrowthMonths',
            'propertyStats', 'reportTypes', 'reportsGrowth', 'reportsGrowthMonths',
            'topDamagedArea', 'damageTypes', 'top5DamagedAreas', 'damageDistribution', 'averageDamageIndex'
        ));
    }


}
