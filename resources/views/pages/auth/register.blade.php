<x-auth-layout>

    <!--begin::Form-->
    <form class="form w-100" method="post" action="{{ route('register') }}">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">
                {{ __('menu.sign_up') }}
            </h1>
            <!--end::Title-->

            <!--begin::Subtitle-->
{{--            <div class="text-gray-500 fw-semibold fs-6">--}}
{{--                {{ __('menu.social_campaigns') }}--}}
{{--            </div>--}}
            <!--end::Subtitle--->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <div class="row">
                <!-- First Name -->
                <div class="col-md-6 mb-3">
                    <input type="text" placeholder="{{ __('menu.first_name') }}" name="first_name" value="{{ old('first_name') }}" autocomplete="off" class="form-control bg-transparent" required />
                </div>

                <!-- Second Name -->
                <div class="col-md-6 mb-3">
                    <input type="text" placeholder="{{ __('menu.second_name') }}" name="second_name" value="{{ old('second_name') }}" autocomplete="off" class="form-control bg-transparent" required />
                </div>

                <!-- Third Name -->
                <div class="col-md-6 mb-3">
                    <input type="text" placeholder="{{ __('menu.third_name') }}" name="third_name" value="{{ old('third_name') }}" autocomplete="off" class="form-control bg-transparent" required />
                </div>

                <!-- Last Name -->
                <div class="col-md-6 mb-3">
                    <input type="text" placeholder="{{ __('menu.last_name') }}" name="last_name" value="{{ old('last_name') }}" autocomplete="off" class="form-control bg-transparent" required />
                </div>
            </div>
        </div>


        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::National-->
            <input type="text" placeholder="{{ __('menu.national_id') }}" name="national_id" value="{{ old('national_id') }}" autocomplete="off" class="form-control bg-transparent" required />
            <!--end::National-->
        </div>

        <!--begin::Input group-->
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent" type="password" placeholder="{{ __('menu.password') }}" name="password" autocomplete="off" required />

                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <!--end::Input wrapper-->

                <!--begin::Meter-->
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
                <!--end::Meter-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Hint-->
            <div class="text-muted">
                {{ __('menu.password_hint') }}
            </div>
            <!--end::Hint-->
        </div>
        <!--end::Input group--->



        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Repeat Password-->
            <input placeholder="{{ __('menu.repeat_password') }}" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" required />
            <!--end::Repeat Password-->
        </div>
        <!--end::Input group--->


        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary">
                @include('partials/general/_button-indicator', ['label' => __('menu.sign_up')])
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            {{ __('menu.already_have_account') }}

            <a href="{{ route('login') }}" class="link-primary fw-semibold">
                {{ __('menu.sign_in') }}
            </a>
        </div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->

</x-auth-layout>
