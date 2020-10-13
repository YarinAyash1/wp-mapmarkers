<!-- Template -->
<template>
  <div>
      <div id='map' class='map'> </div>
  </div>
</template>
<!-- Script -->
<script>
  export default {
      name: 'Map',
      mounted() {

          window.mapboxgl.accessToken = "pk.eyJ1Ijoic25pcGNhcnQiLCJhIjoiY2p0OTB5d2l5MDQzbjQzbzhxeTJvbGcxZyJ9.R0dhrDX81Ufn31cZkRDC6Q";

          const map = new window.mapboxgl.Map({
              container: 'map',
              style: 'mapbox://styles/mapbox/dark-v9',
              center: [35.089630, 32.843860],
              zoom: 9
          });

          map.on('load', (() => {

              this.markers.forEach(function(marker) {
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
          markers: Array
      }
  }
</script>
<!-- Style -->
<style>
  .marker {
    border-radius: 50%; 
        background-size: cover; 
      border: 8px solid #000;
      width: 30px;
      height: 30px;
      cursor: pointer;

  }
  .mapboxgl-popup-content{
      border-radius: 5px;
      background-color: #ffffff !important;
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1);
      padding: 10px;
      text-align: center;
  }
  .marker .marker-name{
    width: 100px;
    height: 10px;
  }
  .marker::after {
      position: absolute;
      content: '';
      width: 0px;
      height: 0px;
      bottom: -37px;
      left: -1px;
      border: 16px solid transparent;
      border-top: 21px solid #000;
  }
  .map { 
      height: 500px;
      border-radius: 7px;
  }
</style>
