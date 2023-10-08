// app constants & globals

let timerOn = true;
const error_icon = '<span class="uk-margin-small-left" uk-icon=\'icon: ban\'></span>';
const success_icon = '<span class="uk-margin-small-left" uk-icon=\'icon: check\'></span>';
const warning_icon = '<span class="uk-margin-small-left" uk-icon=\'icon: warning\'></span>';
const translations = {
    'full name': 'نام و نام خانوادگی',
    'email' : 'ایمیل',
    'phone number': 'شماره موبایل',
    'filed': '',
    'data.specialties' : 'تخصص',
    'data.birthdate': 'تاریخ تولد',
    'The': '',
    'field is required': 'الزامی است',
    'has already been taken': 'قبلا انتخاب شده است',
    'must be a number': 'باید یک شماره باشد.'
};

function TranslateReqParams(input) {
    let output = input;
    for (var key in translations) {
        if (!translations.hasOwnProperty(key)) {
            continue;
        }
        output = output.replace(new RegExp(key, "g"), translations[key]);
    }

    return output;
}

const e2p = s => s.replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d])
const e2a = s => s.replace(/\d/g, d => '٠١٢٣٤٥٦٧٨٩'[d])

const p2e = s => s.replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d))
const a2e = s => s.replace(/[٠-٩]/g, d => '٠١٢٣٤٥٦٧٨٩'.indexOf(d))

const p2a = s => s.replace(/[۰-۹]/g, d => '٠١٢٣٤٥٦٧٨٩'['۰۱۲۳۴۵۶۷۸۹'.indexOf(d)])
const a2p = s => s.replace(/[٠-٩]/g, d => '۰۱۲۳۴۵۶۷۸۹'['٠١٢٣٤٥٦٧٨٩'.indexOf(d)])

// login page
function timer(remaining, callback) {
    document.querySelector('#timer-wrapper').classList.remove('uk-hidden');
    var m = Math.floor(remaining / 60);
    var s = remaining % 60;

    m = m < 10 ? '0' + m : m;
    s = s < 10 ? '0' + s : s;
    document.getElementById('timer').innerHTML = m + ':' + s;
    remaining -= 1;

    if (remaining >= 0 && timerOn) {
        setTimeout(function () {
            timer(remaining, callback);
        }, 1000);
        return;
    }

    if (!timerOn) {
        // Prevent function continues till timer ends.
        return;
    }

    // Handle timer ending
    callback();
}

function allowSendOtpAgain() {
    document.querySelector('#phone_verification_wrapper').classList.add('uk-hidden');
    document.querySelector('#otp_entry_wrapper').classList.remove('uk-hidden');

    document.querySelector('#timer-wrapper').classList.toggle('uk-hidden');
    document.querySelector('#resend-otp').classList.toggle('uk-hidden');
}

function resendOtp() {
    let phone_number = document.querySelector('#phone_number').value;
    if (phone_number.length != 11) {
        return;
    }
    axios.post('/api/otp/generate', {
        phone_number: phone_number,
    })
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                UIkit.notification({
                    message: success_icon + response.data.messages[AppLocale],
                    status: 'success',
                    pos: 'bottom-right',
                    timeout: 5000
                });
                document.querySelector('#user_phone_number').value = response.data.phone_numbe;
                document.querySelector('#resend-otp').classList.toggle('uk-hidden');
                timer(120, allowSendOtpAgain);
            } else {
                UIkit.notification({
                    message: error_icon + response.data.errors[AppLocale],
                    status: 'danger',
                    pos: 'bottom-right',
                    timeout: 5000
                });
            }
            // console.log(response);
        })
        .catch(function (error) {
            // handle error
            // console.log(error);
        })
        .finally(function () {
            // always executed
        });
}

