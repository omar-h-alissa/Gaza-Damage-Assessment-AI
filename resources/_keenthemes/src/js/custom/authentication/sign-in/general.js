"use strict";

// Dictionary for translations
const translations = {
    en: {
        email_required: "Email address is required",
        email_invalid: "The value is not a valid email address",
        password_required: "The password is required",
        success_title: "You have successfully logged in!",
        error_title: "Sorry, looks like there are some errors detected, please try again.",
        auth_failed: "Sorry, the email or password is incorrect, please try again.",
        ok_button: "Ok, got it!",
        loading: "Please wait..."
    },
    ar: {
        email_required: "البريد الإلكتروني مطلوب",
        email_invalid: "البريد الإلكتروني غير صحيح",
        password_required: "كلمة المرور مطلوبة",
        success_title: "تم تسجيل الدخول بنجاح!",
        error_title: "عذراً، يبدو أن هناك أخطاء تم اكتشافها، يرجى المحاولة مرة أخرى.",
        auth_failed: "عذراً، البريد الإلكتروني أو كلمة المرور غير صحيحة.",
        ok_button: "حسناً، فهمت!",
        loading: "يرجى الانتظار..."
    }
};

var KTSigninGeneral = function () {
    var form;
    var submitButton;
    var validator;
    var currentLang;

    // Get current language from <html lang="..."> or default to 'en'
    var getLang = function() {
        return document.documentElement.getAttribute('lang') === 'ar' ? 'ar' : 'en';
    };

    var t = function(key) {
        return translations[currentLang][key] || translations['en'][key];
    };

    // دالة موحدة لإظهار التنبيهات لضمان ظهور الأيقونات بشكل صحيح
    var showAlert = function(text, icon) {
        return Swal.fire({
            text: text,
            icon: icon, // "success", "error", "warning", "info", "question"
            buttonsStyling: false,
            confirmButtonText: t('ok_button'),
            // إصلاح مشكلة الأيقونات في الـ RTL
            dir: currentLang === 'ar' ? 'rtl' : 'ltr',
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    }

    var handleValidation = function (e) {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'email': {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: t('email_invalid'),
                            },
                            notEmpty: {
                                message: t('email_required')
                            }
                        }
                    },
                    'password': {
                        validators: {
                            notEmpty: {
                                message: t('password_required')
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );
    }

    var handleSubmitAjax = function (e) {
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    axios.post(form.getAttribute('action'), new FormData(form))
                        .then(function (response) {
                            if (response.data) {
                                form.reset();
                                showAlert(t('success_title'), "success").then(function () {
                                    const redirectUrl = form.getAttribute('data-kt-redirect-url');
                                    if (redirectUrl) { location.href = redirectUrl; }
                                });
                            }
                        })
                        .catch(function (error) {
                            const message = error.response?.status === 401 ? t('auth_failed') : t('error_title');
                            showAlert(message, "error");
                        })
                        .then(() => {
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;
                        });
                } else {
                    showAlert(t('error_title'), "error");
                }
            });
        });
    }

    return {
        init: function () {
            form = document.querySelector('#kt_sign_in_form');
            if (!form) return;

            submitButton = document.querySelector('#kt_sign_in_submit');
            currentLang = getLang();

            handleValidation();

            const action = form.getAttribute('action');
            if (action && action !== '#') {
                handleSubmitAjax();
            } else {
                // Fallback for demo
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    validator.validate().then(status => {
                        if (status === 'Valid') {
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true;

                            setTimeout(() => {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;
                                showAlert(t('success_title'), "success");
                            }, 1500);
                        } else {
                            showAlert(t('error_title'), "error");
                        }
                    });
                });
            }
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
