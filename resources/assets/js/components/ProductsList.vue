<template>
    <div class="flex flex-wrap justify-around">
        <div v-for="product in matching_products"
             :key="product.id"
             class="w-25 mh2 mb3 col-w-bg pa3">
            <a :href="`/products/${product.slug}`">
                <img :src="product.main_image.thumb"
                     :alt="product.title">
            </a>
            <p class="b mb0">{{ product.title }}</p>
            <p class="col-p strong-type mb0 mt2">{{ product.code }}</p>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['fetch-url'],

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
                if (!this.show_subcategory && !this.show_tool_groups.length) {
                    return this.products;
                }

                return this.products
                           .filter(product => this.belongsToSelectedParent(product));
            }
        },

        mounted() {
            this.fetchProducts();
            eventHub.$on('subcategory-chosen', this.showSubcategory);
            eventHub.$on('toolgroup-chosen', this.showToolGroup);
            eventHub.$on('reset-category-list', this.resetList);
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
                if (this.show_subcategory) {
                    return this.belongsToSubcategory(product) || this.belongsToToolGroup(product);
                }

                if (this.show_tool_groups.length) {
                    return this.belongsToToolGroup(product);
                }
            },

            belongsToSubcategory(product) {
                return product.parents.some(parent => parent.type === 'Subcategory' && parent.id === this.show_subcategory);
            },

            belongsToToolGroup(product) {
                return product.parents.some(parent => (parent.type === 'Tool Group') && (this.show_tool_groups.indexOf(parent.id) !== -1))
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>