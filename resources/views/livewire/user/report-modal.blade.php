<div class="modal fade" id="kt_modal_add_report" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="fw-bold">{{ __('menu.add_report') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 my-7">
                <form wire:submit.prevent="submit" class="form">

                    <div class="d-flex flex-column scroll-y {{ app()->getLocale() == 'ar' ? 'ms-n7 ps-7' : 'me-n7 pe-7' }}">

                        <div class="fv-row mb-7">
                            <label class="fs-5 fw-bold mb-2 required">{{ __('menu.select_property') }}</label>
                            <select wire:model="property_id" class="form-select form-select-solid">
                                <option value="">{{ __('menu.select_property') }}</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}">
                                        {{ $property->address }} ({{ $property->property_owner }})
                                    </option>
                                @endforeach
                            </select>
                            @error('property_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fs-5 fw-bold mb-2 required">{{ __('menu.damage_type') }}</label>
                            <select wire:model="damage_type" class="form-select form-select-solid">
                                <option value="">{{ __('menu.select_type') }}</option>
                                <option value="partial">{{ __('menu.partial_damage') }}</option>
                                <option value="severe_partial">{{ __('menu.severe_partial_damage') }}</option>
                                <option value="total">{{ __('menu.total_damage') }}</option>
                            </select>
                            @error('damage_type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fs-5 fw-bold mb-2 required">{{ __('menu.damage_description') }}</label>
                            <textarea wire:model="damage_description" class="form-control form-control-solid" rows="3"
                                      placeholder="{{ __('menu.damage_description_placeholder') }}"></textarea>
                            @error('damage_description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="fv-row mb-7" wire:ignore>
                            <label class="required fs-5 fw-bold mb-2">{{ __('menu.upload_photos') }}</label>
                            <input type="file" class="filepond"
                                   id="damage_photos_input"
                                   multiple
                                   data-max-file-size="3MB"
                                   data-allow-reorder="true"
                                   required>
                            @error('damage_photos') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('menu.discard') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="submit">{{ __('menu.save_report') }}</span>
                            <span wire:loading wire:target="submit">
                                {{ __('menu.please_wait') }}
                                <span class="spinner-border spinner-border-sm ms-2"></span>
                            </span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let filePondInstance = null;

    function initializeFilePond() {
        const inputElement = document.getElementById('damage_photos_input');
        if (filePondInstance || !inputElement) return;

        FilePond.registerPlugin(FilePondPluginImagePreview);

        filePondInstance = FilePond.create(inputElement, {
            allowImagePreview: true,
            imagePreviewHeight: 150,
            allowFileTypeValidation: true,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
            // استخدام الترجمة من Laravel داخل JS
            labelIdle: '{{ __("menu.filepond_label") }}',
            allowReorder: true
        });

        filePondInstance.setOptions({
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                @this.upload('damage_photos', file, load, error, progress)
                },
                revert: (filename, load) => {
                @this.removeUpload('damage_photos', filename, load)
                },
            },
        });

        const modalElement = document.getElementById('kt_modal_add_report');
        modalElement.addEventListener('hidden.bs.modal', function () {
        @this.dispatch('reset-form');
            if (filePondInstance) {
                filePondInstance.removeFiles();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initializeFilePond);

    document.addEventListener('livewire:initialized', function () {
        Livewire.on('init-filepond', () => {
            if (filePondInstance) {
                filePondInstance.removeFiles();
            }
            initializeFilePond();
        });

        Livewire.on('closeModal', () => {
            const modalElement = document.getElementById('kt_modal_add_report');
            if (typeof bootstrap !== 'undefined' && modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.hide();
            }
        });
    });
</script>