function handleMobileAuth() {
    let phone_number = document.querySelector('#phone_number').value;
    if (phone_number.length != 11) {
        return;
    }
    axios.post('/api/otp/generate', {
        phone_number: phone_number,
    })
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                UIkit.notification({
                    message: success_icon + response.data.messages[AppLocale],
                    status: 'success',
                    pos: 'bottom-right',
                    timeout: 5000
                });
                document.querySelector('#phone_verification_wrapper').classList.toggle('uk-hidden');
                document.querySelector('#otp_entry_wrapper').classList.toggle('uk-hidden');
                document.querySelector('#user_phone_number').value = p2e(response.data.phone_number);
                timer(120, allowSendOtpAgain);
            } else {
                UIkit.notification({
                    message: error_icon + response.data.errors[AppLocale],
                    status: 'danger',
                    pos: 'bottom-right',
                    timeout: 5000
                });
            }
            // console.log(response);
        })
        .catch(function (error) {
            // handle error
            // console.log(error);
        })
        .finally(function () {
            // always executed
        });

}

function checkUserOtp() {
    let phone_number = p2e(document.querySelector('#user_phone_number').value);
    let otp = document.querySelector('#otp').value;

    if (phone_number.length != 11 || otp.length == 0) {
        return;
    }

    axios.post('/api/otp/validate', {
        phone_number: phone_number,
        otp: otp
    })
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                UIkit.notification({
                    message: success_icon + response.data.messages[AppLocale],
                    status: 'success',
                    pos: 'bottom-right',
                    timeout: 5000
                });
                if (response.data.hasOwnProperty('allowed') && response.data.hasOwnProperty('timestamp') && response.data.allowed) {
                    document.location.reload();
                } else {
                    UIkit.notification({
                        message: error_icon + 'مشکلی پیش آمده است.',
                        status: 'warning',
                        pos: 'bottom-right',
                        timeout: 5000
                    });
                }
            } else {
                UIkit.notification({
                    message: error_icon + response.data.errors[AppLocale],
                    status: 'danger',
                    pos: 'bottom-right',
                    timeout: 5000
                });
            }
            // console.log(response);
        })
        .catch(function (error) {
            // handle error
            // console.log(error);
        })
        .finally(function () {
            // always executed
        });
}

// register page
function validateRegistrationNumber() {
    let phone_number = p2e(document.querySelector('#phone_number').value);

    if (phone_number.length != 11) {
        return;
    }

    axios.post('/api/phone/validate', {
        phone_number: phone_number,
    })
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                UIkit.notification({
                    message: success_icon + response.data.messages[AppLocale],
                    status: 'success',
                    pos: 'bottom-right',
                    timeout: 5000
                });
                if (response.data.hasOwnProperty('allowed') && response.data.hasOwnProperty('timestamp') && response.data.allowed) {
                        document.querySelector('#main-wrapper').classList.replace('uk-width-1-4@m', 'uk-width-2-3@m');
                        document.querySelector('#phone_verification_wrapper').classList.toggle('uk-hidden');
                        document.querySelector('#phone_number_preview').innerText = phone_number;
                        document.querySelector('#user_phone_number').value = p2e(phone_number);
                        document.querySelector('#registration-data-wrapper').classList.toggle('uk-hidden');
                } else {
                    UIkit.notification({
                        message: error_icon + 'مشکلی پیش آمده است.',
                        status: 'warning',
                        pos: 'bottom-right',
                        timeout: 5000
                    });
                }
            } else {
                UIkit.notification({
                    message: error_icon + response.data.errors[AppLocale],
                    status: 'danger',
                    pos: 'bottom-right',
                    timeout: 5000
                });
            }
            console.log(response);
        })
        .catch(function (error) {
            // handle error
            // console.log(error);
        })
        .finally(function () {
            // always executed
        });
}

function handleRegistration() {
    let form = document.querySelector('#registration-form');
    let data = new FormData(form);

    axios.post('/auth/register', data)
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                UIkit.notification({
                    message: success_icon + response.data.messages[AppLocale],
                    status: 'success',
                    pos: 'bottom-right',
                    timeout: 5000
                });
                if (response.data.hasOwnProperty('allowed') && response.data.hasOwnProperty('timestamp') && response.data.allowed) {
                    window.location.replace("/auth/login");
                } else {
                    UIkit.notification({
                        message: error_icon + 'مشکلی پیش آمده است.',
                        status: 'warning',
                        pos: 'bottom-right',
                        timeout: 5000
                    });
                }
            } else {
                UIkit.notification({
                    message: error_icon + TranslateReqParams(response.data.error),
                    status: 'danger',
                    pos: 'bottom-right',
                    timeout: 5000
                });
            }
            // console.log(response);
        })
        .catch(function (error) {
            // handle error
            // console.log(error);
        })
        .finally(function () {
            // always executed
        });
}

