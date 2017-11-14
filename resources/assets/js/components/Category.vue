<template>
    <div>
        <div class="flex justify-between items-center">
            <h1 class="f1 normal">{{ title }}</h1>
            <div class="flex justify-end items-center">
                <category-form :url="`/admin/categories/${id}/subcategories`"
                               resource-type="subcategory"
                               button-text="add subcategory"
                ></category-form>
                <delete-modal :item-name="title"
                              :redirect="true"
                              :url="`/admin/categories/${id}`"></delete-modal>
            </div>
        </div>
        <div class="card mv3">
            <p class="ttu f6 col-p">Published</p>
            <div class="flex justify-between items-center mr4">
                <p>{{ publish_status }}</p>
                <toggle-switch :toggle-state="published"
                               label-text="Publish"
                               :on-payload="{category_id: id}"
                               on-url="/admin/published-categories"
                               :off-url="`/admin/published-categories/${id}`"
                               @toggled-state="(state) => this.is_published = state"
                ></toggle-switch>
            </div>
        </div>
        <div class="card mv3">
            <p class="col-p ttu f6">Description</p>
            <p>{{ description }}</p>
        </div>
        <subcategories-list :fetch-url="`/admin/services/categories/${id}/subcategories`"></subcategories-list>
        <div class="card mv3">
            <div class="flex justify-between items-center">
                <p class="ttu col-p f6">Products</p>
                <product-form :url="`/admin/categories/${id}/products`"
                              button-text="add product"
                ></product-form>
            </div>
            <product-list :url="`/admin/services/categories/${id}/products`" parent-type="category"></product-list>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['id', 'title', 'description', 'published'],

        data() {
            return {
                is_published: this.published
            };
        },

        computed: {
            publish_status() {
                return this.is_published ? 'Published! This category is live and visible on the site.' : 'Not published. Use the switch on the right to publish this category.';
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>