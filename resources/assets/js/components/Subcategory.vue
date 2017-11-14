<template>
    <div>
        <div class="flex justify-between items-center">
            <h1 class="f1 normal">{{ title }}</h1>
            <div class="flex justify-end items-center">
                <category-form :url="`/admin/subcategories/${itemAttributes.id}`"
                               resource-type="subcategory"
                               button-text="edit"
                               form-type="update"
                               :form-attributes="itemAttributes"
                               @updated-subcategory="update"
                ></category-form>
                <delete-modal :item-name="title"
                              :redirect="true"
                              :url="`/admin/subcategories/${itemAttributes.id}`"
                ></delete-modal>
                <category-form :url="`/admin/subcategories/${itemAttributes.id}/tool-groups`"
                               resource-type="tool-group"
                               button-text="add tool group"
                ></category-form>
            </div>
        </div>
        <div class="card mv3">
            <p class="ttu f6 col-p">Published</p>
            <div class="flex justify-between items-center mr4">
                <p>{{ publish_status }}</p>
                <toggle-switch :toggle-state="itemAttributes.published"
                               label-text="Publish"
                               :on-payload="{subcategory_id: itemAttributes.id}"
                               on-url="/admin/published-subcategories"
                               :off-url="`/admin/published-subcategories/${itemAttributes.id}`"
                               @toggled-state="(state) => this.published = state"
                ></toggle-switch>
            </div>
        </div>
        <div class="card mv3">
            <p class="ttu f6 col-p">Description</p>
            <p>{{ description }}</p>
        </div>
        <toolgroup-list :fetch-url="`/admin/services/subcategories/${itemAttributes.id}/tool-groups`"></toolgroup-list>
        <div class="card mv3">
            <div class="flex justify-between items-center">
                <p class="ttu col-p f6">Products</p>
                <product-form :url="`/admin/subcategories/${itemAttributes.id}/products`"
                              button-text="add product"
                ></product-form>
            </div>
            <product-list :url="`/admin/services/subcategories/${itemAttributes.id}/products`" parent-type="sub-category"></product-list>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['item-attributes'],

        data() {
            return {
                title: this.itemAttributes.title,
                description: this.itemAttributes.description,
                published: this.itemAttributes.published
            };
        },

        computed: {
            publish_status() {
                return this.published ? 'Published! This sub-category is live and visible on the site.' : 'Not published. Use the switch on the right to publish this sub-category.';
            }
        },

        methods: {
            update({title, description}) {
                this.title = title;
                this.description = description;
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>