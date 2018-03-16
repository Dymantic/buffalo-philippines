<template>
    <span>
    <button @click="modalOpen = true"
            class="btn"
    >{{ buttonText }}</button>
        <modal :show="modalOpen"
               class="form-modal">
            <div slot="header">
                <h3>{{ formType === 'create' ? 'Add a New Location' : 'Edit this Location' }}</h3>
            </div>
            <div slot="body">
                <p class="f4 col-r"
                   v-show="mainError">{{ mainError }}</p>
                <form action=""
                      class=""
                      @submit.stop.prevent="submit">
                    <div class="form-group mv3"
                         :class="{'has-error': form.errors.name}">
                        <label class="f6 ttu col-p"
                               for="name">Name</label>
                        <span class="f6 col-r"
                              v-show="form.errors.name">{{ form.errors.name }}</span>
                        <input type="text"
                               name="name"
                               v-model="form.data.name"
                               class="w-100 input h2 pl2">
                    </div>
                    <div class="form-group mv3"
                         :class="{'has-error': form.errors.address}">
                        <label class="f6 ttu col-p"
                               for="address">Address</label>
                        <span class="f6 col-r"
                              v-show="form.errors.address">{{ form.errors.address }}</span>
                        <input type="text"
                               name="address"
                               v-model="form.data.address"
                               class="w-100 input h2 pl2">
                    </div>
                    <div class="modal-form-button-bar w-100 flex justify-end">
                        <button class="btn btn-grey"
                                type="button"
                                @click="modalOpen = false">Cancel</button>
                        <button class="btn"
                                type="submit"
                                :disabled="waiting">
                            <span v-show="!waiting">{{ formType === 'create' ? 'Add Location' : 'Save Changes' }}</span>
                            <div class="spinner"
                                 v-show="waiting">
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
    import Form from "./Form";
    import formMixin from "./mixins/formMixin";

    export default {

        mixins: [formMixin],

        data() {
            return {
                form: new Form({
                    name: this.formAttributes.name || '',
                    address: this.formAttributes.address || ''
                })
            };
        },

        methods: {

            canSubmit() {
                return this.form.data.name !== '';
            },

            getUpdatedDataFromResponseData({name, address}) {
                return {
                    name,
                    address
                };
            },

            getStoreActionEventName() {
                return 'location-created';
            },

            getUpdateActionEventName() {
                return 'location-updated';
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>