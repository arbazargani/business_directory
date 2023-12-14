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
                    pos: 'top-center',
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
                /**
                * CODE BLOCK MOVED AFTER AXIOS request to run immediately after sending request without waiting for response.
                * */
                // UIkit.notification({
                //     message: success_icon + response.data.messages[AppLocale],
                //     status: 'success',
                //     pos: 'top-center',
                //     timeout: 5000
                // });
                // document.querySelector('#phone_verification_wrapper').classList.toggle('uk-hidden');
                // document.querySelector('#otp_entry_wrapper').classList.toggle('uk-hidden');
                 document.querySelector('#user_phone_number').value = p2e(response.data.phone_number);
                // timer(120, allowSendOtpAgain);
            } else {
                UIkit.notification({
                    message: error_icon + response.data.errors[AppLocale],
                    status: 'danger',
                    pos: 'bottom-right',
                    timeout: 5000
                });
            }
        })
        .catch(function (error) {
            // handle error
            // console.log(error);
        })
        .finally(function () {
            // always executed
        });

        /** START OF code block from axios .then fn */
        UIkit.notification({
            message: success_icon + 'رمز یکبارمصرف برای شما ارسال شد ...',
            status: 'success',
            pos: 'top-center',
            timeout: 5000
        });
        document.querySelector('#phone_verification_wrapper').classList.toggle('uk-hidden');
        document.querySelector('#otp_entry_wrapper').classList.toggle('uk-hidden');
//        document.querySelector('#user_phone_number').value = p2e(response.data.phone_number);
        timer(120, allowSendOtpAgain);
        /** END OF code block from axios .then fn */

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
                    pos: 'top-center',
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
                    pos: 'top-center',
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
                    pos: 'top-center',
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
                    pos: 'top-center',
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
            UIkit.tab(document.querySelector('#step-tabset')).show(index-1);
        } else {
            n.classList.remove('uk-hidden');
        }
    });
    document.querySelector('#tab-'+index).scrollIntoView()
}

function handle24H(dispatcher) {
    let value = parseInt(dispatcher.value);
    let max = parseInt(dispatcher.max);
    let min = parseInt(dispatcher.min);
    if (value > max) {
        dispatcher.value = max;
    }
    if (value < min) {
        dispatcher.value = min;
    }
}

function addTempSocialLink() {
    // <input className="uk-input" type="text" name="other_social[]" placeholder="سایر ۲">
    let elemWrapper = document.createElement('div');
    elemWrapper.classList.add('uk-margin');

    let elem = document.createElement('input');
    elem.type = 'text';
    elem.name = 'other_social[]';
    elem.placeholder = 'سایر'
    elem.classList.add('uk-input');
    elemWrapper.appendChild(elem);
    document.querySelector('#social_wrapper').appendChild(elemWrapper);
}

function listProvinceCities() {
    let citiesSelect = document.querySelector('#city');
    let citiesLoader = document.querySelector('#city_loader');
    citiesSelect.classList.add('uk-disabled');
    citiesLoader.classList.remove('uk-hidden');
    let payload = {
        province: parseInt(document.querySelector('#province').value)
    };
    axios.post('/api/public/list_cities', payload)
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                if (response.data.hasOwnProperty('allowed') && response.data.hasOwnProperty('timestamp') && response.data.allowed) {
                    citiesSelect.innerHTML = response.data.html;
                    citiesSelect.classList.remove('uk-disabled');
                    citiesLoader.classList.add('uk-hidden');

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

/*handle initial cities on page load*/
document.querySelector('#province').onchange();

function moveMapToQuery() {
    console.log('running ...');
    let citiesSelect = document.querySelector('#city');
    let city_name = citiesSelect.options[citiesSelect.selectedIndex].dataset.name;
    let query = document.querySelector('#query');
    query.value = city_name;
    searchApi(true);
}

function renderAdvertisementFormImagesPreview(elem) {
    let lastSelect = document.querySelector('#business_images').value;
    let selections = document.querySelector('#business_images').files;
    let id = 0;

    for (var i = 0; i < 5; i++) {
        id += 1;
        document.querySelector('#file_prev_' + id).src = '';
        document.querySelector('#file_prev_name_' + id).innerText = '';
    }

    if (selections.length > 5) {
        this.preventDefault();
    }
    id = 0;
    for (var i = 0; i < selections.length; i++) {
        id += 1;
        document.querySelector('#file_prev_' + id).src = URL.createObjectURL(selections[i]);
        document.querySelector('#file_prev_name_' + id).innerText = selections[i].name;
    }
}

function submitAdvertisementForm () {
    let need_registration = (document.querySelector('#includes_registration') !== null) ? true : false;
    let other_socials = document.getElementsByName('other_social[]');
    let other_socials_list = [];
    other_socials.forEach(function(item) {
        other_socials_list.push(item.value);
    });

    let work_hours = document.getElementsByName('work_hours[]');
    let work_hours_list = [];
    work_hours.forEach(function(item) {
        work_hours_list.push(item.value);
    });


    let business_cat = (document.querySelector('#business_category') !== null) ? document.querySelector('#business_category').tomselect.getValue() : null;
    let off_days = (document.querySelector('#off_days') !== null) ? document.querySelector('#off_days').tomselect.getValue() : null;

    let images_json = document.querySelector('#business_images').value;
    let payload = {
        fullname: document.querySelector('#fullname').value,
        phone: document.querySelector('#phone').value,
        email: document.querySelector('#email').value,
        business_name: document.querySelector('#business_name').value,
        business_category: JSON.stringify(business_cat),
        work_hours: JSON.stringify(work_hours_list),
        off_days: JSON.stringify(off_days),
        address: document.querySelector('#address').value,
        business_number: document.querySelector('#business_number').value,
        instagram: document.querySelector('#instagram').value,
        telegram: document.querySelector('#telegram').value,
        whatsapp: document.querySelector('#whatsapp').value,
        eitaa: document.querySelector('#eitaa').value,
        other_socials: JSON.stringify(other_socials_list),
        business_images: document.querySelector('#business_images').files,
        province: document.querySelector('#province').value,
        city: document.querySelector('#city').value,
        lat: document.querySelector('#lat').value,
        lng: document.querySelector('#lng').value,
        description: document.querySelector('#description').value,
    };

    let requestURL = (need_registration) ? '/guest/submit_business' : '/panel/submit_business';
    axios.post(requestURL, payload, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                UIkit.notification({
                    message: success_icon + response.data.messages.fa,
                    status: 'success',
                    pos: 'top-center',
                    timeout: 5000
                });
                if (response.data.hasOwnProperty('allowed') && response.data.hasOwnProperty('timestamp') && response.data.allowed) {
                    window.location.replace('/panel/')
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
                    message: error_icon + response.data.errors.fa,
                    status: 'danger',
                    pos: 'bottom-right',
                    timeout: 5000
                });
            }
            // console.log(response);
        })
        .catch(function (error, response) {
            // handle error
            UIkit.notification({
                message: error_icon + error.response.data.message,
                status: 'danger',
                pos: 'bottom-right',
                timeout: 5000
            });
        })
        .finally(function () {
            // always executed
        });
}

function advertisementApprovlaOptIn(id) {
    document.querySelector('#advertisementApprovlaOptIn_id').value = id;
    UIkit.modal('#advertisement_approval_modal').show();
}

function changeAdConfirmedStat(stat) {
    let IntStat = (stat === true) ? 1 : 0;
    document.querySelector('#advertisementApprovlaOptIn_confirmed').value = IntStat;
    document.querySelector('#adConfirmationForm').submit();
}
