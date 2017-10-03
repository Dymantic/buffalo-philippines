<template>
    <div>
        <location-item v-for="location in locations"
                       :key="location.id"
                       @remove-location="removeLocation"
                       :location-attributes="location"
        ></location-item>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['list'],

        data() {
          return {
              locations: this.list || []
          };
        },

        methods: {
            removeLocation(id) {
                const index = this.locations.indexOf(this.locations.find(l => l.id === id));
                this.locations.splice(index, 1);
            }
        }
    }
</script>