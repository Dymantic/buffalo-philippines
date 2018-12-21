<template>
    <div class="mw6">
        <form action="/distributors/applications"
              method="POST"
              @submit.prevent="submit">
            <div class="form-group mv3">
                <label class="f6 ttu col-w strong-type mb1 db"
                       for="name">Name:</label>
                <span class="col-r f7">{{ form.errors.name }}</span>
                <input type="text"
                       class="w-100 ba b--white-30 col-w h2 pl2 col-d-bg"
                       name="name"
                       id="name"
                       v-model="form.data.name">
            </div>
            <div class="form-group mv3">
                <label class="f6 ttu col-w strong-type mb1 db"
                       for="email">Email:</label>
                <span class="col-r f7">{{ form.errors.email }}</span>
                <input type="email"
                       class="w-100 ba b--white-30 col-w h2 pl2 col-d-bg"
                       name="email"
                       id="email"
                       v-model="form.data.email">
            </div>
            <div class="form-group mv3">
                <label class="f6 ttu col-w strong-type mb1 db"
                       for="country">country:</label>
                <span class="col-r f7">{{ form.errors.country }}</span>
                <input type="text"
                       class="w-100 ba b--white-30 col-w h2 pl2 col-d-bg"
                       name="country"
                       id="country"
                       v-model="form.data.country">
            </div>
            <div class="form-group mv3">
                <label class="f6 ttu col-w strong-type mb1 db"
                       for="company">company:</label>
                <span class="col-r f7">{{ form.errors.company }}</span>
                <input type="text"
                       class="w-100 ba b--white-30 col-w h2 pl2 col-d-bg"
                       name="company"
                       id="company"
                       v-model="form.data.company">
            </div>
            <div class="form-group mv3">
                <label class="f6 ttu col-w strong-type mb1 db"
                       for="website">company website:</label>
                <span class="col-r f7">{{ form.errors.website }}</span>
                <input type="text"
                       class="w-100 ba b--white-30 col-w h2 pl2 col-d-bg"
                       name="website"
                       id="website"
                       v-model="form.data.website">
            </div>
            <div>
                <label class="f6 ttu col-w strong-type mb1 db"
                       for="application_message">Message:</label>
                <span class="col-r f7">{{ form.errors.application_message }}</span>
                <textarea name="application_message"
                          class="ba b--white-30 col-w col-d-bg h4 w-100 pa2"
                          id="application_message"
                          v-model="form.data.application_message"></textarea>
            </div>
            <div class="mt3">
                <span class="f6 ttu col-d strong-type col-w mv2">How did you hear about us?</span>
                <div class="mv2 flex flex-wrap justify-around">
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="google"
                               value="google"
                               v-model="form.data.referrer">
                        <label class="col-w" for="google">google</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="exhibition"
                               value="exhibition"
                               v-model="form.data.referrer">
                        <label class="col-w" for="exhibition">exhibition</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="taiwan_trade"
                               value="taiwan trade"
                               v-model="form.data.referrer">
                        <label class="col-w" for="taiwan_trade">taiwan trade</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="social_media"
                               value="social media"
                               v-model="form.data.referrer">
                        <label class="col-w" for="social_media">social media</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="other"
                               value="other"
                               v-model="form.data.referrer">
                        <label class="col-w" for="other">other</label>
                    </div>
                </div>
                <div class="h2">
                    <input type="text"
                           placeholder="Please tell us how you heard about us"
                           name="referrer_other"
                           id="referrer_other"
                           class="w-100 ba b--white-30 col-w h2 pl2 col-d-bg"
                           v-show="form.data.referrer === 'other'"
                           v-model="form.data.referrer_other">
                </div>
            </div>
            <div>
                <button type="submit"
                        :disabled="waiting"
                        class="ff-sub-headline mt4 link center db flex items-center justify-center hv-col-pd col-d-bg pv2 col-p bn"
                >
                    <span>Send Application</span>
                    <span>
                        <svg class="icon ih4 ml3 pt1"
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
    export default {
        data() {
            return {
                waiting: false,
                form: {
                    data: {
                        name: '',
                        email: '',
                        country: '',
                        company: '',
                        website: '',
                        application_message: '',
                        referrer: '',
                        referrer_other: ''
                    },
                    errors: {
                        name: '',
                        email: '',
                        country: '',
                        company: '',
                        website: '',
                        application_message: '',
                        referrer: '',
                        referrer_other: ''
                    }
                }
            };
        },

        methods: {
            submit() {
                this.clearErrors();
                this.waiting = true;
                axios.post('/distributors/applications', this.form.data)
                     .then(({data}) => this.handleSuccess(data))
                     .catch(this.handleError)
                    .then(() => this.waiting = false);
            },

            handleSuccess(data) {
                swal({
                    title: 'Success!',
                    text: `Thank you ${this.form.data.name}. We will be in touch soon.`,
                    icon: 'success'
                }).then(() => this.clearForm());
            },

            handleError(err) {
                if (err.response.status === 422) {
                    return this.showValidationErrors(err.response.data.errors);
                }

                swal({
                    icon: 'error',
                    title: 'Oh dear!',
                    text: 'Something went wrong. Please refresh your page and retry. Thanks.'
                });
            },

            showValidationErrors(messages) {
                const fields = Object.keys(messages);
                fields.forEach(field => {
                    this.form.errors[field] = messages[field][0];
                });

                const error_fields = Object.keys(messages).map(f => f.replace('application_', '')).join(', ');

                swal({
                    title: 'Almost there',
                    text: `Please correct the following fields: ${error_fields}`,
                    icon: 'warning'
                })


            },

            clearErrors() {
                Object.keys(this.form.errors).forEach(field => {
                    this.form.errors[field] = '';
                })
            },

            clearForm() {
                this.form = {
                    data: {
                        name: '',
                        email: '',
                        country: '',
                        company: '',
                        website: '',
                        application_message: '',
                        referrer: '',
                        referrer_other: ''
                    },
                    errors: {
                        name: '',
                        email: '',
                        country: '',
                        company: '',
                        website: '',
                        application_message: '',
                        referrer: '',
                        referrer_other: ''
                    }
                }
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">
    .radio-box {
        margin: .5rem;
        input {
            display: none;
        }

        label {
            position: relative;
            text-transform: capitalize;
        }

        label::after {
            content: '';
            display: inline-block;
            vertical-align: middle;
            margin-left: 1rem;
            border: 1px solid #22d17d;
            width: 1rem;
            height: 1rem;
            border-radius: 4px;

        }

        input:checked + label::after {
            background: #22d17d;
        }
    }

    button[type=submit]:disabled {
        opacity: .5;
    }
</style>