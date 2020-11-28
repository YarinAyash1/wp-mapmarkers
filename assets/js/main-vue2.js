Vue.component('mapbox-map', {
    template: '#map-component',
    mounted() {

        window.mapboxgl.accessToken = this.api_key;

        const map = new window.mapboxgl.Map({
            container: 'mapmarker',
            style: 'mapbox://styles/mapbox/dark-v9',
            center: [35.089630, 32.843860],
            zoom: 9
        });

        map.on('load', (() => {

            this.markers.forEach(function (marker) {
                var el = document.createElement('div');
                el.className = 'marker';
                marker.marker_logo ?
                    el.style.backgroundImage = 'url(' + marker.marker_logo.sizes.thumbnail + ')' :
                    el.style.background = '#fff';

                if (parseFloat(marker.map.lat) && parseFloat(marker.map.lng)) {

                    new window.mapboxgl.Marker(el)
                        .setLngLat([parseFloat(marker.map.lat), parseFloat(marker.map.lng)]).setPopup(new window.mapboxgl.Popup().setText(marker.marker_name))
                        .addTo(map);

                    document.getElementById(marker.marker_id)
                        .addEventListener('click', () => {
                            map.flyTo({
                                center: [parseFloat(marker.map.lat), parseFloat(marker.map.lng)],
                                zoom: 15
                            });
                        })
                }
            })
        }).bind(this));
    },
    props: {
        markers: Array,
        api_key: String,
    }
})


Vue.component('badge', {
    template: '#badge-component',
    props: {
        Name: String,
        Image: String,
        Types: Array
    },
})

new Vue({
    el: document.getElementById('mapmarkers'),
    data() {
        return {
            markers: []
        }
    },
    mounted() {
        fetch(`/wp-json/markers/v1/list`)
            .then((r) => r.json())
            .then((res) => this.markers = res.map(x => x));
    }
})