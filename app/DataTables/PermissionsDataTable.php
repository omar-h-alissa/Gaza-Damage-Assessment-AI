<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PermissionsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('name', function (Permission $permission) {
                // نتركها كما هي لتظهر أسماء الصلاحيات البرمجية بوضوح
                return ucwords($permission->name);
            })
            ->addColumn('assigned_to', function (Permission $permission) {
                $roles = $permission->roles;
                return view('pages.apps.user-management.permissions.columns._assign-to', compact('roles'));
            })
            ->editColumn('created_at', function (Permission $permission) {
                // تعريب التاريخ تلقائياً
                return $permission->created_at->translatedFormat('d M Y, h:i a');
            })
            ->addColumn('actions', function (Permission $permission) {
                return view('pages.apps.user-management.permissions.columns._actions', compact('permission'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Permission $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('permissions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages//apps/user-management/permissions/columns/_draw-scripts.js')) . "}")
            // جلب ملف اللغة العربية لواجهة الجدول
            ->parameters([
                'language' => [
                    'url' => app()->getLocale() == 'ar' ? '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json' : '',
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title(__('menu.permission_name')),
            Column::make('assigned_to')->title(__('menu.assigned_to')),
            Column::make('created_at')->title(__('menu.joined_date'))->addClass('text-nowrap'),
            Column::computed('actions')
                ->title(__('menu.actions'))
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Permissions_' . date('YmdHis');
    }
}
