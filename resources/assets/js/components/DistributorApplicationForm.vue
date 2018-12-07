<template>
    <div class="mw6">
        <form action="/distributors/applications"
              method="POST"
              @submit.prevent="submit">
            <div class="form-group mv3">
                <label class="f6 ttu col-d strong-type"
                       for="name">Name:</label>
                <span class="col-r f7">{{ form.errors.name }}</span>
                <input type="text"
                       class="w-100 ba b--black-30 h2 pl2"
                       name="name"
                       id="name"
                       v-model="form.data.name">
            </div>
            <div class="form-group mv3">
                <label class="f6 ttu col-d strong-type"
                       for="email">Email:</label>
                <span class="col-r f7">{{ form.errors.email }}</span>
                <input type="email"
                       class="w-100 ba b--black-30 h2 pl2"
                       name="email"
                       id="email"
                       v-model="form.data.email">
            </div>
            <div class="form-group mv3">
                <label class="f6 ttu col-d strong-type"
                       for="country">country:</label>
                <span class="col-r f7">{{ form.errors.country }}</span>
                <input type="text"
                       class="w-100 ba b--black-30 h2 pl2"
                       name="country"
                       id="country"
                       v-model="form.data.country">
            </div>
            <div class="form-group mv3">
                <label class="f6 ttu col-d strong-type"
                       for="company">company:</label>
                <span class="col-r f7">{{ form.errors.company }}</span>
                <input type="text"
                       class="w-100 ba b--black-30 h2 pl2"
                       name="company"
                       id="company"
                       v-model="form.data.company">
            </div>
            <div class="form-group mv3">
                <label class="f6 ttu col-d strong-type"
                       for="website">website:</label>
                <span class="col-r f7">{{ form.errors.website }}</span>
                <input type="text"
                       class="w-100 ba b--black-30 h2 pl2"
                       name="website"
                       id="website"
                       v-model="form.data.website">
            </div>
            <div>
                <label class="f6 ttu col-d strong-type"
                       for="application_message">Message:</label>
                <span class="col-r f7">{{ form.errors.application_message }}</span>
                <textarea name="application_message"
                          class="ba b--black-30 h4 w-100 pa2"
                          id="application_message"
                          v-model="form.data.application_message"></textarea>
            </div>
            <div>
                <span class="f6 ttu col-d strong-type mv2">How did you hear about us?</span>
                <div class="mv2 flex flex-wrap justify-around">
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="google"
                               value="google"
                               v-model="form.data.referrer">
                        <label for="google">google</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="exhibition"
                               value="exhibition"
                               v-model="form.data.referrer">
                        <label for="exhibition">exhibition</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="taiwan_trade"
                               value="taiwan trade"
                               v-model="form.data.referrer">
                        <label for="taiwan_trade">taiwan trade</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="social_media"
                               value="social media"
                               v-model="form.data.referrer">
                        <label for="social_media">social_media</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio"
                               name="referrer"
                               id="other"
                               value="other"
                               v-model="form.data.referrer">
                        <label for="other">other</label>
                    </div>
                </div>
                <div>
                    <input type="text"
                           placeholder="Please tell us how you heard about us"
                           name="referrer_other"
                           id="referrer_other"
                           v-show="form.data.referrer === 'other'"
                           v-model="form.data.referrer_other">
                </div>
            </div>
            <div>
                <button type="submit"
                        :disabled="waiting"
                        class="ff-sub-headline mt4 link center db flex items-center justify-center hv-col-pd col-w-bg pv2 col-p bn"
                >
                    <span>Apply</span>
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
                        name: 'Mooz',
                        email: 'joyner.michael@gmail.com',
                        country: 'South Africa',
                        company: 'Dymantic Design',
                        website: 'https://dymanticdesign.com',
                        application_message: 'Hey Jude',
                        referrer: 'google',
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
                    title: 'Boom baby!',
                    text: 'You posted te shit out of that'
                }).then(() => console.log('done'));
            },

            handleError(err) {
                if (err.response.status === 422) {
                    return this.showValidationErrors(err.response.data.errors);
                }

                swal({
                    icon: 'error',
                    title: 'Dumb Ass',
                    text: 'You managed to fuck up a simple form'
                });
            },

            showValidationErrors(messages) {
                const fields = Object.keys(messages);
                fields.forEach(field => {
                    this.form.errors[field] = messages[field][0];
                })

                swal({
                    title: 'Almost there',
                    text: `Please correct the following fields: ${fields.join(', ')}`,
                    icon: 'warning'
                })


            },

            clearErrors() {
                Object.keys(this.form.errors).forEach(field => {
                    this.form.errors[field] = '';
                })
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
            border: 1px solid #333;
            width: 1rem;
            height: 1rem;

        }

        input:checked + label::after {
            background: #333;
        }
    }

    button[type=submit]:disabled {
        opacity: .5;
    }
</style>