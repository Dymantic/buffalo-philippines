<template>
    <div>
        <div class="flex justify-between items-center">
            <h1 class="f1 normal">{{ title }}</h1>
            <div class="flex justify-end items-center">
                <product-form :url="`/admin/products/${itemAttributes.id}`"
                              form-type="update"
                              button-text="edit"
                              :form-attributes="itemAttributes"
                              @updated-product="update"
                ></product-form>
                <delete-modal :url="`/admin/products/${itemAttributes.id}`"
                              :redirect="true"
                              :item-name="title"
                ></delete-modal>
            </div>
        </div>
        <div class="card mv3">
            <div class="flex justify-between items-center">
                <div class="w-50">
                    <p class="ttu col-p f6">Product Code</p>
                    <p>{{ code }}</p>
                </div>
                <div class="w-50">
                    <p class="ttu col-p f6">Product Price</p>
                    <p>{{ formatted_price }}</p>
                </div>
            </div>
            <p class="ttu col-p f6">Description</p>
            <p>{{ description }}</p>
        </div>
        <div class="card mv3">
            <p class="ttu col-p f6">Belongs to</p>
            <p v-for="parent in parents"><a :href="parentLink(parent)"
                                            class="link b col-d">({{ parent.type }}) {{ parent.title }}</a></p>
            <div>
                <add-stock :categories="categoryList"
                           :product-id="itemAttributes.id"
                           :product-name="title"
                           @product-parents-updated="updateParents"
                ></add-stock>
            </div>
        </div>
        <div class="card mv3">
            <p class="ttu f6 col-p">Published</p>
            <div class="flex justify-between items-center mr4">
                <p>{{ publish_status }}</p>
                <toggle-switch :toggle-state="itemAttributes.published"
                               label-text="Publish"
                               :on-payload="{product_id: itemAttributes.id}"
                               on-url="/admin/published-products"
                               :off-url="`/admin/published-products/${itemAttributes.id}`"
                               @toggled-state="(state) => this.published = state"
                               unique="pub_switch"
                ></toggle-switch>
            </div>
        </div>
        <div class="card mv3">
            <p class="ttu f6 col-p">Featured</p>
            <div class="flex justify-between items-center mr4">
                <p>{{ feature_status }}</p>
                <toggle-switch :toggle-state="itemAttributes.featured"
                               label-text="Feature"
                               :on-payload="{product_id: itemAttributes.id}"
                               on-url="/admin/featured-products"
                               :off-url="`/admin/featured-products/${itemAttributes.id}`"
                               @toggled-state="(state) => this.featured = state"
                               unique="feat_switch"
                ></toggle-switch>
            </div>
        </div>
        <div class="card mv3">
            <p class="ttu col-p f6">New Product Status</p>
            <div class="flex justify-between items-center">
                <div class="w-60">
                    <p>{{ new_status }}</p>
                </div>
                <div class="w-40 flex justify-end">
                    <button v-show="!edit_new"
                            @click.prevent="edit_new = true"
                            class="btn">Edit
                    </button>
                    <form v-show="edit_new"
                          action=""
                          @submit.prevent="updateNewUntil">
                        <span>Add </span>
                        <input type="number"
                               class="new_more_days"
                               v-model="new_days">
                        <span> days</span>
                        <button class="btn"
                                type="submit"
                                :disabled="new_days === 0">
                            <span v-show="!wait_on_new">Go!</span>
                            <div class="spinner"
                                 v-show="wait_on_new">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="flex justify-between">
            <div class="card mv3 mr3 w-50">
                <p class="ttu f6 col-p">Writeup</p>
                <p v-html="nl2br(writeup)"></p>
            </div>
            <div class="card mv3 ml3 w-50">
                <p class="ttu col-p f6">Main Image</p>
                <p class="mv4">Product images should be at least 300px wide and 300px tall. A square shape is best, on a
                               white background.</p>
                <image-upload :default="itemAttributes.main_image.web"
                              :url="`/admin/products/${itemAttributes.id}/main-image`"
                              size="preview"
                              :preview-width="350"
                              :preview-height="350"
                              :unique="itemAttributes.id"
                              :delete-url="`/admin/products/${itemAttributes.id}/main-image`"
                ></image-upload>
            </div>
        </div>
        <div class="card mv3">
            <div class="flex justify-between items-center">
                <p class="ttu col-p f6">Gallery Images</p>
                <a :href="`/admin/products/${itemAttributes.id}/gallery`"
                   class="link btn">Edit</a>
            </div>
            <p v-show="!itemAttributes.gallery_images.length">This product has no gallery images</p>
            <div>
                <img v-for="gal_img in itemAttributes.gallery_images"
                     :key="gal_img.id"
                     :src="gal_img.thumb"
                     alt=""
                     class="w3 h3 ma3">
            </div>
        </div>
    </div>
</template>

<script type="text/babel">

    import textFormat from "./mixins/textFormat";

    export default {

        mixins: [textFormat],

        props: ['item-attributes', 'category-list'],

        data() {
            return {
                title: this.itemAttributes.title || '',
                code: this.itemAttributes.code || '',
                description: this.itemAttributes.description || '',
                writeup: this.itemAttributes.writeup || '',
                price: this.itemAttributes.price || '',
                parents: this.itemAttributes.parents || [],
                published: this.itemAttributes.published || '',
                featured: this.itemAttributes.featured || '',
                is_new: this.itemAttributes.is_new || '',
                new_until: this.itemAttributes.new_until || '',
                new_days: 0,
                edit_new: false,
                wait_on_new: false
            };
        },

        computed: {
            formatted_price() {
                return this.price ? this.price : 'Not set';
            },

            publish_status() {
                return this.published ?
                    'Published! This product is live and visible on the site.' :
                    'Not published. Toggle the switch on the right to publish this product.';
            },

            feature_status() {
                return this.featured ?
                    'Featured! This product will be included in the featured products group.' :
                    'Not featured. Toggle the switch on the right to feature this product.';
            },

            new_status() {
                return this.is_new ?
                    `Marked as New! This product will be shown as new until ${this.new_until}` :
                    'This product is no longer new. You can edit its status on the right.';
            }
        },

        methods: {

            update(updated_data) {
                this.title = updated_data.title;
                this.code = updated_data.code;
                this.description = updated_data.description;
                this.writeup = updated_data.writeup;
                this.price = updated_data.price;
            },

            updateNewUntil() {
                this.wait_on_new = true;
                axios.post(`/admin/products/${this.itemAttributes.id}/new-until-date`, {add_days: this.new_days})
                     .then(({data}) => this.updateNewDateSuccess(data))
                     .catch(() => this.updateNewDateFailed());
            },

            updateNewDateSuccess({is_new, new_until}) {
                this.is_new = is_new;
                this.new_until = new_until;
                this.wait_on_new = false;
                this.edit_new = false;
                this.new_days = 0;
            },

            updateNewDateFailed() {
                this.wait_on_new = false;

                eventHub.$emit('user-error', 'Unable to update product. Please refresh and try again.');
            },

            parentLink(parent) {
                switch (parent.type) {
                    case 'Category':
                        return `/admin/categories/${parent.id}`;
                    case 'Subcategory':
                        return `/admin/subcategories/${parent.id}`;
                    case 'Tool Group':
                        return `/admin/tool-groups/${parent.id}`;
                    default:
                        return '#';
                }
            },

            updateParents({parents}) {
                this.parents = parents;
            }
        }

    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

    .new_more_days {
        width: 50px;
    }

    button[disabled] {
        opacity: .5;
    }
</style>