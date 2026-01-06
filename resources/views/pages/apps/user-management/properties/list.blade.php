<x-default-layout>

    @section('title')
        {{ __('menu.property') }}
    @endsection

    {{--    @section('breadcrumbs')--}}
    {{--        {{ Breadcrumbs::render('user-management.properties.index') }}--}}
    {{--    @endsection--}}

    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <livewire:user.property-list></livewire:user.property-list>
    </div>
    <!--end::Content container-->

    <!--begin::Modal-->
    <livewire:user.property-modal></livewire:user.property-modal>
    <!--end::Modal-->




</x-default-layout>
