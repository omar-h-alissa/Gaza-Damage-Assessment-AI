<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
      direction="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
      style="direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->
<head>
    <base href=""/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <link rel="canonical" href=""/>


    {!! includeFavicon() !!}

    @php
        $isRtl = app()->getLocale() == 'ar';
        $suffix = $isRtl ? '.rtl.css' : '.css';
    @endphp

    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.bundle.rtl.css') }}">
        {{-- إضافة خطوط عربية احترافية في حال كانت اللغة عربية --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font.css') }}">
        <style>
            /* نطبق الخط على كل شيء ما عدا العناصر التي تحتوي على كلاسات الأيقونات المشهورة */
            body, h1, h2, h3, h4, h5, h6, p, a, button, input, select, textarea {
                font-family: 'Cairo', sans-serif !important;
            }

            /* استثناء صريح للأيقونات بناءً على كلاسات Metronic و Bootstrap */
            [class^="ki-"], [class*=" ki-"],
            [class^="bi-"], [class*=" bi-"],
            [class^="fa-"], [class*=" fa-"],
            .fa, .fas, .far, .fab {
                font-family: inherit !important; /* السماح للأيقونة باستخدام خطها الأصلي */
                direction: ltr !important;      /* الأيقونات يجب أن تبقى LTR دائماً لكي لا تنقلب بشكل مشوه */
                display: inline-block !important;
            }
        </style>

    @else
        {!! includeFonts() !!}
    @endif

    <!--begin::Global Stylesheets Bundle(used by all pages)-->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/filepond.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/filepond-plugin-image-preview.css') }}">
    @foreach(getGlobalAssets('css') as $path)
        @php
            $finalPath = $isRtl ? str_replace('.css', '.rtl.css', $path) : $path;
        @endphp
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($finalPath)) !!}
    @endforeach


    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach(getVendors('css') as $path)
        @php
            $fullPath = public_path($path);
            $rtlPath = str_replace('.css', '.rtl.css', $path);
            $finalPath = ($isRtl && file_exists(public_path($rtlPath))) ? $rtlPath : $path;
        @endphp
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($finalPath)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    <!--begin::Custom Stylesheets(optional)-->
    @foreach(getCustomCss() as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    @stack('styles')

    @livewireStyles
</head>
<!--end::Head-->

<!--begin::Body-->
<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

@include('partials/theme-mode/_init')

@yield('content')

<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
@foreach(getGlobalAssets() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used by this page)-->
@foreach(getVendors('js') as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(optional)-->

<script src="{{asset('assets/js/filepond.js')}}"></script>
<script src="{{asset('assets/js/filepond-plugin-image-preview.js')}}"></script>
<script src="{{asset('assets/js/sweetalert2@11.js')}}"></script>
@foreach(getCustomJs() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Custom Javascript-->
@stack('scripts')
<!--end::Javascript-->

<script src="{{asset('assets/js/pusher.min.js')}}"></script>
<script src="{{asset('assets/js/echo.iife.js')}}"></script>


@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<script>
    window.Pusher = Pusher;
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env("PUSHER_APP_KEY") }}',
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        forceTLS: false,
        wsHost: 'ws-mt1.pusher.com',
        wsPort: 80,
        wssPort: 443,
        disableStats: true,
        auth: {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        },
    });


    window.Echo.private('reports.{{ auth()->id() }}')
        .listen('.report.ai.finished', (e) => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'تم الانتهاء من تحليل التقرير #' + e.reportId,
                showConfirmButton: false,
                timer: 3000,
            });
        });


    window.Echo.private('reports.update.{{ auth()->id() }}')
        .listen('.report.status.updated', (e) => {
            let iconType = e.status === 'approved' ? 'success' : 'error';
            let message = '';

            if (e.status === 'approved') {
                message = 'تم قبول التقرير #' + e.report.id;
            } else if (e.status === 'rejected') {
                message = 'تم رفض التقرير #' + e.report.id + ' — السبب: ' + e.reason;
            }

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: iconType,
                title: message,
                showConfirmButton: false,
                timer: 3500,
            });
        });


</script>


<script>
    document.addEventListener('livewire:load', () => {
        Livewire.on('success', (message) => {
            toastr.success(message);
        });
        Livewire.on('error', (message) => {
            toastr.error(message);
        });

        Livewire.on('swal', (message, icon, confirmButtonText) => {
            if (typeof icon === 'undefined') {
                icon = 'success';
            }
            if (typeof confirmButtonText === 'undefined') {
                confirmButtonText = 'Ok, got it!';
            }
            Swal.fire({
                text: message,
                icon: icon,
                buttonsStyling: false,
                confirmButtonText: confirmButtonText,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        });
    });
</script>

@include('sweetalert::alert', ['cdn' => asset('assets/js/sweetalert2@11.js')])

@livewireScripts
</body>
<!--end::Body-->

</html>
