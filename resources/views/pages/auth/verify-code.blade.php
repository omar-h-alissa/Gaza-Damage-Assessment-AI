<x-auth-layout>
    <form class="form w-100" novalidate="novalidate" method="post" action="{{ route('password.verify_otp') }}">
        @csrf
        <div class="text-center mb-10">
            <h1 class="text-dark fw-bolder mb-3">
                {{ __('menu.verify_code_title') }}
            </h1>
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __('menu.verify_code_desc') }}
            </div>
        </div>
        <div class="fv-row mb-8">
            <input type="text" placeholder="{{ __('menu.otp_placeholder') }}" name="otp" autocomplete="off" class="form-control bg-transparent" />
            <input type="hidden" name="phone" value="{{$phone}}"/>
        </div>

        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit"  class="btn btn-primary me-4">
                @include('partials/general/_button-indicator', ['label' => __('menu.submit')])
            </button>

            <a href="{{ route('login') }}" class="btn btn-light">{{ __('menu.cancel') }}</a>
        </div>
    </form>
</x-auth-layout>
