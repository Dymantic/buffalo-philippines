<template>
    <div>
        <div class="flex justify-between items-center">
            <h1 class="f1 normal">{{ category_title }}</h1>
            <div class="flex justify-end items-center">
                <category-form :url="`/admin/categories/${id}/subcategories`"
                               resource-type="subcategory"
                               button-text="add subcategory"
                ></category-form>
                <category-form :url="`/admin/categories/${id}`"
                               :form-attributes="{title,description}"
                               form-type="update"
                               button-text="Edit"
                               @updated-category="updateCategory"
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
            <p>{{ category_description }}</p>
        </div>
        <div class="card mv3">
            <div class="flex justify-between items-center">
                <div class="w-50">
                    <p class="ttu col-p f6">Products</p>
                    <p><strong class="ff-headline col-p">{{ productCount }} products.</strong></p>
                </div>

                <div>
                    <a class="btn" :href="`/admin/categories/${id}/products`">Browse Products</a>
                    <product-form :url="`/admin/categories/${id}/products`"
                                  button-text="add product"
                    ></product-form>
                </div>
            </div>
            <!--<product-list :url="`/admin/services/categories/${id}/products`" parent-type="category"></product-list>-->
        </div>
        <div class="flex justify-between mv3 items-stretch">
            <subcategories-list class="w-50 mr3"
                                :category="menuStructure"
            ></subcategories-list>
            <div class="w-50 card">
                <p class="col-p ttu f6">Image</p>
                <image-upload :default="image"
                              :url="`/admin/categories/${id}/image`"
                              size="preview"
                              :preview-width="300"
                              :preview-height="300"
                              :unique="parseInt(id)"
                              :delete-url="`/admin/categories/${id}/image`"
                ></image-upload>
            </div>
        </div>

    </div>
</template>

<script type="text/babel">
    export default {

        props: ['id', 'title', 'description', 'published', 'image', 'menu-structure', 'product-count'],

        data() {
            return {
                is_published: this.published,
                category_title: this.title,
                category_description: this.description
            };
        },

        computed: {
            publish_status() {
                return this.is_published ? 'Published! This category is live and visible on the site.' : 'Not published. Use the switch on the right to publish this category.';
            }
        },

        methods: {
            updateCategory({title, description}) {
                this.category_title = title;
                this.category_description = description
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>