
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import swal from "sweetalert";
window.swal = swal;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import DatePicker from "vuejs-datepicker";

Vue.component('dropdown', require('./components/Dropdown.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('delete-modal', require('./components/DeleteModal.vue'));
Vue.component('reset-password', require('./components/ResetPasswordForm.vue'));
Vue.component('request-password', require('./components/RequestPasswordReset.vue'));
Vue.component('user-form', require('./components/UserForm.vue'));
Vue.component('user-list', require('./components/UserList.vue'));
Vue.component('user-item', require('./components/User.vue'));
Vue.component('toggle-switch', require('./components/Toggle.vue'));
Vue.component('image-upload', require('./components/Singleupload.vue'));
Vue.component('article-page', require('./components/Article.vue'));
Vue.component('articles-list', require('./components/ArticlesList.vue'));
Vue.component('article-form', require('./components/ArticleInfoForm.vue'));
Vue.component('article-publisher', require('./components/ArticlePublisher.vue'));
Vue.component('editor', require('./components/Editor.vue'));
Vue.component('banner-slide', require('./components/BannerSlide.vue'));
Vue.component('slide-index', require('./components/SlidesIndex.vue'));
Vue.component('date-picker', DatePicker);


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
