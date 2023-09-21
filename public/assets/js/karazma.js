const UIkit = globalUikit;
if (document.querySelector('#provinces')) {
    document.querySelector('#provinces').childNodes.forEach(node => {
        if (node.dataset) {
            node.setAttribute('uk-tooltip', node.dataset.title);
            node.addEventListener('click', () => {
                document.querySelector('#map-box-data-title').innerText = 'آگهی‌های ' + node.dataset.title;
                getAdsByProvince(node.dataset.title, true);
            });
        }
    });
}

function ToggleMobileNav() {
    UIkit.modal(document.querySelector('#mobile-menu-modal')).show();

}

function simpleNotif(message, pos = 'bottom-right') {
    UIkit.notification({message: message, pos: pos})
}

function followEmployee(dispatcher, id) {
    dispatcher.name = dispatcher.name.replace('-outline', '');
}

function bookmarkAd(dispatcher, id) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", "/app/api/markable/Advertisement/bookmark/" + id, false); // false for synchronous request
    xmlHttp.send();
    let res = JSON.parse(xmlHttp.responseText);
    if (res.code == 200) {
        if (dispatcher.name.search('-outline') === -1) {
            dispatcher.name = dispatcher.name + '-outline';
        } else {
            dispatcher.name = dispatcher.name.replace('-outline', '');
        }
    }

}

function getAdsByProvince(province, injectHtml) {
    document.querySelector('#map-box-data-wrapper').innerHTML = '<div uk-spinner></div>';
    var xmlHttp = new XMLHttpRequest();
    // xmlHttp.open("GET", "/app/api/advertisements"+'?json&query&limit=10&province='+province, false); // false for synchronous request
    xmlHttp.open("GET", "/app/api/advertisements" + '?html&query&limit=4&province=' + province, false); // false for synchronous request
    xmlHttp.send();

    document.querySelector('#map-box-data-alert p').innerText = 'آخرین‌های ' + province;
    document.querySelector('#map-box-data-alert').classList.add('uk-hidden');
    if (injectHtml == true) {
        let res = xmlHttp.responseText;
        document.querySelector('#map-box-data-wrapper').innerHTML = res;
    } else {
        let res = JSON.parse(xmlHttp.responseText);
        res.forEach(item => {
            let elem = document.createElement('p');
            elem.setAttribute('class', 'uk-text-title');
            elem.innerText = item.adtitle;
            elem.addEventListener('click', () => {
                prev(adid)
            });

            let adid = item.id;
            let meta = document.createElement('span');
            meta.innerText = item.company.companyname;
            meta.setAttribute('class', 'uk-label uk-label-success uk-margin-small-right');
            elem.appendChild(meta);

            document.querySelector('#map-box-data-wrapper').appendChild(elem);
        });
    }
}

function searchJobs(dispatcher) {
    let province = document.querySelector('#search_province').value;
    let search_job_category = document.querySelector('#search_job_category').value;
    let query = document.querySelector('#search_query').value;

    let remote_tag = document.querySelector('#is_remote');
    let remote = (remote_tag == null) ? 0 : Number(remote_tag.checked);

    window.location.href = '/search?query=' + query + '&province=' + province + '&jobfield=' + search_job_category + '&remote=' + remote + '&paginate=50';
}

function prev(id) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", "/app/api/employment/preview/" + id, false); // false for synchronous request
    xmlHttp.send(null);
    let res = JSON.parse(xmlHttp.responseText);

    document.querySelector('#ad_identifier').value = res.identifier;
    document.querySelector('#prevmodaltitle').innerText = res.title;
    document.querySelector('#prevmodallogo').src = res.company.logo;
    document.querySelector('#prevmodalconame').innerText = res.company.name;
    document.querySelector('#prevmodaldesc').innerText = res.company.desc || 'ثبت نشده است.';
    document.querySelector('#prevmodalrequirements').innerHTML = res.requirements;
    document.querySelector('#prevmodaljobdesc').innerHTML = res.description;
    document.querySelector('#prevmodalsalary').innerHTML = res.salary;

    // session_authorized & authorized_to_apply will render in head tag on all pages
    if (session_authorized && authorized_to_apply) {
        if (res.authorized_to_apply) {
            document.querySelector('#send_cv_btn').innerText = 'ارسال رزومه';
            document.querySelector('#send_cv_btn').classList.remove('uk-disabled');
        } else {
            document.querySelector('#send_cv_btn').innerText = 'قبلا رزومه فرستاده‌اید.';
            document.querySelector('#send_cv_btn').classList.add('uk-disabled');
        }
    } else {
        document.querySelector('#send_cv_btn').innerText = 'وارد حساب کاربری شوید.';
        document.querySelector('#send_cv_btn').classList.add('uk-disabled');
    }

    UIkit.modal(document.querySelector('#prevmodal')).show();
}

function sendcv() {
    let identifier = document.querySelector('#ad_identifier').value;
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", "/app/api/employment/sendcv?identifier=" + identifier, false); // false for synchronous request
    xmlHttp.send();
    let res = JSON.parse(xmlHttp.responseText);
    UIkit.modal(document.querySelector('#prevmodal')).hide();
    UIkit.notification({
        message: res.message,
        status: 'success',
        pos: 'top-center',
    });
}
