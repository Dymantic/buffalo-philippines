<template>
    <div class="flex flex-wrap">
        <div v-for="slide in slides"
             :key="slide.id"
             :data-id="slide.id"
             class="card ma3 w5 flex flex-column justify-between"
        >
            <div class="flex justify-between mb2">
                <span class="ttu b black-60">{{ slide.slide_type }}</span>
                <span v-if="slide.published"
                      class="col-p">Published</span>
                <span v-if="!slide.published"
                      class="black-40">Unublished</span>
            </div>
            <div class="aspect-ratio aspect-ratio--4x3 w-100 overflow-hidden">
                <img :src="slide.taller_image"
                     alt=""
                     class="aspect-ratio--object"
                     v-if="!slide.is_video"
                >
                <video :src="slide.video_url"
                       v-if="slide.is_video"
                       class="aspect-ratio--object"></video>
            </div>
            <p class="ttu">{{ slide.slide_text }}</p>
            <a :href="`/admin/slideshow/slides/${slide.id}`"
               class="btn">Edit</a>
        </div>
    </div>
</template>

<script type="text/babel">
    import Sortable from "sortablejs";

    export default {

        props: ['slides', 'sync_order_url'],

        data() {
            return {
                sort_list: null
            };
        },

        mounted() {
            this.sort_list = Sortable.create(this.$el, {onSort: () => this.syncOrder()});
        },

        methods: {
            syncOrder() {
                console.log(this.sort_list.toArray());
                axios.post(this.sync_order_url, {ordered_ids: this.sort_list.toArray()})
                     .then(() => {
                     })
                     .catch(err => this.showSyncError());
            },

            showSyncError() {
                eventHub.$emit('user-alert', {
                    type: 'error',
                    title: 'Oh dear! An error occurred.',
                    text: 'Something failed when setting the order, and your choice may not have saved. Please refresh and try again.'
                });
            }
        }

    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>