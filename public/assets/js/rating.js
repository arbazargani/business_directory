const stars = document.querySelectorAll('.rating-star');
function rateAdvertisement(dispatcher) {
    let rate_value = dispatcher.dataset.value;
    let ad_id = document.querySelector('#ad_id').value;
    stars.forEach(e => {
            if (e.dataset.value <= rate_value) {
                e.style.color = 'var(--theme-action-color)';
                e.name = 'star';
            }
    });
    axios.post('/api/public/submit_rating', {
        ad_id: ad_id,
        rate: rate_value,
    })
    .then(function (response) {
        // handle success
        if (response.data.status == 200) {
            document.querySelector('#ad_rating_preview').innerText = response.data.rate;
            document.querySelector('#ad_rating_preview').classList.remove('uk-hidden');
            document.querySelectorAll('.rating-star').forEach(e => {
                e.remove();
            });
            document.querySelector('#rating-container').innerHTML += '<span class="uk-text-bold">.امتیاز ثبت شد</span>';
            localStorage.setItem("ad_"+ad_id+"_rated", true);
            UIkit.notification({
                message: response.data.messages[AppLocale],
                status: 'success',
                pos: 'top-center',
                timeout: 5000
            });
        } else {
            UIkit.notification({
                message: response.data.errors[AppLocale],
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

document.querySelectorAll('.rating-star').forEach(dispatcher => {
    dispatcher.addEventListener('mouseover', (e) => {
        let rate_value = dispatcher.dataset.value;
        stars.forEach((e) => {
            if (e.dataset.value <= rate_value) {
                e.style.color = 'var(--theme-action-color)';
                e.name = 'star';
            }
        });
    });
});

document.querySelectorAll('.rating-star').forEach(dispatcher => {
    dispatcher.addEventListener('mouseout', (e) => {
        let rate_value = dispatcher.dataset.value;
        stars.forEach((e) => {
            e.style.color = '';
            e.name = 'star-outline';
        });
    });
});


let ad_id = document.querySelector('#ad_id').value;
if (localStorage.getItem("ad_"+ad_id+"_rated") !== null && localStorage.getItem("ad_"+ad_id+"_rated") === 'true') {

    document.querySelectorAll('.rating-star').forEach(e => {
        e.remove();
    });

    document.querySelector('#rating-container').innerHTML += '<span class="uk-text-bold">.پیش از این امتیاز داده‌اید</span>';

}
