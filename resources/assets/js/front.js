
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from "vue";
window.Vue = Vue;

import swal from "sweetalert";
window.swal = swal;

import jump from "jump.js";
import {throttle} from "lodash";


import Modal from './components/Modal.vue';
import NestedMenu from './components/NestedMenu.vue';
import ProductsList from './components/ProductsList.vue';
import ShowCategory from './components/ShowCategory';
import StoreLocator from './components/Locator.vue';
import ContactForm from './components/ContactForm.vue';
import SearchBar from './components/SearchBar.vue';
import RelatedProducts from './components/RelatedProducts.vue';
import ImageGallery from './components/ProductImageGallery';
import DistributorMap from './components/WorldMap';
import DistributorApplication from './components/DistributorApplicationForm';
import DistributorProcess from './components/DistributorProcess';

Vue.component('modal', Modal)
Vue.component('nested-menu', NestedMenu)
Vue.component('products-list', ProductsList)
Vue.component('show-category', ShowCategory)
Vue.component('store-locator', StoreLocator)
Vue.component('contact-form', ContactForm)
Vue.component('search-bar', SearchBar)
Vue.component('related-products', RelatedProducts)
Vue.component('image-gallery', ImageGallery)
Vue.component('distributor-map', DistributorMap)
Vue.component('distributor-application', DistributorApplication)
Vue.component('distributor-process', DistributorProcess)


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

[...document.querySelectorAll('.jump-to-form')].forEach(a => {
    a.addEventListener('click', ev => {
        ev.preventDefault();
        jump(document.querySelector('.distributor-form-section'))
    });
});

window.addEventListener('scroll', throttle(() => {
    if(window.scrollY > 100) {
        return document.body.classList.add('scrolled');
    }
    document.body.classList.remove('scrolled');
}, 300));