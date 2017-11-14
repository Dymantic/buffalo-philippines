<template>
    <span>
        <button class="btn" @click="modalOpen = true">{{ buttonText }}</button>
        <modal :show="modalOpen">
            <div slot="header">
                <p>{{ formType === 'create' ? `Add a new ${resourceType}` : `Edit this ${resourceType}` }}</p>
            </div>
            <div slot="body">
                <form action="" @submit.stop.prevent="submit">
                    <p class="lead text-danger" v-show="mainError">{{ mainError }}</p>
                    <div class="form-group mv3" :class="{'has-error': form.errors.title}">
                        <label class="f6 ttu col-p" for="title">Title</label>
                        <span class="f6 col-r" v-show="form.errors.title">{{ form.errors.title }}</span>
                        <input type="text" name="title" v-model="form.data.title" class="w-100 input h2 pl2">
                    </div>
                    <div class="form-group mv3" :class="{'has-error': form.errors.description}">
                        <label class="f6 ttu col-p" for="description">Description</label>
                        <span class="f6 col-r" v-show="form.errors.description">{{ form.errors.description }}</span>
                        <textarea name="description"
                                  v-model="form.data.description"
                                  class="h4 w-100 pa2"
                        ></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button class="btn btn-grey" type="button" @click="modalOpen = false">Cancel</button>
                        <button class="btn" type="submit" :disabled="waiting">
                            <span v-show="!waiting">{{ formType === 'create' ? `Create ${resourceType}` : 'Save Changes' }}</span>
                            <div class="spinner" v-show="waiting">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
            <div slot="footer"></div>
        </modal>
    </span>
</template>

<script type="text/babel">
    import formMixin from "./mixins/formMixin";
    import Form from "./Form";
    
    export default {

        mixins: [formMixin],

        props: {
            'resource-type': {
                type: String,
                required: false,
                default: 'category'
            }
        },

        data() {
            return {
                form: new Form({
                    title: this.formAttributes.title || '',
                    description: this.formAttributes.description || ''
                })
            };
        },

        methods: {
            canSubmit() {
                return true;
            },

            getUpdatedDataFromResponseData(updated_data) {
                return {title: updated_data.title, description: updated_data.description};
            },

            getStoreActionEventName() {
                return `created-${this.resourceType}`;
            },

            getUpdateActionEventName() {
                return `updated-${this.resourceType}`;
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>