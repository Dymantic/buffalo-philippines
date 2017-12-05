<template>
    <div class="flex flex-wrap justify-around">
        <div v-for="product in matching_products"
             :key="product.id"
             class="w-20 mh2 mb3 col-w-bg pa3">
            <a :href="`/products/${product.slug}`">
                <img :src="product.main_image.thumb"
                     :alt="product.title">
            </a>
            <p class="b mb0">{{ product.title }}</p>
            <p class="col-p mb0 mt2">{{ product.code }}</p>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['fetch-url', 'parent-type', 'subcategory-id', 'tool-groups'],

        data() {
            return {
                products: [],
                subcategory_type: '',
                subcategory_id: null,
                show_subcategory: null,
                show_tool_groups: []
            };
        },

        computed: {
            matching_products() {
                if (this.parentType === 'Category') {
                    return this.products;
                }

                return this.products
                           .filter(product => this.belongsToSelectedParent(product));
            }
        },

        mounted() {
            this.fetchProducts();
        },

        methods: {

            fetchProducts() {
                axios.get(this.fetchUrl)
                     .then(({data}) => this.products = data)
                     .catch(err => console.log(err));
            },

            resetList() {
                this.show_subcategory = null;
                this.show_tool_groups = [];
            },

            showSubcategory({id, tool_groups}) {
                this.show_subcategory = id;
                this.show_tool_groups = tool_groups || [];
            },

            showToolGroup({id}) {
                this.show_tool_groups = [id];
                this.show_subcategory = null;
            },

            belongsToSelectedParent(product) {
                if (this.parentType === 'Subcategory') {
                    return this.belongsToSubcategory(product) || this.belongsToToolGroup(product);
                }

                if (this.parentType === 'Tool Group') {
                    return this.belongsToToolGroup(product);
                }
            },

            belongsToSubcategory(product) {
                return product.parents.some(parent => parent.type === 'Subcategory' && parent.id === this.subcategoryId);
            },

            belongsToToolGroup(product) {
                return product.parents.some(parent => (parent.type === 'Tool Group') && (this.toolGroups.indexOf(parent.id) !== -1))
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>