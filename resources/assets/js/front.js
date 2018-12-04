
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import swal from "sweetalert";
window.swal = swal;

import jump from "jump.js";
import {throttle} from "lodash";


Vue.component('modal', require('./components/Modal.vue'));
Vue.component('nested-menu', require('./components/NestedMenu.vue'));
Vue.component('products-list', require('./components/ProductsList.vue'));
Vue.component('show-category', require('./components/ShowCategory'));
Vue.component('store-locator', require('./components/Locator.vue'));
Vue.component('contact-form', require('./components/ContactForm.vue'));
Vue.component('search-bar', require('./components/SearchBar.vue'));
Vue.component('related-products', require('./components/RelatedProducts.vue'));
Vue.component('image-gallery', require('./components/ProductImageGallery'));
Vue.component('distributor-map', require('./components/WorldMap'));


window.eventHub = new Vue();

const app = new Vue({
    el: '#app',

    created() {
        eventHub.$on('user-alert', this.showAlert);
        eventHub.$on('user-warning', this.showWarning);
        eventHub.$on('user-error', this.showError);
    },

    methods: {
        showAlert(message) {
            swal({
                icon: message.type,
                title: message.title,
                text: message.text,
                button: message.confirm
            });
        },

        showWarning(message) {
            swal({
                icon: 'warning',
                title: 'Hold on there..',
                text: message
            });
        },

        showError(message) {
            swal({
                icon: 'error',
                title: 'Oh dear, an error.',
                text: message
            });
        }
    }
});


document.body.addEventListener('keyup', (ev) => {
    const ignores = ['INPUT', 'TEXTAREA'];
    switch (ev.keyCode) {
        case 27:
            eventHub.$emit('KEY_ESC');
            break;
        case 191:
            if(ignores.indexOf(ev.target.tagName) === -1) {
                eventHub.$emit('KEY_SEARCH');
            }
            break;
        default:
            return;
    }
}, false);

import SuperHero from "./components/SuperHero";
window.SuperHero = SuperHero;

if(document.querySelector('.top-button')) {
    document.querySelector('.top-button').addEventListener('click', () => jump(document.body));
}

window.addEventListener('scroll', throttle(() => {
    if(window.scrollY > 100) {
        return document.body.classList.add('scrolled');
    }
    document.body.classList.remove('scrolled');
}, 300));