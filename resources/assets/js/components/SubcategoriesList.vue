<template>
    <div class="card mv3">
        <p class="ttu col-p f6">Subcategories</p>
        <p v-if="!subcategories.length">This category has no subcategories yet.</p>
        <div v-for="subcategory in subcategories" :key="subcategory.id">
            <a :href="`/admin/subcategories/${subcategory.id}`">{{ subcategory.title }}</a>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['fetch-url'],

        data() {
            return {
                subcategories: []
            };
        },

        mounted() {
            this.fetchSubcategories();
            eventHub.$on('created-subcategory', this.fetchSubcategories);
        },

        methods: {
            fetchSubcategories() {
                axios.get(this.fetchUrl)
                    .then(({data}) => this.subcategories = data)
                    .catch(err => console.log(err));
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>