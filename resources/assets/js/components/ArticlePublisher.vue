<style></style>

<template>
    <div class="article-publisher-component flex flex-column justify-around items-center">
        <p class="b mb2">STATUS:</p>
        <p class="normal f6 mt0 mb4">{{ publish_status }}</p>

        <button class="btn" :disabled="saving" @click="update">
            <span v-show="!saving">{{ publish ? 'Retract' : 'Publish' }}</span>
            <div class="spinner" v-show=saving>
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </button>

        <div v-show="!publish" class="mt4">
            <p class="b tc mb2 ttu" for="publish-date-input">Publish Date: </p>
            <date-picker class="mb4" name="publish_date" v-model="publish_date" :clear-button="true"></date-picker>
        </div>
    </div>
</template>

<script type="text/babel">
    import moment from "moment";

    export default {

        props: {
            'initial-state': {
                type: Boolean,
                required: true
            },

            'article-id': {
                type: Number,
                required: true,
            },

            'published-on': {
                type: String,
                required: true
            }
        },

        data() {
            return {
                publish: null,
                publish_date: null,
                saving: false
            };
        },

        computed: {
            publish_status() {
                if (this.saving) {
                    return 'Saving...';
                }

                if (!this.publish) {
                    return 'This article is in draft mode';
                }

                if (this.publish && this.publish_date && moment(this.publish_date).isAfter()) {
                    return 'This article is published and will go live ' + moment(this.publish_date).fromNow();
                }

                return 'It is live.'
            }
        },

        mounted() {
            this.publish = this.initialState;
            this.publish_date = this.publishedOn;
        },

        methods: {

            update() {
                this.saving = true;
                this.publish ? this.retract() : this.publishArticle();
            },

            publishArticle() {
                axios.post(`/admin/published-articles`, this.publishData())
                    .then(() => this.publish = true)
                    .catch(err => console.log(err))
                    .then(() => this.saving = false);
            },

            retract() {
              axios.delete(`/admin/published-articles/${this.articleId}`)
                  .then(() => this.publish = false)
                  .catch(err => console.log(err))
                  .then(() => this.saving = false);
            },

            publishData() {
                if (moment(this.publish_date).isAfter(moment().endOf('day'))) {
                    return {
                        article_id: this.articleId,
                        publish_date: this.publish_date
                    };
                }

                return {
                    article_id: this.articleId
                };
            },
        }
    }
</script>