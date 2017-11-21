<template>
    <div>
        <div class="relative">
            <div class="w-100 map"
                 ref="mapbox">

            </div>
            <div class="absolute pa3 col-w-bg location-card"
                 :class="{'highlighted': picked_location.id}">
                <p>{{ picked_location.name }}</p>
                <p>{{ picked_location.address }}</p>
                <div @click="resetMap"
                     class="f1 ma0 absolute top-0 right-1">&times;
                </div>
            </div>
        </div>
        <section>
            <p class="f2">You can find our products at these locations</p>
            <div v-for="place in store_locations"
                 :key="place.id"
                 class="ma1 pa3 col-w-bg">
                <p>{{ place.name }}</p>
                <p class="flex items-center">
                    <span class="col-p mr2">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             height="16px"
                             viewBox="0 0 32.13 50.31">
                            <path class="cls-1"
                                  d="M24.84,0H7.3A7.3,7.3,0,0,0,0,7.3V29.58a7.3,7.3,0,0,0,1.59,4.55l11.95,15a3.23,3.23,0,0,0,5.05,0l11.95-15a7.3,7.3,0,0,0,1.59-4.55V7.3A7.3,7.3,0,0,0,24.84,0ZM23.6,20A4.07,4.07,0,0,1,19.53,24H12.6A4.07,4.07,0,0,1,8.53,20V13A4.07,4.07,0,0,1,12.6,9h6.93A4.07,4.07,0,0,1,23.6,13Z"></path>
                        </svg>
                    </span>
                    {{ place.address }}
                </p>
            </div>
        </section>

    </div>
</template>

<script type="text/babel">

    import "js-marker-clusterer";

    export default {

        props: ['locations'],

        data() {
            return {
                map: null,
                default_center: {lat: 12.5964957, lng: 120.9445403},
                default_zoom: 6,
                store_locations: [],
                picked_location: {id: null, name: '', address: ''}
            };
        },

        mounted() {
            eventHub.$on('maps-loaded', this.init);
        },

        methods: {
            init() {
                this.map = new google.maps.Map(this.$refs.mapbox, {
                    zoom: this.default_zoom,
                    center: this.default_center,
                    mapTypeControl: false,
                    panControl: false,
                    zoomControl: false,
                    streetViewControl: false
                });

                this.store_locations = this.locations.map(location => ({
                    id: location.id,
                    latLng: {lat: location.lat, lng: location.lng},
                    name: location.name,
                    address: location.address,
                    marker: new google.maps.Marker({
                        position: {lat: location.lat, lng: location.lng},
                        map: this.map,
                        animation: google.maps.Animation.DROP,
                        icon: '/images/location_icon.svg'
                    })
                }));

                this.store_locations.forEach(location => {
                    location.marker.addListener('click', () => this.highLightLocation(location));
                });

                let clusterer = new MarkerClusterer(this.map, this.store_locations.map(loc => loc.marker), {
                    imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
                    gridSize: 20
                });
            },

            showPlaceOnMap(place) {

            },

            highLightLocation(location) {
                this.map.setZoom(13);
                this.map.panTo(location.latLng);
                this.picked_location = location;
            },

            resetMap() {
                this.map.panTo(this.default_center);
                this.map.setZoom(this.default_zoom);
                this.picked_location = {id: null, name: '', address: ''}
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

    .map {
        min-height: 500px;
    }

    .location-card {
        transition: .3s;
        transform: translate3d(0, 0, 0);
        top: 20px;
        right: 20px;
        transform-origin: right top;
        transform: scale(0);
    }

    .highlighted {
        transform: scale(1);

        p {
            font-weight: 700;
        }
    }
</style>