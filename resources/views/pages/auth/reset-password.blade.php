<x-auth-layout>

    <form class="form w-100" novalidate="novalidate" id="kt_new_password_form"  method="post" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="phone" value="{{ old('phone', $phone) }}">

        <div class="text-center mb-10">
            <h1 class="text-dark fw-bolder mb-3">
                {{ __('menu.new_password_title') }}
            </h1>
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __('menu.enter_new_password_desc') }}
            </div>
        </div>
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <div class="mb-1">
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent" type="password" placeholder="{{ __('menu.password_placeholder') }}" name="password" autocomplete="off"/>

                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
            </div>
            <div class="text-muted">
                {{ __('menu.password_hint') }}
            </div>
        </div>
        <div class="fv-row mb-8">
            <input placeholder="{{ __('menu.repeat_password') }}" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent"/>
        </div>

        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" id="kt_new_password_submit" class="btn btn-primary me-4">
                @include('partials/general/_button-indicator', ['label' => __('menu.submit')])
            </button>

            <a href="{{ route('login') }}" class="btn btn-light">{{ __('menu.cancel') }}</a>
        </div>
    </form>
</x-auth-layout>
