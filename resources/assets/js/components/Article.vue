<style></style>

<template>
    <div class="article-page-component">
        <div class="flex justify-between items-center">
            <h1 class="f1 normal">{{ title }}</h1>
            <div class="flex justify-end items-center">
                <article-form :url="`/admin/articles/${articleAttributes.id}`"
                              button-text="Edit Info"
                              :formAttributes="articleAttributes"
                              form-type="update"
                              @updated-article-info="updateFormInfo"
                ></article-form>
                <a :href="`/admin/articles/${articleAttributes.id}/body`" class="btn link">Edit Content</a>
                <delete-modal :url="`/admin/articles/${articleAttributes.id}`"
                              :redirect="true"
                              :item-name="articleAttributes.title"
                ></delete-modal>
            </div>
        </div>
        <section>
            <div class="card mv3">
                <p class="b f6 ttu col-p">Description</p>
                <p>{{ description }}</p>
            </div>
            <div class="card labeled-text mv3">
                <p class="b f6 ttu col-p">Intro</p>
                <p>{{ intro }}</p>
            </div>
        </section>
        <div class="split-60 flex justify-between">
            <div class="card w-50 mr3">
                <p class="b f6 ttu col-p">Title Image</p>
                <image-upload :default="articleAttributes.title_image_large_tile"
                               :url="`/admin/articles/${articleAttributes.id}/title-images`"
                               size="preview"
                               :preview-width="400"
                               :preview-height="200"
                               :unique="articleAttributes.id"
                               :delete-url="`/admin/articles/${articleAttributes.id}/title-images`"
                ></image-upload>
            </div>
            <div class="card w-50 ml3">
                <p class="b f6 ttu col-p">Publishing</p>
                <article-publisher :article-id="articleAttributes.id"
                                   :published-on="articleAttributes.published_on || ``"
                                   :initial-state="!articleAttributes.is_draft"
                ></article-publisher>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import setsData from "./mixins/SetsDataFromObject";

    export default {

        mixins: [setsData],

        props: ['articleAttributes'],

        data() {
            return {
                title: '',
                description: '',
                intro: '',
                is_draft: '',
                published_on: '',
                title_image_banner: '',
                title_image_large_tile: ''
            };
        },

        mounted() {
            this.setDataFrom(this.articleAttributes);
        },

        methods: {
            updateFormInfo(updated_data) {
                this.setDataFrom(updated_data);
            }
        }
    }
</script>