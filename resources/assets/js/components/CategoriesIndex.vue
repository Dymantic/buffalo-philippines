<template>
    <div>
        <category-card v-for="category in categories"
                       :key="category.id"
                       :item-attributes="category"
        >
        </category-card>
    </div>
</template>

<script type="text/babel">
    export default {

        data() {
            return {
                categories: []
            };
        },

        mounted() {
            this.fetchCategories();
            eventHub.$on('created-category', this.fetchCategories);
        },

        methods: {
            fetchCategories() {
                axios.get('/admin/services/categories')
                     .then(({data}) => this.categories = data)
                     .catch(err => eventHub.$emit('user-alert', {
                         type: 'error',
                         title: 'Error!',
                         text: 'Unable to fetch categories'
                     }))
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>