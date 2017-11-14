<template>
    <div>
        <p v-show="!products.length">This {{ parentType }} has no products.</p>
        <div v-for="product in products"
             :key="product.id"
             class="flex items-center mv2"
        >
            <img :src="product.main_image.thumb"
                 alt=""
                 height="50px"
                 class="mr5">
            <p class="flex-auto"><a :href="`/admin/products/${product.id}`">{{ product.title }}</a></p>
            <p>{{ product.code }}</p>
        </div>
        <div class="card mv3"
             v-show="products.length">
            <p class="ttu col-p f6">Pages</p>
            <a v-for="page in page_list"
               @click.prevent="fetchProducts(page)"
               class="col-p mh2"
               :disabled="page === current_page"
            >{{ page }}</a>
        </div>
    </div>
</template>

<script type="text/babel">
    import {range} from "lodash";

    export default {

        props: ['url', 'parent-type'],

        data() {
            return {
                products: [],
                current_page: 1,
                total_pages: null
            }
        },

        computed: {
            page_list() {
                return range(1, (this.total_pages + 1));
            }
        },

        mounted() {
            this.fetchProducts();
        },

        methods: {
            fetchProducts(page) {
                const product_page = page || 1;

                axios.get(`${this.url}?page=${product_page}`)
                     .then(({data}) => {
                         this.products = data.products;
                         this.current_page = data.current_page;
                         this.total_pages = data.total_pages;
                     }).catch(err => console.log(err));
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

    a[disabled] {
        color: silver;
    }
</style>