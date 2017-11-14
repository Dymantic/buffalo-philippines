<template>
    <div class="dib ma3 w4 h4 relative" :class="{'deleting': deleting}">
        <img :src="preview_src"
             alt="" :class="{'complete': complete}">
        <div class="absolute bottom-0 left-0 right-0 overflow-hidden">
            <div class="progress-bar" :style="progress_style" :class="{'completed': complete}"></div>
        </div>
        <div class="delete-icon f7 flex justify-center items-center absolute" v-show="delete_url && !deleting" @click="removeImage">&times;</div>
    </div>
</template>

<script type="text/babel">
    import {generatePreview} from "./PreviewGenerator";

    export default {

        props: ['upload'],

        data() {
            return {
                preview_src: null,
                complete: false,
                progress: 0,
                delete_url: null,
                deleting:false
            };
        },

        computed: {
            progress_style() {
                return {
                    transform: `translate3d(-${100 - this.progress}%,0,0)`
                };
            }
        },

        mounted() {
            generatePreview(this.upload.file, {pWidth: 200, pHeight: 200})
                .then(src => this.preview_src = src)
                .catch(err => console.log(src));

            this.uploadImage();
        },

        methods: {
            uploadImage() {
                axios.post(this.upload.url, this.prepareFormData(this.upload.file), this.getUploadOptions())
                    .then(({data}) => this.uploadSuccess(data))
                    .catch(() => this.uploadFailure());
            },

            prepareFormData: function (file) {
                let fd = new FormData();
                fd.append('image', file);
                return fd;
            },

            getUploadOptions() {
                return {
                    onUploadProgress: (ev) => this.progress = (parseInt(ev.loaded / ev.total * 100))
                }
            },

            uploadSuccess({image_id, delete_url}) {
                this.complete = true;
                this.delete_url = delete_url;
            },

            uploadFailure() {
                this.complete = false;
                eventHub.$emit('user-error', `The upload for ${this.upload.file.name} failed. Please make sure it is a valid file and try again later. Thanks.`);
                this.$emit('uploaded-image-deleted', this.upload.upload_id);
            },

            removeImage() {
                this.deleting = true;
                axios.delete(this.delete_url)
                    .then(() => this.$emit('uploaded-image-deleted', this.upload.upload_id))
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

    .progress-bar {
        height: 5px;
        background-color: #2ab27b;
        width: 100%;

        &.completed {
            display: none;
        }
    }

    img:not(.complete) {
        filter: grayscale(100%);
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