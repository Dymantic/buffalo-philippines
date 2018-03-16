<template>
    <div>
        <p class="f4 ttu col-p">{{ locations.length }} Store Locations</p>
        <div class="card mv3 flex justify-between items-center">
            <p>Search location by name or address:</p>
                <input type="text" v-model="query" class="w5 db h2">
        </div>
        <location-item v-for="location in matched_locations"
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
              locations: this.list || [],
              query: ''
          };
        },

        computed: {
            matched_locations() {
                if(! this.query) {
                    return this.locations;
                }

                return this.locations.filter(location => this.matchesQuery(location));
            }
        },

        methods: {
            removeLocation(id) {
                const index = this.locations.indexOf(this.locations.find(l => l.id === id));
                this.locations.splice(index, 1);
            },

            matchesQuery(location) {
                return (location.name.toLowerCase().indexOf(this.query.toLocaleLowerCase()) !== -1) || (location.address.toLowerCase().indexOf(this.query.toLowerCase()) !== -1);
            }
        }
    }
</script>