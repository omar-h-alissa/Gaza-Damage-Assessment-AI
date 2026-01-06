<div wire:ignore.self class="modal fade" id="kt_modal_add_property" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ $property_id ? __('menu.edit_property') : __('menu.add_property') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"></i>
                </div>
            </div>

            <form wire:submit.prevent="save" class="form">
                <div class="modal-body py-10 px-lg-17">
                    <div class="mb-5">
                        <label class="required form-label">{{ __('menu.property_owner') }}</label>
                        <input type="text" wire:model="property_owner" class="form-control" placeholder="{{ __('menu.owner_name_placeholder') }}">
                        @error('property_owner') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="required form-label">{{ __('menu.ownership_type') }}</label>
                        <select wire:model="ownership_type" class="form-select">
                            <option value="">{{ __('menu.select_option') }}</option>
                            <option value="owned">{{ __('menu.owned') }}</option>
                            <option value="rented">{{ __('menu.rented') }}</option>
                        </select>
                        @error('ownership_type') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="required form-label">{{ __('menu.address') }}</label>
                        <input type="text" wire:model="address" class="form-control" placeholder="{{ __('menu.address_placeholder') }}">
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label class="form-label">{{ __('menu.floors_count') }}</label>
                            <input type="number" wire:model="floors_count" class="form-control" placeholder="0">
                        </div>
                        <div class="col">
                            <label class="form-label">{{ __('menu.residents_count') }}</label>
                            <input type="number" wire:model="residents_count" class="form-control" placeholder="0">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">{{ __('menu.documents_hint') }}</label>
                        <input type="text" wire:model="documents" class="form-control" placeholder="http://...">
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold mb-2">{{ __('menu.select_location') }}</label>
                        {{-- ملاحظة: تأكد من أن ملف الـ JS الخاص بالخريطة يدعم الـ RTL --}}
                        <div wire:ignore id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>
                        <input type="hidden" wire:model="latitude">
                        <input type="hidden" wire:model="longitude">
                        @error('latitude') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('menu.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label" wire:loading.remove wire:target="save">
                            {{ $property_id ? __('menu.update') : __('menu.save') }}
                        </span>
                        <span class="indicator-progress" wire:loading wire:target="save">
                            {{ __('menu.please_wait') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
