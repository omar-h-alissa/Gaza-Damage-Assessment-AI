<div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                {{-- العنوان بناءً على الحالة --}}
                <h2 class="fw-bold">
                    {{ $role->exists ? __('menu.update_role_title') . ucwords($name) : __('menu.add_role_title') }}
                </h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 my-7">
                <form id="kt_modal_update_role_form" class="form" action="#" wire:submit.prevent="submit" :key="$role->id">
                    <div class="d-flex flex-column scroll-y {{ app()->getLocale() == 'ar' ? 'ms-n7 ps-7' : 'me-n7 pe-7' }}" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">

                        <div class="fv-row mb-10">
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">{{ __('menu.role_name') }}</span>
                            </label>
                            <input class="form-control form-control-solid" placeholder="{{ __('menu.enter_role_name') }}" name="name" wire:model="name"/>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="fv-row">
                            <label class="fs-5 fw-bold form-label mb-2">{{ __('menu.role_permissions') }}</label>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <tbody class="text-gray-600 fw-semibold">
                                    <tr>
                                        <td class="text-gray-800">{{ __('menu.administrator_access') }}
                                            <span class="{{ app()->getLocale() == 'ar' ? 'me-1' : 'ms-1' }}" data-bs-toggle="tooltip" title="{{ __('menu.full_access_hint') }}">
                                                {!! getIcon('information-5','text-gray-500 fs-6') !!}
                                            </span>
                                        </td>
                                        <td>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid {{ app()->getLocale() == 'ar' ? 'ms-9' : 'me-9' }}">
                                                <input class="form-check-input" type="checkbox" id="kt_roles_select_all" wire:model="check_all" wire:change="checkAll" />
                                                <span class="form-check-label" for="kt_roles_select_all">{{ __('menu.select_all') }}</span>
                                            </label>
                                        </td>
                                    </tr>

                                    @foreach($permissions_by_group as $group => $permissions)
                                        <tr>
                                            <td class="text-gray-800">{{ ucwords($group) }}</td>
                                            <td colspan="3">
                                                <div class="d-flex flex-wrap">
                                                    @foreach($permissions as $permission)
                                                        <div class="{{ app()->getLocale() == 'ar' ? 'ms-5 ms-lg-20' : 'me-5 me-lg-20' }} mb-3">
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox" wire:model.defer="checked_permissions" value="{{ $permission->name }}"/>
                                                                {{-- ملاحظة: يمكنك تعريب view/edit/delete هنا إذا رغبت --}}
                                                                <span class="form-check-label">{{ ucwords(Str::before($permission->name, ' ')) }}</span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" wire:loading.attr="disabled">{{ __('menu.discard') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label" wire:loading.remove wire:target="submit">
                                {{ $role->exists ? __('menu.update_role') : __('menu.create_role') }}
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
