<template>
    <span>
        <button class="btn dd-btn btn-red"
                @click="openModal = true">Remove</button>
        <modal :show="openModal"
               :wider="true">
            <div slot="header">
                <p>Remove <strong class="ff-headline-small">{{ productName }}</strong> from <span class="ff-headline-small">{{ selected_group_title }}</span></p>
            </div>
            <div slot="body">
                <p>Select a parent group from which you would like to remove this product. This will never delete a product, only remove it fom the chosen group.</p>
                <div>
                    <div v-for="(parent, index) in parents"
                         :key="index"
                         class="mv2 pa2 ba">
                        <label :for="`parent_${index}`">
                            <input :id="`parent_${index}`"
                                   type="radio"
                                   :value="index"
                                   v-model="selected_index">
                            <span v-html="parentBreadcrumbs(parent)"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div slot="footer"
                 class="flex justify-end">
                <button class="dd-btn btn btn-grey"
                        type="button"
                        @click="openModal = false">Cancel</button>
                <button class="btn dd-btn btn-red"
                        type="button"
                        :disabled="disable_button"
                        @click="submit">
                    <span v-show="!waiting">Remove</span>
                    <div class="spinner"
                         v-show="waiting">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </button>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {

        props: ['parents', 'product-name', 'product-id'],

        data() {
            return {
                openModal: false,
                waiting: false,
                selected_index: null
            };
        },

        computed: {
            disable_button() {
                return this.waiting || (this.selected_index === null);
            },

            selected_group_title() {
                if (this.selected_index === null) {
                    return 'a parent';
                }

                return this.parents[this.selected_index] ? this.parents[this.selected_index].title : '';
            },

            delete_url() {
                if(this.selected_index === null) {
                    return;
                }

                const selected_parent = this.parents[this.selected_index];
                switch (selected_parent.type) {
                    case 'Category':
                        return `/admin/stockables/categories/${selected_parent.id}/products/${this.productId}`;
                        break;
                    case 'Subcategory':
                        return `/admin/stockables/subcategories/${selected_parent.id}/products/${this.productId}`;
                        break;
                    case 'ToolGroup':
                        return `/admin/stockables/tool-groups/${selected_parent.id}/products/${this.productId}`;
                        break;
                    default:
                        return ''
                }
            }
        },

        methods: {
            parentBreadcrumbs(parent) {
                let html = this.stockableTitle(parent);

                if (parent.parent) {
                    html = `${this.stockableTitle(parent.parent)} >> ${html}`;
                }

                if (parent.parent && parent.parent.parent) {
                    html = `${this.stockableTitle(parent.parent.parent)} >> ${html}`;
                }

                return html;
            },

            stockableTitle(stockable) {
                return `<span class="b">${stockable.title}</span> <small>(${stockable.type})</small>`
            },

            submit() {
                if(this.selected_index === null) {
                    return;
                }
                this.waiting = true;
                axios.delete(this.delete_url)
                    .then(({data}) => this.$emit('product-parents-updated', data))
                    .catch(() => eventHub.$emit('user-error', 'Failed to remove. Please refresh and retry.'))
                    .then(() => this.waiting = false)
                    .then(() => this.openModal = false);
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>