<template>
    <span>
        <button class="btn dd-btn" @click="openModal = true">Add</button>
        <modal :show="openModal" :wider="true">
            <div slot="header">
                <p>Add <strong class="ff-headline-small">{{ productName }}</strong> to: <span class="ff-headline-small">{{ current_stockable}}</span><span> ({{ current_stockable_type }})</span></p>
            </div>
            <div slot="body">
                <p></p>
                <div class="flex category-chooser items-stretch">
                    <div class="w-third">
                        <p class="b col-p">Category:</p>
                        <ul class="option-list list">
                            <li v-for="category in categories"
                                 :key="category.id"
                                 @click="selectCategory(category)"
                                 class="pb1"
                                 :class="{'selected': category === selected_category}"
                            >
                                <span>{{ category.title }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="w-third">
                        <p class="b col-p">Subcategory</p>
                        <p class="b col-gr" v-if="!subcategories.length">No options</p>
                        <ul class="option-list list">
                            <li v-for="subcategory in subcategories"
                                 :key="subcategory.id"
                                 @click="selectSubcategory(subcategory)"
                                 class="pb1"
                                 :class="{'selected': subcategory === selected_subcategory}"
                            >
                                <span>{{ subcategory.title }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="w-third">
                        <p class="b col-p">Tool Group</p>
                        <p class="b col-gr" v-if="!toolgroups.length">No options</p>
                        <ul class="option-list list">
                            <li v-for="toolgroup in toolgroups"
                                 :key="toolgroup.id"
                                 @click="selectToolgroup(toolgroup)"
                                 class="pb1"
                                 :class="{'selected': toolgroup === selected_toolgroup}"
                            >
                                <span>{{ toolgroup.title }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div slot="footer" class="flex justify-end">
                <button class="dd-btn btn btn-grey" type="button" @click="openModal = false">Cancel</button>
                <button class="btn dd-btn" type="button" :disabled="disable_button" @click="submit">
                    <span v-show="!waiting">Add</span>
                    <div class="spinner" v-show="waiting">
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
        props: ['categories', 'product-name', 'product-id'],

        data() {
            return {
                openModal: false,
                waiting: false,
                selected_category: null,
                selected_subcategory: null,
                selected_toolgroup: null,
                selected_level: null
            };
        },

        computed: {
            subcategories() {
                if (!this.selected_category) {
                    return [];
                }
                return this.selected_category.subcategories;
            },

            toolgroups() {
                if (!this.selected_subcategory) {
                    return [];
                }
                return this.selected_subcategory.toolgroups;
            },

            current_stockable_type() {
                return this.selected_level;
            },

            current_selection() {
                return this[`selected_${this.selected_level}`];
            },

            current_stockable() {

                if(this.selected_level === null) {
                    return 'Nothing selected';
                }

                return this.current_selection.title;
            },

            post_url() {
                switch (this.selected_level) {
                    case 'category':
                        return `categories/${this.selected_category.id}`;
                        break;
                    case 'subcategory':
                        return `subcategories/${this.selected_subcategory.id}`;
                        break;
                    case 'toolgroup':
                        return `tool-groups/${this.selected_toolgroup.id}`;
                        break;
                    default:
                        return ''
                }
            },

            disable_button() {
                return this.waiting || (!this.selected_category);
            }
        },

        methods: {
            selectCategory(category) {
                this.selected_toolgroup = null;
                this.selected_subcategory = null;
                this.selected_category = category;
                this.selected_level = 'category';
            },

            selectSubcategory(subcategory) {
                this.selected_toolgroup = null;
                this.selected_subcategory = subcategory;
                this.selected_level = 'subcategory';
            },

            selectToolgroup(toolgroup) {
                this.selected_toolgroup = toolgroup;
                this.selected_level = 'toolgroup';
            },

            submit() {
                if(!this.current_selection) {
                    return;
                }
                this.waiting = true;
                axios.post(`/admin/stockables/${this.post_url}`, {product_id: this.productId})
                    .then(({data}) => this.$emit('product-parents-updated', data))
                    .catch(err => eventHub.$emit('user-error', 'Unable to process. Please refresh and retry.'))
                    .then(() => this.waiting = false)
                    .then(() => this.openModal = false);
            }


        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

    .option-list {
        height: 280px;
        overflow-y: auto;

        span {
            padding: 2px;
        }

        .selected span {
            background: #22D17D;
        }
    }

</style>