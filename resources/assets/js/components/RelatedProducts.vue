<template>
    <div class="mw8 center-ns mh3 mt5">
        <p class="strong-type bb bw2 b--black-20 ttu mb4 f5 f4-ns">You may also find these to be useful:</p>
        <div class="flex justify-around flex-wrap mb5">
            <div v-for="product in related_products"
                 :key="product.id"
                 class="w-20 col-lg-bg pa3"
            >
                <a :href="`/products/${product.slug}`" class="link">
                    <img :src="product.main_image.thumb"
                         :alt="`Image of ${product.title}`">
                </a>
                <p class="ff-title mb0">{{ product.title }}</p>
                <p class="col-p mt1 ff-fine-body">{{ product.code }}</p>
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