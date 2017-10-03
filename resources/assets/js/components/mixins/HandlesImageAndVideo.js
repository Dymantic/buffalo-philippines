import {generatePreview} from "../PreviewGenerator";

export default  {
    methods: {
        processFile(ev) {
            const file = ev.target.files[0];

            if (this.isUnacceptedFileType(file)) {
                return this.showUnacceptedFileError(file.name, this.is_video ? 'video' : 'image');
            }

            if (file.size > 1000 * 1024 * 12) {
                return this.showFileTooLargeError();
            }

            this.is_video ? this.handleVideo(file) : this.handleImage(file);
            ev.target.value = [];
        },

        isUnacceptedFileType(file) {
            if (!this.is_video) {
                return file.type.indexOf('image') === -1;
            }
            if (this.is_video) {
                return file.type.indexOf('video') === -1;
            }
        },

        handleVideo(video) {
            this.setVideoSrc(video);
            this.uploadMedia(video);
        },

        setVideoSrc(video) {
            this.revokeObjectUrlVideoSrc();
            this.video_src = URL.createObjectURL(video);
            this.video_has_object_url = true;
        },

        revokeObjectUrlVideoSrc() {
            if (this.video_has_object_url) {
                URL.revokeObjectURL(this.video_src);
                this.video_has_object_url = false;
            }
        },

        handleImage(file) {
            generatePreview(file, {pWidth: 1000, pHeight: 400})
                .then((src) => this.image_src = src)
                .catch((err) => console.log(err));
            this.uploadMedia(file);
        },

        uploadMedia(file) {
            this.uploading = true;
            this.progress = 0;
            axios.post(this.media_url, this.prepareFormData(file, this.slide_type), this.getUploadOptions())
                .then(res => this.onUploadSuccess(res))
                .catch(err => this.onUploadFailed(err));
        },

        prepareFormData(file, name) {
            let fd = new FormData();
            fd.append(name, file);
            return fd;
        },

        getUploadOptions() {
            return {
                onUploadProgress: (ev) => this.showProgress(parseInt(ev.loaded / ev.total * 100))
            }
        },

        showProgress(progress) {
            this.upload_percentage = progress;
        },

        onUploadSuccess(res) {
            this.uploading = false;
            this.server_confirmed_src = res.data.url;

            if(!this.is_video) {
                this.image_src = res.data.url;
            }

            if (this.is_video) {
                this.revokeObjectUrlVideoSrc();
                this.video_src = res.data.url;
            }
        },

        onUploadFailed(err) {
            this.uploading = false;

            if (this.is_video) {
                this.revokeObjectUrlVideoSrc();
                this.video_src = this.server_confirmed_src;
            }

            if (!this.is_video) {
                this.image_src = this.server_confirmed_src;
            }

            this.showUploadError(err);
        },

        showUploadError(err) {
            if (err.response.status === 422) {
                return this.showValidationError();
            }

            this.showServerError();
        },

        showValidationError() {
            eventHub.$emit('user-alert', {
                type: 'error',
                title: 'That file is not supported',
                text: 'The file you are uploading is either unsupported, or too large.'
            })
        },
        showServerError() {
            eventHub.$emit('user-alert', {
                type: 'error',
                title: 'Oh dear. An error occurred!',
                text: 'Something went wrong on the server. Please refresh and try again'
            });
        },
        showUnacceptedFileError(name, expected) {
            eventHub.$emit('user-alert', {
                type: 'error',
                title: 'Sorry, no can do!',
                text: `${name} is not a valid ${expected} file`
            })
        },
        showFileTooLargeError() {
            eventHub.$emit('user-alert', {
                type: 'error',
                title: 'That file is just too big!',
                text: `If the file is too large it can't be used in the banner. Please use a file less than 12MB`
            })
        }
    }
}