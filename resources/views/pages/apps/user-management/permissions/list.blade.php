<x-default-layout>

    @section('title')
        {{ __('menu.permissions') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.permissions.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier','fs-3 position-absolute ms-5') !!}
                    {{-- تعريب خانة البحث --}}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="{{ __('menu.search_permission') }}" id="mySearchInput"/>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                        {!! getIcon('plus-square','fs-3', '', 'i') !!}
                        {{ __('menu.add_permission') }}
                    </button>
                </div>
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span>
                        {{ __('menu.selected') }}
                    </div>

                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">
                        {{ __('menu.delete_selected') }}
                    </button>
                </div>
                {{-- تنبيه: تأكد إذا كان المودال هنا للمستخدمين أم للصلاحيات --}}
                <livewire:user.add-user-modal></livewire:user.add-user-modal>
            </div>
        </div>
        <div class="card-body py-4">
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    <livewire:permission.permission-modal></livewire:permission.permission-modal>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['permissions-table'].search(this.value).draw();
            });

            // تحديث Livewire v3 يستخدم init بدلاً من load
            document.addEventListener('livewire:init', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_update_permission').modal('hide');
                    window.LaravelDataTables['permissions-table'].ajax.reload();
                });
            });
        </script>
    @endpush

</x-default-layout>
