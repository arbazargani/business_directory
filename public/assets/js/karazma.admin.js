function UpdateApplyRequest(action, id) {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var data = new FormData();
    data.append('X-CSRF-Token', csrf);

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", "/app/employer/advertisements/applies/"+ action +"/" + id, false); // false for synchronous request
    xmlHttp.send(data);

    let res = JSON.parse(xmlHttp.responseText);

    if (res.hasOwnProperty('code')) {
        window.location.reload();
    } else {
        document.querySelector('#send_cv_btn').innerText = 'قبلا رزومه فرستاده‌اید.';
        document.querySelector('#send_cv_btn').classList.add('uk-disabled');
    }
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
