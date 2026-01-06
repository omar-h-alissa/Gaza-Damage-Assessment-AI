<div class="modal fade" id="kt_modal_update_details" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form class="form" method="post" enctype="multipart/form-data" action="{{route('user-management.users.update', $user)}}" >
                @csrf
                @method('PATCH')

                <div class="modal-header" id="kt_modal_update_user_header">
                    <h2 class="fw-bold">{{ __('menu.update_user_details') }}</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body px-5 my-7">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_update_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header" data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">

                        <div class="fw-bolder fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_update_user_user_info" role="button" aria-expanded="false">
                            {{ __('menu.user_information') }}
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>

                        <div id="kt_modal_update_user_user_info" class="collapse show">
                            <div class="mb-7">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span>{{ __('menu.update_avatar') }}</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="{{ __('menu.allowed_file_types') }}">
                                        <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    </span>
                                </label>
                                <div class="mt-1">
                                    <style>
                                        .image-input-placeholder { background-image: url('{{ image('svg/files/blank-image.svg') }}'); }
                                        [data-bs-theme="dark"] .image-input-placeholder { background-image: url('{{ image('svg/files/blank-image-dark.svg') }}'); }
                                    </style>
                                    <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $user->profile_photo_url }});"></div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="{{ __('menu.change_avatar') }}">
                                            <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                        </label>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="{{ __('menu.cancel_avatar') }}">
                                            <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="{{ __('menu.remove_avatar') }}">
                                            <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">{{ __('menu.full_name') }}</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" placeholder="{{ __('menu.first_name') }}" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control form-control-solid"/>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" placeholder="{{ __('menu.second_name') }}" name="second_name" value="{{ old('second_name', $user->second_name) }}" class="form-control form-control-solid"/>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" placeholder="{{ __('menu.third_name') }}" name="third_name" value="{{ old('third_name', $user->third_name) }}" class="form-control form-control-solid"/>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" placeholder="{{ __('menu.last_name') }}" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control form-control-solid"/>
                                    </div>
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">{{ __('menu.phone') }}</label>
                                <input type="text" class="form-control form-control-solid" placeholder="{{ __('menu.phone') }}" name="phone" value="{{ $user->phone }}" style="direction: ltr;" />
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">{{ __('menu.family_members') }}</label>
                                <input type="number" class="form-control form-control-solid" placeholder="{{ __('menu.family_members') }}" name="family_members" value="{{ $user->family_members }}" />
                            </div>
                        </div>

                        <div class="fw-bolder fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_update_user_address" role="button" aria-expanded="false">
                            {{ __('menu.address_details') }}
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>

                        <div id="kt_modal_update_user_address" class="collapse show">
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">{{ __('menu.region_governorate') }}</label>
                                <input type="text" class="form-control form-control-solid" name="area" value="{{ $user->address_area }}">
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">{{ __('menu.city_camp') }}</label>
                                <input type="text" class="form-control form-control-solid" name="city" value="{{ $user->address_city }}">
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">{{ __('menu.district_street') }}</label>
                                <input type="text" class="form-control form-control-solid" name="street" value="{{ $user->address_street }}">
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">{{ __('menu.additional_details') }}</label>
                                <input type="text" class="form-control form-control-solid" name="details" value="{{ $user->address_details }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('menu.discard') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">{{ __('menu.submit') }}</span>
                        <span class="indicator-progress">{{ __('menu.please_wait') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
