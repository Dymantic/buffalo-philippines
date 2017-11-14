<template>
    <div class="ma3 dib w4 h4 relative" :class="{'deleting': deleting}"
    >
        <img :src="src"
             alt="">
        <div class="delete-icon f7 flex justify-center items-center absolute"
             v-show="delete_url && !deleting"
             @click="removeImage">&times;
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['image'],

        data() {
            return {
                src: this.image.src,
                delete_url: this.image.delete_url,
                deleting: false
            };
        },

        methods: {
            removeImage() {
                this.deleting = true;
                axios.delete(this.delete_url)
                     .then(() => this.$emit('gallery-image-deleted', this.image.image_id))
                     .catch(() => eventHub.$emit('user-error', 'Failed to delete gallery image.'))
                     .then(() => this.deleting = false);
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

    .deleting {
        opacity: .4;
    }
    .delete-icon {
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: darkred;
        color: white;
        cursor: default;
        top: 8px;
        right: 8px;
    }
</style>