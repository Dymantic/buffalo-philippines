<template>
    <div>
        <div class="flex flex-wrap justify-around">
            <div v-for="product in page_of_products"
                 :key="product.id"
                 class="w-40 w-20-ns mh2 mb3 col-w-bg pa3">
                <a :href="productLink(product)">
                    <img :src="product.main_image.thumb"
                         :alt="product.title">
                </a>
                <a :href="productLink(product)"
                   class="link">
                    <p class="ff-title hv-col-p col-d mb0">{{ product.title }}</p>
                    <p class="ff-fine-body col-mg hv-col-d mb0 mt2">{{ product.code }}</p>
                </a>
            </div>
        </div>
        <div v-show="number_of_pages > 1" class="pa3 col-lg-bg ma4">
            <p class="ff-title">Pages</p>
            <div class="flex flex-wrap">
                <div v-for="page_number in number_of_pages"
                     @click="page = (page_number - 1)"
                     class="mh2 mb3 b cursor-point hv-col-p"
                     :class="{'col-p': page_number === (page + 1)}"
                     :disabled="page_number === (page + 1)"
                >
                    {{ page_number }}
                </div>
            </div>
        </div>

    </div>

</template>

<script type="text/babel">

    import {chunk} from "lodash";

    export default {

        props: ['fetch-url', 'parent-type', 'subcategory-id', 'tool-groups', 'link-to-admin'],

        data() {
            return {
                products: [],
                subcategory_type: '',
                subcategory_id: null,
                show_subcategory: null,
                show_tool_groups: [],
                page: 0,
                page_size: 15
            };
        },

        computed: {



            matching_products() {
                if (this.parentType === 'Category') {
                    return this.products;
                }

                return this.products
                           .filter(product => this.belongsToSelectedParent(product));
            },

            page_of_products() {
                const pages = chunk(this.matching_products, this.page_size);

                if (!this.page || this.page > pages.length - 1) {
                    this.pages = 0;
                    return pages[0];
                }

                return pages[this.page];
            },

            number_of_pages() {
                return Math.ceil(this.matching_products.length / this.page_size);
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
            },

            productLink(product) {
                if(this.linkToAdmin) {
                    return `/admin/products/${product.id}`;
                }

                return `/products/${product.slug}`;
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>