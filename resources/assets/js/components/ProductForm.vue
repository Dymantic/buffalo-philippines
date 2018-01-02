<template>
    <span>
        <button class="btn" @click="modalOpen = true">{{ buttonText }}</button>
        <modal :show="modalOpen" :wider="true">
            <div slot="header">
                <p>{{ formType === 'create' ? `Add a new product` : `Edit this product` }}</p>
            </div>
            <div slot="body">
                <form action="" @submit.stop.prevent="submit" class="ph2">
                    <p class="lead text-danger" v-show="mainError">{{ mainError }}</p>
                    <div class="form-group mv3" :class="{'has-error': form.errors.title}">
                        <label class="f6 ttu col-p" for="title">Title</label>
                        <span class="f6 col-r" v-show="form.errors.title">{{ form.errors.title }}</span>
                        <input type="text" name="title" v-model="form.data.title" class="w-100 input h2 pl2">
                    </div>
                    <div class="form-group mv3" :class="{'has-error': form.errors.code}">
                        <label class="f6 ttu col-p" for="code">Code</label>
                        <span class="f6 col-r" v-show="form.errors.code">{{ form.errors.code }}</span>
                        <input type="text" name="code" v-model="form.data.code" class="w-100 input h2 pl2">
                    </div>
                    <div class="form-group mv3" :class="{'has-error': form.errors.price}">
                        <label class="f6 ttu col-p" for="price">Price</label>
                        <span class="f6 col-r" v-show="form.errors.price">{{ form.errors.price }}</span>
                        <input type="text" name="price" v-model="form.data.price" class="w-100 input h2 pl2">
                    </div>
                    <div class="form-group mv3" :class="{'has-error': form.errors.description}">
                        <label class="f6 ttu col-p" for="description">Description</label>
                        <span class="f6 col-r" v-show="form.errors.description">{{ form.errors.description }}</span>
                        <textarea name="description"
                                  v-model="form.data.description"
                                  class="h4 w-100 pa2"></textarea>
                    </div>
                    <div class="form-group mv3" :class="{'has-error': form.errors.writeup}">
                        <label class="f6 ttu col-p" for="writeup">Writeup</label>
                        <span class="f6 col-r" v-show="form.errors.writeup">{{ form.errors.writeup }}</span>
                        <wysiwyg-editor name="writeup" v-model="form.data.writeup"></wysiwyg-editor>
                    </div>
                    <div class="flex justify-end">
                        <button class="btn btn-grey" type="button" @click="modalOpen = false">Cancel</button>
                        <button class="btn" type="submit" :disabled="waiting">
                            <span v-show="!waiting">{{ formType === 'create' ? `Create product` : 'Save Changes' }}</span>
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

        data() {
            return {
                form: new Form({
                    title: this.formAttributes.title || '',
                    code: this.formAttributes.code || '',
                    price: this.formAttributes.price || '',
                    description: this.formAttributes.description || '',
                    writeup: this.formAttributes.writeup || ''
                })
            };
        },

        methods: {
            canSubmit() {
                return true;
            },

            getUpdatedDataFromResponseData(response) {
                return {
                    title: response.title,
                    code: response.code,
                    price: response.price,
                    description: response.description,
                    writeup: response.writeup
                };
            },

            getStoreActionEventName() {
                return `created-product`;
            },

            getUpdateActionEventName() {
                return `updated-product`;
            }

        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>