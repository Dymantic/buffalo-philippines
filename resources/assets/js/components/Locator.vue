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
                     class="f1 ma0 absolute top-0 right-1 cursor-def">&times;
                </div>
            </div>
        </div>
        <div class="tc pv5">
            <button class="ff-sub-headline pv2 ph3 col-w col-d-bg br2 bn"
                  @click="findNearestLocation"
                  :disabled="!can_get_location"
            >
                {{ location_button_text }}
            </button>
            <p class="ff-fine-body tc">{{ location_info }}</p>
        </div>
        <section class="mv5 mw8 center-ns mh3">
            <p class="ff-title">You can find our products at these locations</p>
            <div v-for="place in store_locations"
                 :key="place.id"
                 class="mv1 pa3 col-w-bg relative">
                <p class="ff-title">{{ place.name }}</p>
                <p class="flex items-center w-80">
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
                <span class="absolute col-p ba cursor-def ff-fine-body pa2 bottom-1 right-1" @click="highLightLocation(place)">See on map</span>
            </div>
        </section>

    </div>
</template>

<script type="text/babel">

    import "js-marker-clusterer";
    import position from "./position";
    import geolib from "geolib";
    import jump from "jump.js"

    export default {

        props: ['locations'],

        data() {
            return {
                map: null,
                default_center: {lat: 12.5964957, lng: 120.9445403},
                default_zoom: 6,
                store_locations: [],
                picked_location: {id: null, name: '', address: ''},
                user_location: null,
                awaiting_permission: false,
                location_permission: 'unknown',
                location_unavailable: false,
                waiting_on_location: false,
                nearest_store: null
            };
        },

        computed: {
            location_button_text() {
                if(this.waiting_on_location && !this.awaiting_permission) {
                    return 'Waiting for location';
                }

                if(this.user_location && this.store_locations.length) {
                    return 'See your nearest location';
                }

                if (this.awaiting_permission) {
                    return 'Waiting for permission';
                }

                if (this.location_unavailable) {
                    return 'Location unavailable';
                }

                return 'Find your nearest store';
            },

            can_get_location() {
                return !this.location_unavailable && !this.waiting_on_location;
            },

            location_info() {
                if(this.user_location && this.nearest_store) {
                    const distance = geolib.getDistance(
                        {latitude: this.user_location.latitude, longitude: this.user_location.longitude},
                        {latitude: this.nearest_store.latLng.lat, longitude: this.nearest_store.latLng.lng}
                    ) / 1000;
                    return `Your nearest store is approx. ${distance.toFixed(1)}km away`;
                }

                if(this.location_unavailable) {
                    return 'Unfortunately we cannot access your location';
                }

                if(this.awaiting_permission || this.waiting_on_location) {
                    return 'Waiting for location data. Please be patient';
                }

                return 'Allow us to see your location and we can help you find your nearest Buffalo dealer.';
            }
        },

        watch: {
            location_permission(new_position) {
                switch (new_position) {
                    case 'granted':
                        this.getUserLocation();
                        break;
                    case 'denied':
                        this.location_unavailable = true;
                        break;
                    default:
                        return;
                }
            }
        },

        mounted() {
            eventHub.$on('maps-loaded', this.init);
            this.getLocationPermission();
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
                        icon: 'images/location_icon.svg'
                    })
                }));

                this.store_locations.forEach(location => {
                    location.marker.addListener('click', () => this.highLightLocation(location));
                });

                let clusterer = new MarkerClusterer(this.map, this.store_locations.map(loc => loc.marker), {
                    imagePath: '/images/map_cluster',
                    imageExtension: 'svg',
                    gridSize: 20
                });
            },

            showPlaceOnMap(place) {

            },

            highLightLocation(location) {
                this.map.setZoom(13);
                this.map.panTo(location.latLng);
                this.picked_location = location;
                jump('.map', {offset: -100});
            },

            resetMap() {
                this.map.panTo(this.default_center);
                this.map.setZoom(this.default_zoom);
                this.picked_location = {id: null, name: '', address: ''}
            },

            findNearestLocation() {
                console.log('req');
                if (!this.user_location) {
                    return this.getUserLocation().then(() => this.showNearestStore());
                }

                this.showNearestStore();
            },

            askForUserLocation() {
                this.awaiting_permission = true;
                this.getUserLocation();
            },

            getUserLocation() {
                this.waiting_on_location = true;

                position.watchCurrent(
                    (pos) => {console.log('updated loc'); this.user_location = pos},
                    (message) => eventHub.$emit('user-error', message)
                );

                return new Promise((resolve, reject) => {
                    position.getCurrent()
                            .then((position) => {
                                this.user_location = position;
                                this.awaiting_permission = false;
                                this.waiting_on_location = false;
                                this.findNearestStore();
                                resolve();
                            })
                            .catch(message => {
                                eventHub.$emit('user-error', message);
                                this.location_unavailable = true;
                                this.awaiting_permission = false;
                                this.waiting_on_location = false;

                                reject('Failed to get location');
                            });
                });



            },

            getLocationPermission() {
                if (!window.navigator.permissions || !window.navigator.permissions.query) {
                    return;
                }

                window.navigator.permissions.query({name: 'geolocation'})
                      .then(permission => this.location_permission = permission.state)
                      .catch(() => {});
            },

            findNearestStore() {
                const stores = this.store_locations.map(store => ({
                    store: store,
                    distance: geolib.getDistance({latitude: store.latLng.lat, longitude: store.latLng.lng},
                        {latitude: this.user_location.latitude, longitude: this.user_location.longitude})

                })).sort((a, b) => a.distance - b.distance);

                if (stores.length) {
                    this.nearest_store = stores[0].store;
                }
            },

            showNearestStore() {
                console.log('clicking');
                this.highLightLocation(this.nearest_store);
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

    button[disabled] {
        opacity: .5;
    }
</style>