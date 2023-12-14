// ---------------------------------------
// neshan map script
// @dev Alireza Bazargani , ALireza Saeedi
// @mail arbazargani1998@gmail.com
// ---------------------------------------

var submissions = [
    {
        'title': 'روزنامه صمت',
        'cordinates': [35.72543699999999, 51.41672369999999],
    },
    {
        'title': 'بیمارستان تهران کلینیک',
        'cordinates': [35.72579050504679, 51.41847019306144],
    },
    {
        'title': 'رستوران منصور',
        'cordinates': [35.724849, 51.414836],
    }
];
var baseCordinates = [35.699739, 51.338097];
var baseZoom = 14;
var markersBag = [];

var map = new L.Map('map', {
    key: 'web.4bb42e651eb7471299a5429a336ef866',
    maptype: 'standard-day',
    poi: true,
    traffic: true,
    center: baseCordinates,
    zoom: 14
}).invalidateSize(true);
map.on('click', handleMapClick);

function addMarker(e) {
    // remove previous markers
    markersBag.forEach(m => {
        m.remove();
    })

    // init new marker & add to markersBag array
    var marker = new L.marker(e.latlng).addTo(map);
    markersBag.push(marker);
    console.log('maker injected on coordinates ' + e.latlng);
    addCoordinatesToForm(e.latlng);
}

function addCoordinatesToForm(latlng) {

    let lat = document.querySelector('#lat');
    let lng = document.querySelector('#lng');

    lat.value = (latlng.lat == undefined) ? null : latlng.lat;
    lng.value = (latlng.lng == undefined) ? null : latlng.lng;
}

function handleMapClick(e) {
    addMarker(e);
}

function mapResetView() {
    map.setView(baseCordinates, baseZoom);
}

function changeView(cordinates = baseCordinates, zoom = baseZoom, ShouldAddMarker = true) {
    map.setView(cordinates, zoom);
    if (ShouldAddMarker) {
        addMarker({latlng: cordinates});
    }
}

function searchApi(navigate_to_first_index = false) {
    let query = document.querySelector('#query').value;
    if (query.length === 0 || query.length < 3) {
        return;
    }

    let lat = baseCordinates[0];
    let lng = baseCordinates[1];
    let should_navigate_to_first_index = navigate_to_first_index;

    // const axios = require('axios');
    let config = {
        method: 'get',
        maxBodyLength: Infinity,
        url: 'https://api.neshan.org/v1/search?term=' + query + '&lat=' + lat + '&lng=' + lng,
        headers: {
            'Api-Key': 'service.4cc968a40bb94cedab2d812152dc8fd0'
        }
    };

    axios.request(config)
        .then((response) => {
            document.querySelector('#results').innerHTML = '';
            let res = response.data.items;
            res.forEach(item => {
                if (item.type == 'city_landmark'
                    || item.type == 'state_landmark'
                    || item.type == 'village_landmark'
                    || item.type == 'town_landmark'
                    || item.type == 'suburb_landmark'
                    || item.type == 'neighborhood_landmark'
                ) {
                    let title = item.title;
                    let address = item.address;
                    let yx = "[" + item.location.y + "," + item.location.x + "]";
                    if (should_navigate_to_first_index) {
                        changeView([item.location.y, item.location.x], 13);
                        should_navigate_to_first_index = false;
                    }
                    document.querySelector('#results').innerHTML += `
                    <div class="uk-margin-small-bottom">
                    <a class="uk-link-reset" style="color: #d9d9d9 !important; font-weight: 900" onClick="changeView(${yx}, 13)">
                        ${address}
                        <br />
                        <span class="uk-text-meta">${title}</span>
                    </a>
                    </div>`;
                }
            });
        })
        .catch((error) => {
            console.log(error);
        });

}

// submissions.forEach(s => {
//     var pop = L.popup()
//     .setLatLng(s.cordinates)
//     .setContent(s.title)
//     .addTo(map);
// });

function mapInvalidateFunction() {
    window.dispatchEvent(new Event('resize'));
    var executed = false;
    if (!executed) {
        executed = true;
        map.invalidateSize(true);
    }
}

changeView(baseCordinates);
// document.addEventListener('DOMContentLoaded', () => {
//     mapInvalidateFunction();
// });
