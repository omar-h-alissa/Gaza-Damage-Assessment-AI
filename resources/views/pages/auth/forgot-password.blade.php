<x-auth-layout>
    <form class="form w-100" novalidate="novalidate" id="" method="post" action="{{ route('password.phone') }}">
        @csrf
        <div class="text-center mb-10">
            <h1 class="text-dark fw-bolder mb-3">
                {{ __('menu.forgot_password_title') }}
            </h1>
            <div class="text-gray-500 fw-semibold fs-6 mb-5">
                {{ __('menu.forgot_password_desc') }}
            </div>

            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                <i class="ki-duotone ki-information-5 fs-2tx text-warning me-4">
                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                </i>
                <div class="d-flex flex-stack flex-grow-1">
                    <div class="fw-semibold">
                        <h4 class="text-gray-900 fw-bold text-start">{{ __('menu.sandbox_notice_title') }}</h4>
                        <div class="fs-6 text-gray-700 text-start">
                            {{ __('menu.sandbox_notice_body') }}
                            <code class="fw-bold text-dark">join ancient-tales</code>
                            {{ __('menu.sandbox_notice_number') }}
                            <span class="badge badge-secondary fw-bold">+1 415 523 8886</span>
                            <br>
                            <span class="text-danger mt-2 d-block">
                                <strong>* {{ __('menu.sandbox_notice_important') }}</strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fv-row mb-8">
            <input type="text" placeholder="{{ __('menu.phone_placeholder') }}" name="phone" autocomplete="off" class="form-control bg-transparent" />
        </div>

        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" class="btn btn-primary me-4">
                @include('partials/general/_button-indicator', ['label' => __('menu.submit')])
            </button>
            <a href="{{ route('login') }}" class="btn btn-light">{{ __('menu.cancel') }}</a>
        </div>
    </form>
</x-auth-layout>
