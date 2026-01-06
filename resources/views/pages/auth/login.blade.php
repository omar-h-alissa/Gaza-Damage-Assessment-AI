<x-auth-layout>

    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}">
        @csrf
        <div class="text-center mb-11">
            <h1 class="text-dark fw-bolder mb-3">
                {{ __('menu.sign_in') }}
            </h1>
        </div>
        <div class="separator separator-content my-14">
            <span class="w-125px text-gray-500 fw-semibold fs-7">{{ __('menu.with_national_id') }}</span>
        </div>
        <div class="fv-row mb-8">
            <input type="text" placeholder="{{ __('menu.national_id_placeholder') }}" name="national_id" autocomplete="off" class="form-control bg-transparent" />
        </div>

        <div class="fv-row mb-3">
            <input type="password" placeholder="{{ __('menu.password_placeholder') }}" name="password" autocomplete="off" class="form-control bg-transparent" />
        </div>
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>

            <a href="{{ route('password.request') }}" class="link-primary">
                {{ __('menu.forgot_password') }}
            </a>
        </div>
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                @include('partials/general/_button-indicator', ['label' => __('menu.sign_in')])
            </button>
        </div>
        <div class="text-gray-500 text-center fw-semibold fs-6">
            {{ __('menu.not_a_member') }}

            <a href="{{ route('register') }}" class="link-primary">
                {{ __('menu.sign_up') }}
            </a>
        </div>
    </form>
</x-auth-layout>
