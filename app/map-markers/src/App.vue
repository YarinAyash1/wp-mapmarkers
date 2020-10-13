<!-- Template -->
<template>
    <div id="app">
        <div class="map-marker">
            <div class="side-map">
                <div class="badge-container">
                    <div v-for="(badge, key) in markers" :key="key">
                        <Badge :Name="badge.marker_name" :id="badge.marker_id" :Types="badge.marker_types" :Image="badge.marker_logo ? badge.marker_logo.sizes.thumbnail : false" />
                    </div>
                </div>
            </div>
            <div class="map">
                <Map v-if="markers.length > 0" :markers="markers" />
            </div>
        </div>
    </div>
</template>
<!-- Script -->
<script>
  import Badge from './components/Badge.vue'
  import Map from './components/Map.vue'
  import config from './config'

  export default {
    name: 'app',
    data(){
      return {
        markers: []
      }
    },
    components: {
      Badge,
      Map
    },
    mounted(){
      if(config.isDev){
        fetch(`${config.siteurl}/wp-json/markers/v1/list`)
        .then((r) => r.json())
        .then((res) => this.markers = res.map(x => x));
      }
      else{
        fetch(`/wp-json/markers/v1/list`)
        .then((r) => r.json())
        .then((res) => this.markers = res.map(x => x));
      }
    }
  }
</script>
<!-- Style -->
<style scoped>
  @import url('https://fonts.googleapis.com/css?family=Heebo:400,500&display=swap');
  .map-marker{
      display: grid;
      grid-template-columns: 0.25fr 1fr;
      width: 100%;
      direction: rtl;
      font-family: Heebo;
  }
  .mapboxgl-canvas{
    width: 100%;
  }
  .side-map{
      margin-left: 10px;
      max-height: 495px;
      padding: 3px 5px;
      overflow-y: scroll;
      position: relative;
  }
</style>