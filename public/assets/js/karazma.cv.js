// variable generated in resources/views/app/private/jobseeker/cv/index.blade.php
allJobPositions = allJobPositions || [];
allSpecs = allSpecs || [];
var cvData = [];

function numberFormat(selector) {
    $(selector).on('keyup', function () {
        this.value = a2e(p2e(this.value));
        var n = parseInt($(this).val().replace(/\D/g, ''), 10);
        $(this).val(n.toLocaleString());
    });
}

let jobsalary = document.querySelector('#addjob_salary');
if (jobsalary) {
    jobsalary.addEventListener('keyup', numberFormat('#addjob_salary'));
}

function addJobHistory() {
    let job = {};
    job.job_title = document.querySelector('#addjob_title').value;
    job.job_position = document.querySelector('#addjob_position').value;
    job.job_start_date = document.querySelector('#addjob_start_date').value;
    job.job_end_date = document.querySelector('#addjob_end_date').value;
    job.job_coop_type = document.querySelector('#addjob_coop_type').value;
    job.job_salary = document.querySelector('#addjob_salary').value;
    job.job_work_time = document.querySelector('#addjob_work_time').value;
    job.job_explains = document.querySelector('#addjob_explains').value;

    let html = `<li class="job-item">
                    <a class="uk-accordion-title" href="#">` + job.job_title + ` <span class="uk-text-meta">` + job.job_start_date + `</span></a>
                    <div class="uk-accordion-content uk-padding uk-padding-remove-vertical">
                        <div class="uk-card uk-card-default uk-card-body uk-width-1-1">
                            <p>
                                <span>موقعیت شغلی: <span class="uk-margin-small-bottom uk-label uk-label-success">` + job.job_position + `</span></span>
                                <span>حقوق دریافتی: <span class="uk-margin-small-bottom uk-label uk-label-warning">` + job.job_salary + ` ت</span></span>
                                <span>نوع همکاری: <span class="uk-margin-small-bottom uk-label uk-label-primary">` + job.job_coop_type + `</span></span>
                                <span>ساعت کاری: <span class="uk-margin-small-bottom uk-label uk-label-danger">` + job.job_work_time + `</span></span>
                            </p>
                            <p>
                            <h2 class="uk-text-default"><ion-icon name="flag-outline"></ion-icon> شرح وظایف</h2>
                            <p>`
                            +
                            job.job_explains
                            +
                            `</p>
                        </div>
                    </div>
                </li>`;
    let index = document.querySelector('#job-history-items');
    index.innerHTML = html + index.innerHTML;

    UIkit.modal(document.querySelector('#modal-add-job-history')).hide();
    document.querySelector('#addJobHistoryForm').reset();

    allJobPositions.push(job);
}

function prevAdvancedSpecs() {
    let e = document.querySelector('#addspecs_query');
    let len = e.value.length;
    if (len < 3) {
        return;
    }
    axios.get('/app/api/query/specs/load', {
        params: {
            'q': e.value,
            'advanced': 1
        }
    }).then(function (response) {
       document.querySelector('#prevAdvancdeSpecsWrapper').innerHTML = response.data.html;
    })
    .catch(function (error) {
        // handle error
        // console.log(error);
    })
    .finally(function () {
        // always executed
    });
}

function addTempSpec(id, label) {
    if (document.querySelector('#tmp-spec-'+id) == null) {
        let html = `
            <div class="uk-margin tmp-specs-group uk-background-primary uk-card uk-card-default uk-card-body uk-light uk-margin-small-bottom"
            data-id='`+id+`'
            data-label='`+label+`'
            data-percentage='0'
            id="tmp-spec-` + id + `">
                <label class="uk-form-label uk-text-large">` + label + `</label>
                <span class="percentage">0 %</span>
                <input onchange='tmpSliderOnChange(this)' name="adv_specs[` + id + `]" class="uk-range" type="range" value="0" min="0" max="100" step="10" aria-label="Range">
                <div style="width: 100%; height: 10px" class="uk-background-muted uk-border-rounded">
                    <div style="width: 1%; height: 10px; transition: width 0.5s ease-in-out;" class="uk-background-secondary uk-border-rounded"></div>
                </div>
                </div>
        `;
        index = document.querySelector('#prevAdvancdeSpecsWrapperGroup');
        document.querySelector('#prevAdvancdeSpecsWrapperGroup').innerHTML = html + index.innerHTML;
        UIkit.notification({
            message: success_icon + label +' افزوده شد.',
            status: 'success',
            pos: 'bottom-right',
            timeout: 5000
        });
    } else {
        UIkit.notification({
            message: success_icon + label + ' ثبت شده است.',
            status: 'danger',
            pos: 'bottom-right',
            timeout: 5000
        });
    }
}

function tmpSliderOnChange(elem) {
    let color = '';
    elem.previousElementSibling.innerText = elem.value + "%";
    elem.parentNode.dataset.percentage = elem.value;

    if ( elem.value <= 30) {
        color = '#e84118';
    } else if (elem.value > 30 && elem.value <= 60 ) {
        color = '#fbc531';
    } else {
        color = '#4cd137';
    }


    elem.nextElementSibling.childNodes[1].style.width = elem.value + "%";
    elem.nextElementSibling.childNodes[1].style.background = color;
}

function addAdvancedSpecs() {

    saveCv(true);
}

function saveCv(reload) {
    elems = document.querySelectorAll('.tmp-specs-group');
    for (let elem of elems) {
        spec = {};
        spec.id = elem.dataset.id;
        spec.label = elem.dataset.label;
        spec.percentage = elem.dataset.percentage;

        // determine if speciality does'nt exists create one, else update index.
        let search = allSpecs.findIndex(object => object.id === spec.id);
        if (search === -1) {
            allSpecs.push(spec);
        } else {
            allSpecs[search] = spec;
        }
    }
    console.log(allSpecs);

    cvData = {
        // 'name': document.querySelector('#user-full_name').value,
        'jobs': allJobPositions,
        'specs': allSpecs,
        // 'user_specialties': document.querySelector('#user-specialties').tomselect.getValue(),
        'user_interests': document.querySelector('#user-interests').tomselect.getValue(),
        'user_languages': document.querySelector('#user-languages').tomselect.getValue(),
    };
    axios.post('/app/panel/cv', cvData)
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
                    // window.location.reload();
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
        .catch(function (error, response) {
            UIkit.notification({
                message: error_icon + 'مشکلی پیش آمده است.',
                status: 'warning',
                pos: 'bottom-right',
                timeout: 5000
            });
        })
        .finally(function () {
            // always executed
            if (reload == true) {
                window.location.reload();
            }
        });
}
