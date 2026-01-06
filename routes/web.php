<?php

use App\Events\ReportAiFinished;
use App\Http\Controllers\Apps\DocumentManagementController;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\PropertyManagementController;
use App\Http\Controllers\Apps\ReportManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::middleware(['auth', 'verified'])->group(function () {


    /* ----------------------------------------------
  | Redirect root based on role
  ---------------------------------------------- */
    Route::get('/', function () {
        $user = Auth::user();

        if ($user->hasRole('user')) {
            return redirect()->route('dashboard.user');
        }

        return redirect()->route('dashboard.admin');
    })->name('dashboard');;

    /* ----------------------------------------------
     | User Dashboard
     ---------------------------------------------- */
    Route::get('/dashboard/user', [DashboardController::class, 'index_user'])
        ->name('dashboard.user')
        ->middleware('permission:dashboard.view');

    /* ----------------------------------------------
     | Admin Dashboard
     ---------------------------------------------- */
    Route::get('/dashboard/admin', [DashboardController::class, 'index_admin'])
        ->name('dashboard.admin')
        ->middleware('permission:dashboard.admin');


    /* ==============================================
     | START USER ROUTES
     ============================================== */
    Route::resource('/user-management/users', UserManagementController::class)
        ->names([
            'index'   => 'user-management.users.index',
            'show'    => 'user-management.users.show',
            'create'  => 'user-management.users.create',
            'store'   => 'user-management.users.store',
            'edit'    => 'user-management.users.edit',
            'update'  => 'user-management.users.update',
            'destroy' => 'user-management.users.destroy',
        ])
        ->middleware([
            'permission:user.view|user.create|user.edit|user.delete'
        ]);

    Route::post('/user-management/users/update-password', [UserManagementController::class, 'updatePassword'])->name('user.update_password');

    /* ==============================================
     | END USER ROUTES
     ============================================== */


    /* ----------------------------------------------
     | Roles Management
     ---------------------------------------------- */
    Route::resource('/user-management/roles', RoleManagementController::class)
        ->names([
            'index'   => 'user-management.roles.index',
            'show'    => 'user-management.roles.show',
            'create'  => 'user-management.roles.create',
            'store'   => 'user-management.roles.store',
            'edit'    => 'user-management.roles.edit',
            'update'  => 'user-management.roles.update',
            'destroy' => 'user-management.roles.destroy',
        ])
        ->middleware('permission:user.assign_role');


    /* ----------------------------------------------
     | Permissions Management
     ---------------------------------------------- */
    Route::resource('/user-management/permissions', PermissionManagementController::class)
        ->names([
            'index'   => 'user-management.permissions.index',
            'show'    => 'user-management.permissions.show',
            'create'  => 'user-management.permissions.create',
            'store'   => 'user-management.permissions.store',
            'edit'    => 'user-management.permissions.edit',
            'update'  => 'user-management.permissions.update',
            'destroy' => 'user-management.permissions.destroy',
        ])
        ->middleware('permission:manage roles');


    /* ----------------------------------------------
     | Properties Management
     ---------------------------------------------- */
    Route::get('/user-management/properties/map', [PropertyManagementController::class, 'userMap'])
        ->name('user-management.properties.map')
        ->middleware('permission:property.view');

    Route::resource('/user-management/properties', PropertyManagementController::class)
        ->names([
            'index'   => 'user-management.properties.index',
            'show'    => 'user-management.properties.show',
            'create'  => 'user-management.properties.create',
            'store'   => 'user-management.properties.store',
            'edit'    => 'user-management.properties.edit',
            'update'  => 'user-management.properties.update',
            'destroy' => 'user-management.properties.destroy',
        ])
        ->middleware('permission:property.view|property.create|property.edit|property.delete');


    /* ----------------------------------------------
     | Reports Management
     ---------------------------------------------- */

    Route::get('/user-management/reports/map', [ReportManagementController::class, 'reportMap'])
        ->name('user-management.reports.map')
        ->middleware('permission:dashboard.admin|user.view');


    Route::resource('/user-management/reports', ReportManagementController::class)
        ->names([
            'index'   => 'user-management.reports.index',
            'show'    => 'user-management.reports.show',
            'create'  => 'user-management.reports.create',
            'store'   => 'user-management.reports.store',
            'edit'    => 'user-management.reports.edit',
            'update'  => 'user-management.reports.update',
            'destroy' => 'user-management.reports.destroy',
        ])
        ->middleware('permission:report.view|report.create|report.edit|report.delete');

    // Approve report
    Route::post('/user-management/reports/{report}/approve', [ReportManagementController::class, 'approve'])
        ->name('user-management.reports.approve')
        ->middleware('permission:report.approve');

    // Assign report to property
    Route::post('/user-management/reports/{report}/assign', [ReportManagementController::class, 'assignToProperty'])
        ->name('user-management.reports.assign')
        ->middleware('permission:report.assign_to_property');


    // صفحة شاشة التقارير
    Route::get('/user-management/documents', [DocumentManagementController::class, 'index'])->name('user-management.documents.index');

// تحميل كل تقرير
    Route::get('/user-management/documents/properties-by-damage', [DocumentManagementController::class, 'propertiesPdf'])->name('user-management.documents.properties_by_damage');
    Route::get('/user-management/documents/damagesPdf', [DocumentManagementController::class, 'damagesPdf'])->name('user-management.documents.damagesPdf');
    Route::get('/user-management/documents/severityPdf', [DocumentManagementController::class, 'severityPdf'])->name('user-management.documents.severityPdf');
    Route::get('/user-management/documents/areasPdf', [DocumentManagementController::class, 'areasPdf'])->name('user-management.documents.areasPdf');
    Route::get('/user-management/documents/reports-by-date', [DocumentManagementController::class, 'reportsByDate'])->name('user-management.documents.reports_by_date');
    Route::get('/user-management/documents/noReportsPdf', [DocumentManagementController::class, 'noReportsPdf'])->name('user-management.documents.noReportsPdf');
    Route::post('/user-management/documents/property-full-details', [DocumentManagementController::class, 'propertyFullDetails'])->name('user-management.documents.property_full_details');
    Route::get('/user-management/documents/analyticsPdf', [DocumentManagementController::class, 'analyticsPdf'])->name('user-management.documents.analyticsPdf');

});


/*
|--------------------------------------------------------------------------
| Error & Auth
|--------------------------------------------------------------------------
*/

Route::get('/error', function () {
    abort(500);
});


Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
