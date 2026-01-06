<x-default-layout>

    @section('title')
        {{ __('menu.users') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    {{-- تعريب الـ Placeholder --}}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="{{ __('menu.search_user') }}" id="mySearchInput"/>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        {{ __('menu.add_user') }}
                    </button>
                </div>
                <livewire:user.add-user-modal></livewire:user.add-user-modal>
            </div>
        </div>
        <div class="card-body py-4">
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['users-table'].search(this.value).draw();
            });
            document.addEventListener('livewire:init', function () { // تم تعديل load إلى init لنسخ Livewire الأحدث
                Livewire.on('success', function () {
                    $('#kt_modal_add_user').modal('hide');
                    window.LaravelDataTables['users-table'].ajax.reload();
                });
            });
        </script>
    @endpush

</x-default-layout>
