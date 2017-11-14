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
                <p class="ttu col-p f6">Products</p>
                <product-form :url="`/admin/tool-groups/${itemAttributes.id}/products`"
                              button-text="add product"
                ></product-form>
            </div>
            <product-list :url="`/admin/services/tool-groups/${itemAttributes.id}/products`" parent-type="tool group"></product-list>
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