<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('user', function (User $user) {
                return view('pages.apps.user-management.users.columns._user', compact('user'));
            })
            ->editColumn('role', function (User $user) {
                return ucwords($user->roles->first()?->name);
            })
            ->editColumn('created_at', function (User $user) {
                // استخدام l_format لضمان ظهور التاريخ باللغة المختارة (منذ، في، إلخ)
                return $user->created_at->translatedFormat('d M Y, h:i a');
            })
            ->addColumn('action', function (User $user) {
                return view('pages.apps.user-management.users.columns._actions', compact('user'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(2)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages//apps/user-management/users/columns/_draw-scripts.js')) . "}")
            // --- إضافة ترجمة نصوص الجدول (بحث، عدد الصفوف، إلخ) ---
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
            // استخدام __() لتعريب رؤوس الأعمدة تلقائياً
            Column::make('user')->title(__('menu.user'))->addClass('d-flex align-items-center')->name('name'),
            Column::make('role')->title(__('menu.role'))->searchable(false),
            Column::make('created_at')->title(__('menu.joined_date'))->addClass('text-nowrap'),
            Column::computed('action')
                ->title(__('menu.actions')) // تعريب رأس عمود الإجراءات
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
