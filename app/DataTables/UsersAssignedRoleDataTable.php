<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersAssignedRoleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['user'])
            ->editColumn('user', function (User $user) {
                return view('pages.apps.user-management.roles.columns._user', compact('user'));
            })
            ->editColumn('created_at', function (User $user) {
                // تعريب التنسيق الزمني
                return $user->created_at->translatedFormat('d M Y, h:i a');
            })
            ->addColumn('action', function (User $user) {
                return view('pages.apps.user-management.roles.columns._actions', compact('user'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->whereHas('roles', function (Builder $query) {
            $query->where('role_id', $this->role->getKey());
        });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('usersassingedrole-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages//apps/user-management/users/columns/_draw-scripts.js')) . "}")
            // إضافة دعم اللغة العربية في واجهة الجدول
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
            Column::make('id')->title('#'),
            Column::make('user')->title(__('menu.user'))->addClass('d-flex align-items-center')->name('name'),
            // حقل name غالباً يعرض الاسم، سأعطيه عنوان الاسم
            Column::make('name')->title(__('menu.full_name')),
            Column::make('created_at')->title(__('menu.joined_date'))->addClass('text-nowrap'),
            Column::computed('action')
                ->title(__('menu.actions'))
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UsersAssingedRole_' . date('YmdHis');
    }
}
