<x-default-layout>

    @section('title')
        {{ __('menu.report_details') }}
    @endsection

        <livewire:user.report-details :id="$report->id" />

</x-default-layout>
