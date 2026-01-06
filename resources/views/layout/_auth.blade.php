@extends('layout.master')

@section('content')

    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">

                <!-- إضافة زر تغيير اللغة في الأعلى جهة اليمين أو اليسار حسب الاتجاه -->
                <div class="d-flex flex-stack px-10 mx-auto w-100 max-w-lg">
                    <div class="me-0">
                        <!-- يمكنك ترك هذه الجهة فارغة أو وضع زر العودة -->
                    </div>

                    <!-- Language Switcher Dropdown -->
                    <div class="me-0">
                        <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-offset="0px, 0px">
                            <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded-circle me-3" src="{{ image('flags/' . (app()->getLocale() == 'ar' ? 'saudi-arabia.svg' : 'united-states.svg')) }}" alt="" />
                            <span data-kt-element="current-lang-name" class="me-1">{{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}</span>
                            <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                        </button>

                        <!-- Menu -->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true">
                            <!-- English Option -->
                            <div class="menu-item px-3">
                                <a href="{{ url('lang/en') }}" class="menu-link d-flex px-5 {{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="{{ image('flags/united-states.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">English</span>
                                </a>
                            </div>
                            <!-- Arabic Option -->
                            <div class="menu-item px-3">
                                <a href="{{ url('lang/ar') }}" class="menu-link d-flex px-5 {{ app()->getLocale() == 'ar' ? 'active' : '' }}">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="{{ image('flags/saudi-arabia.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">العربية</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10">
                        {{ $slot }}
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->


            </div>
            <!--end::Body-->

            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{ image('misc/auth-bg.png') }})">
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="{{ route('dashboard') }}" class="mb-12">
                        <img alt="Logo" src="{{ image('logos/2.png') }}" class="d-none d-lg-block mx-auto w-275px w-md-50 mb-10 mb-lg-20"/>
                    </a>
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                        {{ app()->getLocale() == 'ar' ? 'دقيق، موثوق وذو أثر' : 'Accurate, Reliable and Impactful' }}
                    </h1>
                    <div class="d-none d-lg-block text-white fs-base text-center">
                        @if(app()->getLocale() == 'ar')
                            في هذا النوع من المنشورات، يقدم الفريق مشروعهم "Damage Track"، وهو نظام رقمي مصمم لتوثيق وتحليل أضرار الممتلكات بكفاءة.
                        @else
                            In this kind of post, the team introduces their project “Damage Track”, a digital system designed to document and analyze property damages efficiently.
                        @endif
                    </div>
                </div>
            </div>
            <!--end::Aside-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::App-->

@endsection
