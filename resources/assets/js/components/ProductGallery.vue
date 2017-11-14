<template>
    <div>
        <div class="flex justify-between items-center">
            <h1 class="f1 normal">{{ product.title }} Images</h1>
            <div class="flex justify-end items-center">
                <a class="link btn"
                   :href="`/admin/products/${product.id}`">Back to Product</a>
            </div>
        </div>
        <image-gallery :gallery="product_gallery"
                       :post-url="`/admin/products/${product.id}/gallery-images`"
        ></image-gallery>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['product'],

        computed: {
            product_gallery() {
                return this.product.gallery_images.map(img => ({
                    src: img.thumb,
                    delete_url: `/admin/gallery-images/${img.id}`,
                    image_id: img.id
                }));
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>