<template>
    <div>
        <div class="main-gallery-image-box flex justify-center items-center">
            <img :src="current_image.web"
                 :alt="`Image of ${productTitle}`"
                 class="mw-100 mh-100"
            >
        </div>
        <div v-if="images.length > 1">
            <img v-for="image in images"
                 :src="image.thumb"
                 :alt="`Alternate image of ${productTitle}`"
                 @click="setCurrentImage(image)"
                 class="gallery-thumb dib ma3"
            >
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['images', 'product-title'],

        data() {
            return {
                current_image: this.images[0]
            };
        },

        methods: {
            setCurrentImage(image) {
                this.current_image = image;
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

    .gallery-thumb {
        width: 50px;
        height: 50px;
    }

    .main-gallery-image-box {
        height: 400px;
    }

    @media only screen and (max-width: 30em) {
        .main-gallery-image-box {
            height: 300px;
        }
    }

</style>