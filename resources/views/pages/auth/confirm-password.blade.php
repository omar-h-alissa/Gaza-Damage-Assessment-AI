<x-auth-layout>
    <!--begin::Forgot Password Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">{{ __('menu.confirm_password_title') }}</h1>
            <!--end::Title-->
            <!--begin::Link-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __('menu.confirm_password_message') }}
            </div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group=-->
        <div class="fv-row mb-8 fv-plugins-icon-container">
            <!--begin::Password-->
            <input placeholder="{{ __('menu.password_placeholder') }}" type="password" name="password" required autocomplete="current-password" class="form-control bg-transparent">

            @error('password')
            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
            @enderror
            <!--end::Password-->
        </div>

        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" id="kt_password_reset_submit" class="btn btn-primary me-4">
                @include('partials.general._button-indicator', ['label' => __('menu.confirm_btn')])
            </button>
            <a href="{{ route('login') }}" class="btn btn-light">{{ __('menu.cancel_btn') }}</a>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Forgot Password Form-->
</x-auth-layout>
