<template>
    <div class="mw8 center-ns mh3 mt5">
        <p class="strong-type bb bw2 b--black-20 ttu mb4 f5 f4-ns">You may also find these to be useful:</p>
        <div class="flex justify-around flex-wrap mb5">
            <div v-for="product in related_products"
                 :key="product.id"
                 class="w-100 w-20-ns pa3 flex flex-row flex-column-ns relative"
            >
                <a :href="`/products/${product.slug}`" class="link w4 w-100-ns">
                    <img :src="product.main_image.thumb"
                         :alt="`Image of ${product.title}`">
                </a>
                <a :href="`/products/${product.slug}`" class="link">
                    <p class="ff-title col-d hv-col-p mb0">{{ product.title }}</p>
                    <p class="col-mg hv-col-d mt1 ff-fine-body">{{ product.code }}</p>
                </a>
                <p v-if="product.is_new" class="absolute col-p-bg col-w ttu ph2 py1 top-0 left-0">New</p>
            </div>
        </div>

    </div>
</template>

<script type="text/babel">
    export default {

        props: ['fetch-url'],

        data() {
            return {
                related_products: []
            };
        },

        mounted() {
            this.fetchRelatedProducts();
        },

        methods: {
            fetchRelatedProducts() {
                axios.get(this.fetchUrl)
                     .then(({data}) => this.related_products = data)
                     .catch(err => console.log(err));
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>