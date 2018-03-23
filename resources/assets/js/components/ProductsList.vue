<template>
    <div>
        <div class="flex flex-wrap justify-around">
            <div v-for="product in page_of_products"
                 :key="product.id"
                 class="w-40 w-20-ns mh2 mb3 col-w-bg pa3 relative">
                <a :href="productLink(product)">
                    <img :src="product.main_image.thumb"
                         :alt="product.title">
                </a>
                <a :href="productLink(product)"
                   class="link">
                    <p class="ff-title hv-col-p col-d mb0">{{ product.title }}</p>
                    <p class="ff-fine-body col-mg hv-col-d mb0 mt2">{{ product.code }}</p>
                </a>
                <p v-if="product.is_new"
                   class="absolute col-p-bg col-w ttu ph2 py1 top-0 left-0">New</p>
            </div>
        </div>
        <div v-show="number_of_pages > 1"
             class="pa3 col-lg-bg ma4">
            <p class="ff-title">Pages</p>
            <div class="flex flex-wrap">
                <div v-for="page_number in number_of_pages"
                     @click="setPage(page_number - 1)"
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

        props: ['fetch-url', 'filter-type', 'subcategory', 'tool-groups', 'link-to-admin'],

        data() {
            return {
                products: [],
                page: 0,
                page_size: 15
            };
        },

        computed: {


            matching_products() {
                return this.products
                           .filter(product => this.belongsToSelectedParent(product))
                           .sort((a, b) => {
                               if (a.is_new) {
                                   return -1;
                               }
                               if (b.is_new) {
                                   return 1;
                               }
                               return 0;
                           })
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

            eventHub.$on('request-product-page', (page_number) => this.page = page_number);
        },

        methods: {

            fetchProducts() {
                axios.get(this.fetchUrl)
                     .then(({data}) => this.products = data)
                     .catch(err => console.log(err));
            },

            belongsToSelectedParent(product) {
                if (this.filterType === 'category') {
                    return true;
                }
                if (this.filterType === 'subcategory') {
                    return this.belongsToSubcategory(product) || this.belongsToToolGroup(product);
                }

                if (this.filterType === 'tool_group') {
                    return this.belongsToToolGroup(product);
                }
            },

            belongsToSubcategory(product) {
                return product.parents.some(parent => parent.type === 'Subcategory' && parent.id === this.subcategory.id);
            },

            belongsToToolGroup(product) {
                return product.parents.some(parent => (parent.type === 'ToolGroup') && (this.toolGroups.find(tg => tg.id === parent.id)));
            },

            setPage(page_number) {
                this.page = page_number;
                this.$emit('page-selected', page_number);
            },

            productLink(product) {
                if (this.linkToAdmin) {
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