<template>
    <span>
        <button class="btn" @click="showModal = true">Add Manually</button>
        <modal :show="showModal">
            <div slot="header"></div>
            <div slot="body">
                <h4>Enter location details.</h4>
                <p>You will be able to preview the location on the map before you save, but please ensure your info is correct.</p>
                <form @submit.prevent="useLocation">
                    <div class="mv3">
                        <label class="f6 ttu mb2"
                               for="name">Name of store:</label>
                        <input type="text"
                               name="name"
                               v-model="name"
                               class="w-100 pl2 db h2"
                               id="name">
                    </div>
                    <div class="mv3">
                        <label class="f6 ttu mb2"
                               for="address">Address:</label>
                        <input type="text"
                               name="address"
                               v-model="address"
                               class="w-100 pl2 db h2"
                               id="address">
                    </div>
                    <div class="mv4">
                        <p>Please make sure your latitude and longitude values have at least four numbers after the decimal point. Eg. 66.1234</p>
                        <div class="flex justify-between">
                          <div class="mv3">
                            <label class="f6 ttu mb2"
                                   for="latitude">Latitude:</label>
                            <input type="number"
                                   step="0.0001"
                                   min="-90.0000"
                                   max="90.0000"
                                   name="latitude"
                                   v-model="latitude"
                                   class="w-80 pl2 db h2"
                                   id="latitude">
                            </div>
                            <div class="mv3">
                                <label class="f6 ttu mb2"
                                       for="longitude">Longitude:</label>
                                <input type="number"
                                       step="0.0001"
                                       min="-180.0000"
                                       max="180.0000"
                                       name="longitude"
                                       v-model="longitude"
                                       class="w-80 pl2 db h2"
                                       id="longitude">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="btn btn-grey" @click="showModal = false">Cancel</button>
                        <button type="submit" class="btn">Okay</button>
                    </div>
                </form>
            </div>
            <div slot="footer"></div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {

        data() {
            return {
                showModal: false,
                name: '',
                latitude: 0,
                longitude: 0,
                address: ''
            };
        },

        methods: {
            useLocation() {
                if(this.name === '') {
                    return eventHub.$emit('user-error', 'The store name is required.');
                }

                if(this.address === '') {
                    return eventHub.$emit('user-error', 'The store address is required.');
                }

                if(this.countDecimals(this.latitude) < 4 || this.countDecimals(this.longitude) < 4) {
                    return eventHub.$emit('user-error', 'Please make sure the latitude and longitude have at least four decimal places: e.g. 88.1234');
                }

                this.$emit('location-entered', {
                    name: this.name,
                    formatted_address: this.address,
                    geometry: {
                        location: new google.maps.LatLng(this.latitude, this.longitude)
                    }
                });

                this.showModal = false;
                this.resetForm();
            },

            countDecimals(value) {
                if(Math.floor(value) === value) return 0;
                return value.toString().split(".")[1].length || 0;
            },

            resetForm() {
                this.name = '';
                this.address = '';
                this.latitude = 0;
                this.longitude = 0;
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>