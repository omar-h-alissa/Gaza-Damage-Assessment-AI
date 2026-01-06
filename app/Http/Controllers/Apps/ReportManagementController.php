<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersAssignedRoleDataTable;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ReportManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.apps.user-management.reports.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {


        return view('pages.apps.user-management.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }

    public function reportMap()
    {
        $user = Auth::user();

        $properties = Property::query()
            /** * استخدام منطق التحقق اليدوي لتجنب مشاكل المكتبات الخارجية
             * نفترض أن لديك حقل 'role' في جدول المستخدمين أو دالة لفحص الدور
             */
            ->when(!($user->role === 'admin' || $user->role === 'super_admin'), function ($query) use ($user) {
                // إذا لم يكن المستخدم أدمن أو سوبر أدمن، نفلتر النتائج لتظهر سجلاته فقط
                return $query->where('user_id', $user->id);
            })
            ->whereHas('latestReport', function($query) {
                $query->where('status', 'approved');
            })
            ->with(['latestReport' => function($query) {
                $query->where('status', 'approved');
            }])
            ->get()
            ->map(function($p) {
                return [
                    'id' => $p->id,
                    'lat' => $p->latitude,
                    'lng' => $p->longitude,
                    'damage_percentage' => $p->latestReport?->ai_analysis_data['percentage'] ?? 0,
                    'damage_state' => $p->latestReport?->ai_analysis_data['state'] ?? 'unknown',
                ];
            });

        return view('pages.apps.user-management.reports.reports-map', compact('properties'));
    }
}