// main functionalities
function logOutSession() {
    axios.post('/auth/logout')
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                UIkit.notification({
                    message: success_icon + response.data.messages[AppLocale],
                    status: 'success',
                    pos: 'bottom-right',
                    timeout: 5000
                });
                if (response.data.hasOwnProperty('allowed') && response.data.hasOwnProperty('timestamp') && response.data.allowed) {
                    window.location.replace("/auth/login");
                } else {
                    UIkit.notification({
                        message: error_icon + 'مشکلی پیش آمده است.',
                        status: 'warning',
                        pos: 'bottom-right',
                        timeout: 5000
                    });
                }
            } else {
                UIkit.notification({
                    message: error_icon + response.data.errors[AppLocale],
                    status: 'danger',
                    pos: 'bottom-right',
                    timeout: 5000
                });
            }
            // console.log(response);
        })
        .catch(function (error) {
            // handle error
            // console.log(error);
        })
        .finally(function () {
            // always executed
        });
}

function ToastNotif(status = 'success', message, position = 'bottom-right', timeout = 5000) {
    UIkit.notification({
        message: message,
        status: status,
        pos: position,
        timeout: timeout
    });
}

function ShortThrowError(message) {
    ShortThrowError(message);
}

// step advertisement form
function showStep(index) {
    if (index == 5) {
        mapInvalidateFunction();
    }
    let nodes = document.querySelectorAll('.step');
    nodes.forEach((n) => {
        if (n.id !== 'step-' + index) {
            n.classList.add('uk-hidden');
            // document.querySelector('#tab-'+index).classList.remove('uk-active');
            UIkit.tab(document.querySelector('#step-tabset')).show(index-1);
        } else {
            n.classList.remove('uk-hidden');
        }
    });
}

function submitAdvertisementForm () {
    let business_cats_json = document.querySelector('#business_category').value;
    let work_hours_json = document.querySelector('#work_hours').value;
    let off_days_json = document.querySelector('#off_days').value;
    let images_json = document.querySelector('#business_images').value;
    let payload = {
        fullname: document.querySelector('#fullname').value,
        phone: document.querySelector('#phone').value,
        business_name: document.querySelector('#business_name').value,
        business_category: JSON.stringify(business_cats_json),
        work_hours: JSON.stringify(work_hours_json),
        off_days: JSON.stringify(off_days_json),
        address: document.querySelector('#address').value,
        business_number: document.querySelector('#business_number').value,
        instagram: document.querySelector('#instagram').value,
        telegram: document.querySelector('#telegram').value,
        whatsapp: document.querySelector('#whatsapp').value,
        eitaa: document.querySelector('#eitaa').value,
        other_social_1: document.querySelector('#other_social_1').value,
        other_social_2: document.querySelector('#other_social_2').value,
        business_images: JSON.stringify(images_json),
        province: document.querySelector('#province').value,
        city: document.querySelector('#city').value,
        lat: document.querySelector('#lat').value,
        lng: document.querySelector('#lng').value,
    };

    axios.post('/panel/submit_business', payload)
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                UIkit.notification({
                    message: success_icon + response.data.messages.fa,
                    status: 'success',
                    pos: 'bottom-right',
                    timeout: 5000
                });
                if (response.data.hasOwnProperty('allowed') && response.data.hasOwnProperty('timestamp') && response.data.allowed) {
                    window.location.reload();
                } else {
                    UIkit.notification({
                        message: error_icon + 'مشکلی پیش آمده است.',
                        status: 'warning',
                        pos: 'bottom-right',
                        timeout: 5000
                    });
                }
            } else {
                UIkit.notification({
                    message: error_icon + response.data.error,
                    status: 'danger',
                    pos: 'bottom-right',
                    timeout: 5000
                });
            }
            // console.log(response);
        })
        .catch(function (error) {
            // handle error
            // console.log(error);
        })
        .finally(function () {
            // always executed
        });
}

