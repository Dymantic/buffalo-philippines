<template>
    <div class="card mv3">
        <div class="flex justify-between">
            <div>
                <p class="f4 b black-70">{{ name }}</p>
                <p class="">{{ locationAttributes.address }}</p>
                <div class="flex items-center black-60">
                    <svg class="mr1" fill="#10B261" height="16" viewBox="0 0 24 24" width="16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        <path d="M0 0h24v24H0z" fill="none"/>
                    </svg>
                    {{ locationAttributes.lat }}, {{ locationAttributes.lng }}</div>
            </div>
            <div class="">

            </div>
        </div>
        <div class="flex justify-end items-center">
            <delete-modal :url="`/admin/locations/${locationAttributes.id}`"
                          :redirect="false"
                          :item-name="name"
                          @item-deleted="removeLocation"
            ></delete-modal>
            <location-form :url="`/admin/locations/${locationAttributes.id}`"
                           form-type="update"
                           :form-attributes="locationAttributes"
                           button-text="Edit"
                           @location-updated="updateLocationName"
            ></location-form>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['locationAttributes'],

        data() {
            return {
                name: this.locationAttributes.name
            };
        },

        methods: {
            updateLocationName({name}) {
                this.name = name;
            },

            removeLocation() {
                this.$emit('remove-location', this.locationAttributes.id);
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">
</style>