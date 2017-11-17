<template>
    <div class="card mv3 mh2 flex flex-column mw-350">
        <p class="col-p ttu f3"><a :href="`/admin/categories/${itemAttributes.id}`"
                                   class="link col-p">{{ title }}</a></p>
        <p class="f4">{{ description }}</p>
        <image-upload :default="itemAttributes.image.thumb"
                      :url="`/admin/categories/${itemAttributes.id}/image`"
                      size="preview"
                      :preview-width="300"
                      :preview-height="300"
                      :unique="itemAttributes.id"
                      :delete-url="`/admin/categories/${itemAttributes.id}/image`"
        ></image-upload>
        <div class="flex justify-center mv2">
            <category-form :url="`/admin/categories/${itemAttributes.id}`"
                           :form-attributes="itemAttributes"
                           form-type="update"
                           button-text="Edit"
                           @updated-category="updateCategory"
            ></category-form>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['item-attributes'],

        data() {
            return {
                title: this.itemAttributes.title,
                description: this.itemAttributes.description
            };
        },

        methods: {
            updateCategory({title, description}) {
                this.title = title;
                this.description = description
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>