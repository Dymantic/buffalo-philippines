<template>
    <div>
        <div class="flex justify-between items-center">
            <h1 class="f1 normal">{{ title }}</h1>
            <div class="flex justify-end items-center">
                <category-form :url="`/admin/tool-groups/${itemAttributes.id}`"
                               resource-type="tool-group"
                               button-text="edit"
                               form-type="update"
                               :form-attributes="itemAttributes"
                               @updated-tool-group="update"
                ></category-form>
                <delete-modal :item-name="title"
                              :redirect="true"
                              :url="`/admin/tool-groups/${itemAttributes.id}`"
                ></delete-modal>
            </div>
        </div>
        <div class="card mv3">
            <p class="ttu f6 col-p">Published</p>
            <div class="flex justify-between items-center mr4">
                <p>{{ publish_status }}</p>
                <toggle-switch :toggle-state="itemAttributes.published"
                               label-text="Publish"
                               :on-payload="{tool_group_id: itemAttributes.id}"
                               on-url="/admin/published-tool-groups"
                               :off-url="`/admin/published-tool-groups/${itemAttributes.id}`"
                               @toggled-state="(state) => this.published = state"
                ></toggle-switch>
            </div>
        </div>
        <div class="card mv3">
            <p class="ttu col-p f6">Description</p>
            <p>{{ description }}</p>
        </div>
        <div class="card mv3">
            <div class="flex justify-between items-center">
                <div class="w-50">
                    <p class="ttu col-p f6">Products</p>
                    <p><strong class="ff-headline col-p">{{ productCount }} products.</strong></p>
                </div>
                <div>
                    <a class="btn" :href="`/admin/categories/${category.id}/products?tool-group=${itemAttributes.id}`">Browse Products</a>
                    <product-form :url="`/admin/tool-groups/${itemAttributes.id}/products`"
                                  button-text="add product"
                    ></product-form>
                </div>

            </div>
        </div>
        <div class="card mv3">
            <p class="ttu col-p f6">Category</p>
            <p><a :href="`/admin/categories/${category.id}`" class="link col-d b">{{ category.title }}</a></p>
        </div>
        <div class="card mv3">
            <p class="ttu col-p f6">Subcategory</p>
            <p><a :href="`/admin/subcategories/${subcategory.id}`" class="link col-d b">{{ subcategory.title }}</a></p>
        </div>

    </div>
</template>

<script type="text/babel">
    export default {

        props: ['item-attributes', 'category', 'subcategory', 'product-count'],

        data() {
            return {
                title: this.itemAttributes.title,
                description: this.itemAttributes.description,
                published: this.itemAttributes.published
            };
        },

        computed: {
            publish_status() {
                return this.published ? 'Published! This tool group is live and visible on the site.' : 'Not published. Use the switch on the right to publish this tool group.';
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