<style></style>

<template>
    <span class="delete-modal-button-component">
        <button class="btn btn-red" @click="modalOpen = true">Delete</button>
        <modal :show="modalOpen" class="form-modal">
            <div slot="header">
                <h3>Are you sure?</h3>
            </div>
            <div slot="body">
                <p v-show="!hasError">You are about to delete {{ itemName }}. You may not be able to undo this action. Are you sure you want to proceed?</p>
                <p v-show="hasError">There was a problem deleting the item. Please refresh the page and try again.</p>
                <form :action="url" method="POST" @submit="submit($event)">
                    <input type="hidden" name="_token" :value="token">
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="mv4 flex justify-end">
                        <button class="btn btn-grey" type="button" @click="modalOpen = false">Cancel</button>
                        <button class="btn btn-red" type="submit" :disabled="waiting">
                            <span v-show="!waiting">Delete it!</span>
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
    export default {

        props: ['item-name', 'redirect', 'url'],

        data() {
            return {
                modalOpen: false,
                hasError: false,
                waiting: false,
            };
        },

        computed: {
            token() {
                return document.querySelector('#csrf-token-meta').content;
            }
        },

        methods: {
            submit(ev) {
                if(this.redirect) {
                    return true;
                }

                ev.preventDefault();

                this.hasError = false;
                this.waiting = true;

                axios.delete(this.url)
                    .then(() => this.onSuccess())
                    .catch(() => this.handleError())
                    .then(() => this.waiting = false);
            },

            onSuccess() {
                this.$emit('item-deleted');
                this.modalOpen = false;
            },

            handleError() {
                this.hasError = true;
            }
        }
    }
</script>