<template>
    <div>
        <form action=""
              @submit.stop.prevent="submit">
            <p></p>
            <div class="form-group mv3"
                 :class="{'has-error': form.errors.name}">
                <label class="f6 ttu col-d strong-type"
                       for="name">Name</label>
                <span class="f6 col-r"
                      v-show="form.errors.name">{{ form.errors.name }}</span>
                <input type="text"
                       name="name"
                       v-model="form.data.name"
                       class="w-100 ba b--black-30 h2 pl2">
            </div>
            <div class="form-group mv3"
                 :class="{'has-error': form.errors.email}">
                <label class="f6 ttu col-d strong-type"
                       for="email">Email</label>
                <span class="f6 col-r"
                      v-show="form.errors.email">{{ form.errors.email }}</span>
                <input type="email"
                       name="email"
                       v-model="form.data.email"
                       class="w-100 ba b--black-30 h2 pl2">
            </div>
            <div class="form-group mv3"
                 :class="{'has-error': form.errors.enquiry}">
                <label class="f6 ttu col-d strong-type"
                       for="enquiry">Your Enquiry</label>
                <span class="f6 col-r"
                      v-show="form.errors.enquiry">{{ form.errors.enquiry }}</span>
                <textarea name="enquiry"
                          v-model="form.data.enquiry"
                          class="ba b--black-30 h4 w-100 pa2"></textarea>
            </div>
            <div class="form-group mv3">
                <button type="submit"
                        :disabled="waiting"
                        class="f3 strong-type mt4 link center db flex items-center justify-center ttu col-w-bg pv2 col-d bn"
                >
                    <span>{{ button_msg }}</span>
                    <span>
                        <svg class="icon icon-d ih3 ml3 pt1"
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 22 22">
    <path class="colour-fill"
          d="M11.69,15.67a.31.31,0,0,1-.25.13H8a.31.31,0,0,1-.25-.49l3-4.12a.31.31,0,0,0,0-.36l-3-4.14A.31.31,0,0,1,8,6.2h3.4a.31.31,0,0,1,.25.13l3.24,4.1a.91.91,0,0,1,0,1.13Z"></path>
    <path class="colour-fill"
          d="M19.35,0H2.65A2.65,2.65,0,0,0,0,2.65v16.7A2.65,2.65,0,0,0,2.65,22h16.7A2.65,2.65,0,0,0,22,19.35V2.65A2.65,2.65,0,0,0,19.35,0Zm-1,19H3.66A.66.66,0,0,1,3,18.34V3.66A.66.66,0,0,1,3.66,3H18.34a.66.66,0,0,1,.66.66V18.34A.66.66,0,0,1,18.34,19Z"></path>
</svg>
                    </span>
                </button>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
    import formMixin from "./mixins/formMixin";
    import Form from "./Form";

    export default {

        mixins: [formMixin],

        data() {
            return {
                form: new Form({
                    name: '',
                    email: '',
                    enquiry: ''
                })
            };
        },

        computed: {
          button_msg() {
              return this.waiting ? 'Sending...' : 'Send Enquiry';
          }
        },

        methods: {
            canSubmit() {
                const missing_fields = ['name', 'email', 'enquiry'].filter(field => this.form.data[field] === '');

                if(missing_fields.length) {
                    this.alertMissingFields(missing_fields);

                    return false;
                }

                return true;
            },

            alertMissingFields(fields) {
                return eventHub.$emit('user-warning', `Please complete the following fields: ${fields.join(', ')}`);
            },

            getUpdatedDataFromResponseData() {

            },

            getStoreActionEventName() {
                return 'enquiry-submitted';
            },

            getUpdateActionEventName() {
                return 'enquiry-updated';
            },

            handleFailure() {
                eventHub.$emit('user-error', 'Unable to send your message. Please refresh the page and try again later.');
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

    textarea {
        resize: none;
    }

    button[disabled] {
        opacity: .2;
    }

    .form-group.has-error {
        input, textarea {
            border-color: indianred;
        }
    }

</style>