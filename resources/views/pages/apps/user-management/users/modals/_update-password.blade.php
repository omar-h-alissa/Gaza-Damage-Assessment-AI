<!--begin::Modal - Update password-->
<div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ __('menu.update_password') }}</h2>
                <!-- زر الإغلاق العلوي -->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_update_password_form" class="form" action="#">
                    @csrf
                    <!-- كلمة المرور الحالية -->
                    <div class="fv-row mb-10">
                        <label class="required form-label fs-6 mb-2">{{ __('menu.current_password') }}</label>
                        <input class="form-control form-control-lg form-control-solid" type="password" name="current_password" autocomplete="off" />
                    </div>

                    <!-- كلمة المرور الجديدة ومقياس القوة -->
                    <div class="mb-10 fv-row" data-kt-password-meter="true">
                        <div class="mb-1">
                            <label class="form-label fw-semibold fs-6 mb-2">{{ __('menu.new_password') }}</label>
                            <div class="position-relative mb-3">
                                <input class="form-control form-control-lg form-control-solid" type="password" name="new_password" autocomplete="off" />
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                    <i class="ki-duotone ki-eye-slash fs-1"></i>
                                    <i class="ki-duotone ki-eye d-none fs-1"></i>
                                </span>
                            </div>
                            <!-- المقياس -->
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                        </div>
                        <div class="text-muted">{{ __('menu.password_hint') }}</div>
                    </div>

                    <!-- تأكيد كلمة المرور -->
                    <div class="fv-row mb-10">
                        <label class="form-label fw-semibold fs-6 mb-2">{{ __('menu.confirm_password') }}</label>
                        <input class="form-control form-control-lg form-control-solid" type="password" name="new_password_confirmation" autocomplete="off" />
                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('menu.discard') }}</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('menu.submit') }}</span>
                            <span class="indicator-progress">{{ __('menu.please_wait') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // تفعيل مقياس كلمة السر الخاص بميترونيك
        const passwordMeterElement = document.querySelector("#kt_modal_update_password [data-kt-password-meter='true']");
        const passwordMeter = KTPasswordMeter.getInstance(passwordMeterElement);

        $('#kt_modal_update_password_form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const submitButton = form.find('[data-kt-users-modal-action="submit"]');

            // استخدام route من لارافيل
            const url = "{{ route('user.update_password') }}";

            // إظهار مؤشر التحميل
            submitButton.attr('data-kt-indicator', 'on');
            submitButton.prop('disabled', true);

            $.ajax({
                url: url,
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        text: response.message || "تم تحديث كلمة المرور بنجاح",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "موافق",
                        customClass: { confirmButton: "btn btn-primary" }
                    }).then(function() {
                        // إغلاق المودال وتنظيف الفورم
                        $('#kt_modal_update_password').modal('hide');
                        form[0].reset();
                        if (passwordMeter) passwordMeter.reset();
                    });
                },
                error: function(xhr) {
                    let errorMsg = "حدث خطأ غير متوقع";

                    if (xhr.status === 422) {
                        // عرض أول خطأ من الأخطاء القادمة من لارافيل
                        const errors = xhr.responseJSON.errors;
                        errorMsg = Object.values(errors)[0][0];
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        text: errorMsg,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "فهمت",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                },
                complete: function() {
                    // إخفاء مؤشر التحميل
                    submitButton.removeAttr('data-kt-indicator');
                    submitButton.prop('disabled', false);
                }
            });
        });

        // تنظيف الفورم عند إغلاق المودال يدوياً
        $('#kt_modal_update_password').on('hidden.bs.modal', function () {
            $('#kt_modal_update_password_form')[0].reset();
            if (passwordMeter) passwordMeter.reset();
        });
    });
</script>
