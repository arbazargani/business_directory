// app constants & globals

let timerOn = true;
const error_icon = '<span class="uk-margin-small-left" uk-icon=\'icon: ban\'></span>';
const success_icon = '<span class="uk-margin-small-left" uk-icon=\'icon: check\'></span>';
const warning_icon = '<span class="uk-margin-small-left" uk-icon=\'icon: warning\'></span>';
const translations = {
    '1': '۱',
    '2': '۲',
    '3': '۳',
    '4': '۴',
    '5': '۵',
    '6': '۶',
    '7': '۷',
    '8': '۸',
    '9': '۹',
    '0': '۰',
    'full name': 'نام و نام خانوادگی',
    'email' : 'ایمیل',
    'phone number': 'شماره موبایل',
    'filed': '',
    'data.specialties' : 'تخصص',
    'data.birthdate': 'تاریخ تولد',
    'The': '',
    'field is required': 'الزامی است',
    'has already been taken': 'قبلا انتخاب شده است',
    'must be a number': 'باید یک شماره باشد.',
    'and': 'و',
    'more errors': 'خطای دیگر'
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
                UIkit.notification({
                    message: success_icon + response.data.messages[AppLocale],
                    status: 'success',
                    pos: 'top-center',
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

function ValidateStep(index) {
    if (index == 1) {
        let name = document.querySelector('#fullname').value;
        let phone = document.querySelector('#phone').value;
        let email = document.querySelector('#email').value;

        if (name.length < 3) {
            UIkit.notification({
                message: error_icon + 'نام و نام خانوادگی الزامی است.',
                status: 'danger',
                pos: 'bottom-right',
                timeout: 5000
            });
            showStep(index, false);
            return false;
        }

        if (phone.length !== 11) {
            UIkit.notification({
                message: error_icon + 'شماره تلفن صحیح نمی‌باشد.',
                status: 'danger',
                pos: 'bottom-right',
                timeout: 5000
            });
            showStep(index, false);
            return false;
        }

        var emailRegex = /\S+@\S+\.\S+/;
        if (!emailRegex.test(email)) {
            UIkit.notification({
                message: error_icon + 'ایمیل معتبر نیست.',
                status: 'danger',
                pos: 'bottom-right',
                timeout: 5000
            });
            showStep(index, false);
            return false;
        }   
    }

    if (index == 2) {
        let business_name = document.querySelector('#business_name').value;
        let business_number = document.querySelector('#business_number').value;
        let business_address = document.querySelector('#address').value;

        if (business_name.length < 3) {
            UIkit.notification({
                message: error_icon + 'نام کسب و کار الزامی است.',
                status: 'danger',
                pos: 'bottom-right',
                timeout: 5000
            });
            showStep(index, false);
            return false;
        }

        if (business_number.length < 10) {
            UIkit.notification({
                message: error_icon + 'شماره تماس کسب و کار الزامیست.',
                status: 'danger',
                pos: 'bottom-right',
                timeout: 5000
            });
            showStep(index, false);
            return false;
        }

        if (business_address.length < 10) {
            UIkit.notification({
                message: error_icon + 'آدرس کسب و کار الزامیست.',
                status: 'danger',
                pos: 'bottom-right',
                timeout: 5000
            });
            showStep(index, false);
            return false;
        }
    }

    if (index == 5) {
        let city = document.querySelector('#city').value;
        
        if (city == -1) {
            UIkit.notification({
                message: error_icon + 'انتخاب شهر و استان الزامی است.',
                status: 'danger',
                pos: 'bottom-right',
                timeout: 5000
            });
            showStep(index, false);
            return false;
        }
        
        showStep(index, false);
        return false;
    }

    return true;
}

// step advertisement form
function showStep(index, shouldRunValidations = true) {
    state = true;
    if (shouldRunValidations) {
        state = ValidateStep(index-1);
    }

    if (state !== false) {
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
        document.querySelector('#tab-'+index).scrollIntoView();
    }
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

function listProvinceCities(provinceSelector, citiesSelector, hasAllCities = false, hasLoader = true) {
    let citiesSelect = document.querySelector(citiesSelector);
    let citiesLoader = document.querySelector('#city_loader');
    if (hasLoader && citiesLoader !== null) {
        console.log('removing ...');
        citiesLoader.classList.remove('uk-hidden');
    }
    citiesSelect.classList.add('uk-disabled');
    let payload = {
        _token: document.querySelector('meta[name="csrf-token"]').content,
        allCities: hasAllCities,
        province: parseInt(document.querySelector(provinceSelector).value)
    };
    let headers = {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    };
    axios.post('/api/public/list_cities', payload, headers)
        .then(function (response) {
            // handle success
            if (response.data.status == 200) {
                if (response.data.hasOwnProperty('allowed') && response.data.hasOwnProperty('timestamp') && response.data.allowed && response.data.html !== null) {
                    citiesSelect.innerHTML = response.data.html;
                    citiesSelect.classList.remove('uk-disabled');
                    if (hasLoader && citiesLoader !== null) {
                        console.log('adding ...');
                        citiesLoader.classList.add('uk-hidden');
                    }
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
if (document.querySelector('#province') !== null) {
    document.querySelector('#province').onchange();
}

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

function showPackageInfo(dispatcher) {
    let packagesSelect = document.querySelector('#package');
    let package_info = packagesSelect.options[packagesSelect.selectedIndex].dataset.desc;
    let package_price = packagesSelect.options[packagesSelect.selectedIndex].dataset.price;
    let package_price_unit = packagesSelect.options[packagesSelect.selectedIndex].dataset.priceUnit;
    document.querySelector('#package-info').innerText = e2p(package_info);
    document.querySelector('#package-price').innerText = e2p(package_price);
    document.querySelector('#package-price-unit').innerText = e2p(package_price_unit);
}

function showMobileConfirmOptIn() {
    ValidateStep(5);
    let phone_number = document.querySelector('#phone').value;
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
            document.querySelector('#resend-otp').classList.toggle('uk-hidden');
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
    UIkit.modal('#phone_number_validation_modal').show();
}

function validateMobileConfirmOptInCode() {
    let phone_number = p2e(document.querySelector('#phone').value);
    let otp = p2e(document.querySelector('#otp').value);

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
                console.log('state_1');
                document.querySelector('#validate_user_phone_button').classList.add('uk-hidden');
                document.querySelector('#submitAdvertisementForm').classList.remove('uk-hidden');
                UIkit.modal('#phone_number_validation_modal').hide();
            } else {
                UIkit.notification({
                    message: error_icon + 'مشکلی پیش آمده است.',
                    status: 'warning',
                    pos: 'bottom-right',
                    timeout: 5000
                });
                console.log('state_2');
            }
        } else {
            UIkit.notification({
                message: error_icon + response.data.errors[AppLocale],
                status: 'danger',
                pos: 'bottom-right',
                timeout: 5000
            });
            console.log('state_3');
        }
        // console.log(response);
    })
    .catch(function (error) {
        // handle error
        console.log(error);
    })
    .finally(function () {
        // always executed
    });
}

function submitAdvertisementForm () {
    ValidateStep(5);

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

    // if (document.querySelector('#package').value === '0' || document.querySelector('#package').value === '') {
    //     UIkit.notification({
    //         message: error_icon + 'انتخاب پکیج الزامی است.',
    //         status: 'warning',
    //         pos: 'bottom-right',
    //         timeout: 5000
    //     });
    //     return;
    // }

    let payload = {
        fullname: document.querySelector('#fullname').value,
        phone: document.querySelector('#phone').value,
        email: document.querySelector('#email').value,
        business_name: document.querySelector('#business_name').value,
        country_level_service: document.querySelector('#country_level_service').checked,
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
        // package: document.querySelector('#package').value,
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
                    // window.location.replace('/panel/')
                    window.location.replace(response.data.redirect)
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
                message: error_icon + TranslateReqParams(error.response.data.message),
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