<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">{{ __('menu.add_user') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_user_form" class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                        <div class="fv-row mb-7">
                            <label class="d-block fw-semibold fs-6 mb-5">{{ __('menu.avatar') }}</label>

                            <style>
                                .image-input-placeholder { background-image: url('{{ image('svg/files/blank-image.svg') }}'); }
                                [data-bs-theme="dark"] .image-input-placeholder { background-image: url('{{ image('svg/files/blank-image-dark.svg') }}'); }
                            </style>

                            <div class="image-input image-input-outline image-input-placeholder {{ $avatar || $saved_avatar ? '' : 'image-input-empty' }}" data-kt-image-input="true">
                                @if($avatar)
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $avatar ? $avatar->temporaryUrl() : '' }});"></div>
                                @else
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $saved_avatar }});"></div>
                                @endif

                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="{{ __('menu.change_avatar') }}">
                                    {!! getIcon('pencil','fs-7') !!}
                                    <input type="file" wire:model.defer="avatar" name="avatar" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="avatar_remove"/>
                                </label>

                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="{{ __('menu.cancel_avatar') }}">
                                    {!! getIcon('cross','fs-2') !!}
                                </span>

                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="{{ __('menu.remove_avatar') }}">
                                    {!! getIcon('cross','fs-2') !!}
                                </span>
                            </div>

                            <div class="form-text">{{ __('menu.allowed_file_types') }}</div>
                            @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">{{ __('menu.full_name') }}</label>
                            <input type="text" wire:model.defer="name" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('menu.full_name') }}"/>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">{{ __('menu.email') }}</label>
                            <input type="email" wire:model.defer="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com"/>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-5">{{ __('menu.role') }}</label>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror

                            @foreach($roles as $role)
                                <div class="d-flex fv-row">
                                    <div class="form-check form-check-custom form-check-solid">
                                        {{-- في الـ RTL نستخدم ms-3 بدلاً من me-3 للتنسيق --}}
                                        <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}" id="kt_modal_update_role_option_{{ $role->id }}" wire:model.defer="role" name="role" type="radio" value="{{ $role->name }}"/>

                                        <label class="form-check-label" for="kt_modal_update_role_option_{{ $role->id }}">
                                            <div class="fw-bold text-gray-800">
                                                {{ ucwords($role->name) }}
                                            </div>
                                            <div class="text-gray-600">
                                                {{ $role->description }}
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <div class='separator separator-dashed my-5'></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" wire:loading.attr="disabled">
                            {{ __('menu.discard') }}
                        </button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label" wire:loading.remove wire:target="submit">
                                {{ __('menu.submit') }}
                            </span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                {{ __('menu.please_wait') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
