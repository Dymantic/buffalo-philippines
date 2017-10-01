<template>
    <div class="banner-slide-component">
        <div class="upload-label ba relative overflow-hidden"
             :class="[text_colour, uploading ? 'o-70' : '']">
            <label class="db h-100 z-999"
                   for="media-upload">
                <input type="file"
                       id="media-upload"
                       class="dn"
                       @change="processFile">
                <p v-show="!video_src && !image_src"
                   class="f2 black-40 tc"
                >Click to select a {{ slide_type }} to upload.</p>
            </label>
            <img v-if="!is_video"
                 :src="image_src"
                 class="db absolute absolute--fill preview-image">
            <video v-if="is_video"
                   :src="video_src"
                   class="db absolute preview-video w-100 z-0"
                   autoplay
                   muted
                   loop
            ></video>
            <p class="absolute slide-text w-50 f2 ttu">{{ slide_text}}</p>
            <div v-show="action_text !== ''"
                 class="absolute action-button lh-copy f3 ttu flex items-center">
                {{ action_text }}
                <svg class="icon ml2"
                     height="20px"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 22 22">
                    <path class="colour-fill"
                          d="M11.69,15.67a.31.31,0,0,1-.25.13H8a.31.31,0,0,1-.25-.49l3-4.12a.31.31,0,0,0,0-.36l-3-4.14A.31.31,0,0,1,8,6.2h3.4a.31.31,0,0,1,.25.13l3.24,4.1a.91.91,0,0,1,0,1.13Z"/>
                    <path class="colour-fill"
                          d="M19.35,0H2.65A2.65,2.65,0,0,0,0,2.65v16.7A2.65,2.65,0,0,0,2.65,22h16.7A2.65,2.65,0,0,0,22,19.35V2.65A2.65,2.65,0,0,0,19.35,0Zm-1,19H3.66A.66.66,0,0,1,3,18.34V3.66A.66.66,0,0,1,3.66,3H18.34a.66.66,0,0,1,.66.66V18.34A.66.66,0,0,1,18.34,19Z"/>
                </svg>
            </div>
        </div>
        <div v-show="uploading"
             class="upload-progress-bar h1 col-p-bg w-100"
             :style="{transform: progressScale}"
        ></div>
        <div class="card mt4">
            <p class="ttu black-60 f6 mb2">Slide Text (Up to 60 characters)</p>
            <input type="text"
                   class="input db h2 w-100 b--solid b--black-50 pl2"
                   :class="{'has-error': errors.slide_text}"
                   v-model="slide_text"
                   maxlength="60"
            >
            <p v-show="errors.slide_text"
               class="red f6">{{ errors.slide_text }}</p>
            <div class="flex justify-between mt4">
                <div class="w-50 mr3">
                    <p class="ttu black-60 f6 mb2">Button text (Up to 16 characters)</p>
                    <input type="text"
                           class="input db h2 w-100 b--solid b--black-50 pl2"
                           v-model="action_text"
                           maxlength="16"
                           :class="{'has-error': errors.action_text}"
                    >
                    <p v-show="errors.action_text"
                       class="red f6">{{ errors.action_text }}</p>
                </div>
                <div class="w-50 ml3">
                    <p class="ttu black-60 f6 mb2">Button link (Paste in the url you want to link to)</p>
                    <input type="text"
                           class="input db h2 w-100 b--solid b--black-50 pl2"
                           v-model="action_link"
                           :class="{'b--red bw2': errors.action_link}"
                    >
                    <p v-show="errors.action_link"
                       class="red f6">{{ errors.action_link }}</p>
                </div>
            </div>
            <div class="mt4">
                <p class="ttu black-60 f6 mb2">Select a color for the text</p>
                <div class="flex">
                    <label class="ma3 mt1 db"
                           for="primary-colour">
                        <input class="dn"
                               type="radio"
                               value="primary"
                               id="primary-colour"
                               v-model="text_colour">
                        <div class="colour-option ba bw2 w3 h2 col-p-bg"
                             :class="[text_colour === 'primary' ? 'b--black' : 'b--black-10']"
                        ></div>
                    </label>
                    <label class="ma3 mt1 db"
                           for="dark-colour">
                        <input class="dn"
                               type="radio"
                               value="dark"
                               id="dark-colour"
                               v-model="text_colour">
                        <div class="colour-option ba bw2 w3 h2 col-d-bg"
                             :class="[text_colour === 'dark' ? 'b--black' : 'b--black-10']"
                        ></div>
                    </label>
                    <label class="ma3 mt1 db"
                           for="light-colour">
                        <input class="dn"
                               type="radio"
                               value="light"
                               id="light-colour"
                               v-model="text_colour">
                        <div class="colour-option ba bw2 w3 h2 col-w-bg"
                             :class="[text_colour === 'light' ? 'b--black' : 'b--black-10']"
                        ></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">

    import handlesVideoAndImages from "./mixins/HandlesImageAndVideo";
    import {debounce} from "lodash";
    import setsData from "./mixins/SetsDataFromObject"

    export default {

        mixins: [handlesVideoAndImages, setsData],

        props: ['media_url', 'info_url', 'current_src', 'is_video', 'slide-attributes'],

        data() {
            return {
                image_src: this.is_video ? null : this.current_src,
                video_src: this.is_video ? this.current_src : null,
                server_confirmed_src: this.current_src,
                video_has_object_url: false,
                slide_type: this.is_video ? 'video' : 'image',
                uploading: false,
                upload_percentage: 0,
                slide_text: this.slideAttributes.slide_text || '',
                action_text: this.slideAttributes.action_text || '',
                action_link: this.slideAttributes.action_link || '',
                text_colour: this.slideAttributes.text_colour || 'dark',
                errors: {
                    slide_text: '',
                    action_text: '',
                    action_link: ''
                }
            };
        },

        computed: {
            progressScale() {
                return `scaleX(${this.upload_percentage / 100})`;
            }
        },

        watch: {
            slide_text() {
                this.syncSlideInfo();
            },
            action_text() {
                this.syncSlideInfo();
            },
            action_link() {
                this.syncSlideInfo();
            },
            text_colour() {
                this.syncSlideInfo();
            }
        },


        methods: {
            syncSlideInfo: debounce(
                function () {
                    axios.post(this.info_url, {
                        slide_text: this.slide_text,
                        action_text: this.action_text,
                        action_link: this.action_link,
                        text_colour: this.text_colour
                    }).then(({data}) => this.setUpdatedData(data))
                         .catch(err => this.onFailedUpdate(err));
                },
                2000
            ),

            setUpdatedData(updated_data) {
                this.clearErrors();
                this.setDataFrom(updated_data)
            },

            onFailedUpdate(err) {
                if (err.response.status === 422) {
                    return this.showFormValidationErrors(err.response.data.errors);
                }

                this.showServerError();
            },

            showFormValidationErrors(errors) {
                this.clearErrors();
                Object.keys(errors)
                      .filter(key => this.errors.hasOwnProperty(key))
                      .forEach(key => this.errors[key] = errors[key][0]);
            },

            clearErrors() {
                this.errors.slide_text = '';
                this.errors.action_text = '';
                this.errors.action_link = '';
            }
        }


    }
</script>

<style scoped
       lang="scss"
       type="text/scss">
    @import "~@/_variables.scss";

    .upload-label {
        max-height: 400px;
        height: 40vw;

        &.primary {
            color: $admin-primary;

            .colour-fill {
                fill: $admin-primary;
            }
        }

        &.dark {
            color: $admin-dark;

            .colour-fill {
                fill: $admin-dark;
            }
        }

        &.light {
            color: $white;

            .colour-fill {
                fill: $white;
            }
        }
    }

    .preview-image {
        z-index: -1;
    }

    .preview-video {
        z-index: -1;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
    }

    .upload-progress-bar {
        transform-origin: left top;
    }

    .slide-text {
        font-family: $strong;
        top: 3rem;
        left: 2rem;
    }

    .action-button {
        font-family: $strong;
        bottom: 50px;
        left: 50%;
        transform: translateX(-50%);
    }

    .colour-option {
        position: relative;
    }

    input[type=radio]:checked + .colour-option::after {
        content: "\2713";
        position: absolute;
        border-radius: 50%;
        color: $admin-dark;
        background-color: $mid_grey;
        width: 20px;
        height: 20px;
        top: -10px;
        left: -10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;

    }


</style>