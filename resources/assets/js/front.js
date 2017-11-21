
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import swal from "sweetalert";
window.swal = swal;

import Flickity from "flickity-imagesloaded";
window.Flickity = Flickity;



Vue.component('modal', require('./components/Modal.vue'));
Vue.component('nested-menu', require('./components/NestedMenu.vue'));
Vue.component('product-list', require('./components/ProductsList.vue'));
Vue.component('store-locator', require('./components/Locator.vue'));


window.eventHub = new Vue();

const app = new Vue({
    el: '#app',

    created() {
        eventHub.$on('user-alert', this.showAlert)
    },

    methods: {
        showAlert(message) {
            swal({
                icon: message.type,
                title: message.title,
                text: message.text,
                button: message.confirm
            });
        }
    }
});
