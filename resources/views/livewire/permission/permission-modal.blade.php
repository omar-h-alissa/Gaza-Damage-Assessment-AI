<div class="modal fade" id="kt_modal_update_permission" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ __('menu.update_permission') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                    {{-- تبديل me-4 بـ ms-4 في حال العربية --}}
                    {!! getIcon('information','fs-2tx text-warning ' . (app()->getLocale() == 'ar' ? 'ms-4' : 'me-4')) !!}
                    <div class="d-flex flex-stack flex-grow-1">
                        <div class="fw-semibold">
                            <div class="fs-6 text-gray-700">
                                <strong class="{{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }} text-danger">{{ __('menu.warning') }}</strong>
                                {{ __('menu.permission_edit_warning') }}
                            </div>
                        </div>
                    </div>
                </div>
                <form id="kt_modal_update_permission_form" class="form" action="#" wire:submit.prevent="submit">
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">{{ __('menu.permission_name') }}</span>
                            <span class="{{ app()->getLocale() == 'ar' ? 'me-2' : 'ms-2' }}" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="{{ __('menu.permission_name_hint') }}">
                                {!! getIcon('information','fs-7') !!}
                            </span>
                        </label>
                        <input class="form-control form-control-solid" placeholder="{{ __('menu.enter_permission_name') }}" name="name" wire:model.defer="name"/>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close" wire:loading.attr="disabled">
                            {{ __('menu.discard') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label" wire:loading.remove wire:target="submit">{{ __('menu.submit') }}</span>
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
