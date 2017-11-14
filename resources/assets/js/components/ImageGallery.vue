<template>
    <div class="ba mv4 gallery-box relative pt5"
         @drop.prevent="handleFiles"
         @dragenter.prevent="hover=true"
         @dragover.prevent="hover=true"
         @dragleave="hover=false"
         :class="{'hovering': hover}">
        <label for="gallery_file_input"
               class="absolute top-1 right-1 btn">Select Files</label>
        <input type="file"
               id="gallery_file_input"
               class="dn"
               @change="handleFiles"
               multiple
        >
        <uploading-image v-for="(upload, index) in uploads"
                         :key="`upload_${index}`"
                         :upload="upload"
                         @uploaded-image-deleted="removeUploadedImage"
        ></uploading-image>

        <gallery-image v-for="gallery_image in gallery_images"
                       :key="gallery_image.image_id"
                       :image="gallery_image"
                       @gallery-image-deleted="removeGalleryImage"
        ></gallery-image>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['gallery', 'post-url'],

        data() {
            return {
                gallery_images: this.gallery || [],
                uploads: [],
                upload_counter: 0,
                hover: false
            };
        },

        methods: {

            handleFiles(ev) {
                this.hover = false;
                const files = ev.target.files || ev.dataTransfer.files;
                for (let i = 0; i < files.length; i++) {
                    if(this.acceptsFile(files[i])) {
                       this.processFile(files[i]);
                    } else {
                        console.log(files[i].name, files[i].type, files[i].size);
                        eventHub.$emit('user-error', `${files[i].name} is not a valid file.`);
                    }
                }
            },

            acceptsFile(file) {
              return (file.type.indexOf('image') !== -1) && (file.size < 5000 * 1024);
            },

            processFile(file) {
                this.upload_counter++;
                this.uploads.push({file, url: this.postUrl, upload_id: `upload_${this.upload_counter}`});
            },

            removeUploadedImage(upload_id) {
                const upload = this.uploads.find(u => u.upload_id === upload_id);
                this.uploads.splice(this.uploads.indexOf(upload), 1);
            },

            removeGalleryImage(image_id) {
                const image = this.gallery_images.find(i => i.image_id === image_id);
                this.gallery_images.splice(this.gallery_images.indexOf(image), 1);
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">
    .gallery-box {
        min-height: 500px;
    }

    .hovering {
        background-color: rgba(#4AB5AD, .3);
    }
</style>