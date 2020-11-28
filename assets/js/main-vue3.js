const MapMarkers = {
    name: "markersApp",
    data() {
        return {
            markers: []
        }
    },
    methods: {
        async getMarkers(){
            const res = await fetch(`/wp-json/markers/v1/list`)
            this.markers = await res.json();
        }
    },
    mounted() {
        this.getMarkers()
    }
}

const app = Vue.createApp(MapMarkers)

app.component('badge', {
    name: "Badge",
    props: ['marker'],
    template: '#badge-component',
})
app.component('mapbox-map', {
    name: "Map",
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
                const element = document.createElement('div');
                element.className = 'marker';
                marker.marker_logo ?
                    element.style.backgroundImage = `url(${marker.marker_logo.sizes.thumbnail})` :
                    element.style.background = '#fff';

                if (parseFloat(marker.map.lat) && parseFloat(marker.map.lng)) {

                    new window.mapboxgl.Marker(element)
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
app.mount('#mapmarkers')