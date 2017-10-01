<style>
    .article-info-form-component {
        display: inline-block;
    }
</style>

<template>
    <div class="article-info-form-component">
        <button class="dd-btn btn" @click="modalOpen = true">{{ buttonText }}</button>
        <modal :show="modalOpen" class="form-modal">
            <div slot="header">
                <h3>{{ formType === 'create' ? 'Create a Blog Post' : 'Edit this Post Info' }}</h3>
            </div>
            <div slot="body">
                <p class="lead text-danger" v-show="mainError">{{ mainError }}</p>
                <form action="" class="dd-form" @submit.stop.prevent="submit">
                    <div class="form-group mv3" :class="{'has-error': form.errors.title}">
                        <label class="b f6 ttu col-p"for="title">Title</label>
                        <span class="error-message" v-show="form.errors.title">{{ form.errors.title }}</span>
                        <input type="text" name="title" v-model="form.data.title" class="h2 input pl2 w-100">
                    </div>
                    <div class="form-group mv3" :class="{'has-error': form.errors.description}">
                        <label class="b f6 ttu col-p"for="description">Description</label>
                        <span class="error-message"
                              v-show="form.errors.description">{{ form.errors.description }}</span>
                        <textarea name="description" v-model="form.data.description" class="h4 input pl2 w-100"></textarea>
                    </div>
                    <div class="form-group mv3" :class="{'has-error': form.errors.intro}">
                        <label class="b f6 ttu col-p"for="intro">Intro</label>
                        <span class="error-message" v-show="form.errors.intro">{{ form.errors.intro }}</span>
                        <textarea name="intro" v-model="form.data.intro" class="h4 input pl2 w-100"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button class="dd-btn btn btn-grey" type="button" @click="modalOpen = false">Cancel</button>
                        <button class="btn dd-btn" type="submit" :disabled="waiting">
                            <span v-show="!waiting">{{ formType === 'create' ? 'Create Post' : 'Save Changes' }}</span>
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
    </div>
</template>

<script type="text/babel">
    import Form from "./Form";
    import formMixin from "./mixins/formMixin";

    export default {

        mixins: [formMixin],

        data() {
            return {
                form: new Form({
                    title: this.formAttributes.title || '',
                    description: this.formAttributes.description || '',
                    intro: this.formAttributes.intro || ''
                })
            };
        },

        methods: {
            canSubmit() {
                return this.form.title !== '';
            },

            getUpdatedDataFromResponseData(data) {
                return {
                    title: data.title,
                    description: data.description,
                    intro: data.intro
                };
            },

            getStoreActionEventName() {
                return 'created-article';
            },

            getUpdateActionEventName() {
                return 'updated-article-info';
            }
        }
    }
</script>