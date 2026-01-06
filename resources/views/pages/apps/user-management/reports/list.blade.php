<x-default-layout>

    @section('title')
        {{ __('menu.reports') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.reports.index') }}
    @endsection

    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <livewire:user.report-list></livewire:user.report-list>
    </div>
    <!--end::Content container-->

    <!--begin::Modal-->
    <livewire:user.report-modal></livewire:user.report-modal>
    <!--end::Modal-->

</x-default-layout>
