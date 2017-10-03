<template>
    <div>
        <div class="card mw8 mt4">
            <p>Search for an establishment</p>
            <div class="relative">
                <input type="text"
                       class="absolute w-100 mw6 pl2"
                       id="address-input">
                <div id="map-box"
                     class="relative"
                     style="height: 400px;"
                >
                </div>
            </div>
        </div>
        <div class="card mt4">
            <p class="f6 ttu col-p mb0">Name</p>
            <input type="text"
                   v-model="name"
                   class="w-100 mw6">
            <p class="f6 ttu col-p mt4 mb0">Address</p>
            <p v-show="name"
               class="mt2">{{ formatted_address }}</p>
            <p v-show="!name"
               class="mt2 black-40">Find a location using the map above.</p>
            <p class="f6 ttu col-p mt4">Coordinates</p>
            <div class="flex">
                <div class="mr3">
                    <span class="f6 ttu col-p">Latitude:</span>
                    <input type="text"
                           v-model="lat">
                </div>
                <div>
                    <span class="f6 ttu col-p">Longitude:</span>
                    <input type="text"
                           v-model="lng">
                </div>
            </div>
            <div class="flex justify-end">
                <div class="btn" @click="saveLocation">Save</div>
            </div>
        </div>

    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                autocomplete: null,
                map: null,
                marker: null,
                name: '',
                lat: null,
                lng: null,
                default_center: {lat: 14.5964957, lng: 120.9445403},
                default_zoom: 6,
                formatted_address: ''
            }
        },

        mounted() {
            eventHub.$on('maps-loaded', () => this.init());
        },

        methods: {

            init() {
                console.log('initing');
                this.map = new google.maps.Map(document.getElementById('map-box'), {
                    zoom: this.default_zoom,
                    center: this.default_center,
                    mapTypeControl: false,
                    panControl: false,
                    zoomControl: false,
                    streetViewControl: false
                });

                this.autocomplete = new google.maps.places.Autocomplete(
                    (document.getElementById('address-input')), {
                        types: ['establishment']
                    });

                this.autocomplete.addListener('place_changed', this.onPlaceChanged);
            },

            onPlaceChanged() {
                console.log('change in the house of flies');
                const place = this.autocomplete.getPlace();
                if (place.geometry) {
                    this.map.panTo(place.geometry.location);
                    this.map.setZoom(15);
                } else {
                    document.getElementById('address-input').placeholder = 'Enter a city';
                }
                this.marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: this.map
                });
                console.log(place);
                this.setLocationData(place);
            },

            setLocationData(place) {
                this.formatted_address = place.formatted_address;
                this.lat = place.geometry.location.lat();
                this.lng = place.geometry.location.lng();
                this.name = place.name;
            },

            saveLocation() {
                axios.post('/admin/locations', this.getLocationData())
                     .then(({data}) => window.location = data.redirect_url)
                     .catch(err => this.handleErrors(err.response));
            },

            getLocationData() {
                return {
                    name: this.name,
                    address: this.formatted_address,
                    lat: this.lat,
                    lng: this.lng
                };
            },

            handleErrors(response) {

                if(response.status === 422) {
                    return this.showValidationError(response.data.errors);
                }

                eventHub.$emit('user-alert', {
                    type: 'error',
                    title: 'Oops, an error occurred',
                    text: 'Please refresh and try again later.'
                });
            },

            showValidationError(errors) {
                eventHub.$emit('user-alert', {
                    type: 'error',
                    title: 'Invalid Data',
                    text: this.getFirstError(errors)
                });
            },

            getFirstError(errors) {
                return errors[Object.keys(errors)[0]];
            }


        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">
    #address-input {
        top: 20px;
        left: 20px;
        height: 40px;
        z-index: 999;
    }

    input[type=text] {
        height: 32px;
        padding-left: 5px;
        border: none;
        border-bottom: 1px solid;
    }
</style>