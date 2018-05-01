
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
import { Wysiwyg } from "@dymantic/trix-vue-wysiwyg";

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
Vue.component('location-finder', require('./components/LocationFinder.vue'));
Vue.component('manual-location', require('./components/ManualLocation.vue'));
Vue.component('location-item', require('./components/Location.vue'));
Vue.component('location-form', require('./components/LocationNameForm.vue'));
Vue.component('location-index', require('./components/LocationsIndex.vue'));
Vue.component('date-picker', DatePicker);
Vue.component('category-form', require('./components/CategoryForm.vue'));
Vue.component('categories-index', require('./components/CategoriesIndex.vue'));
Vue.component('category-card', require('./components/CategoryCard.vue'));
Vue.component('category-page', require('./components/Category.vue'));
Vue.component('subcategories-list', require('./components/SubcategoriesList.vue'));
Vue.component('subcategory-page', require('./components/Subcategory.vue'));
Vue.component('toolgroup-list', require('./components/ToolGroupsList.vue'));
Vue.component('tool-group', require('./components/ToolGroup.vue'));
Vue.component('product-form', require('./components/ProductForm.vue'));
Vue.component('product-list', require('./components/ProductList.vue'));
Vue.component('product-page', require('./components/Product.vue'));
Vue.component('product-gallery', require('./components/ProductGallery.vue'));
Vue.component('image-gallery', require('./components/ImageGallery.vue'));
Vue.component('uploading-image', require('./components/UploadingImage.vue'));
Vue.component('gallery-image', require('./components/GalleryImage.vue'));
Vue.component('product-search', require('./components/ProductSearch.vue'));
Vue.component('show-category', require('./components/ShowCategory'));
Vue.component('nested-menu', require('./components/NestedMenu'));
Vue.component('products-list', require('./components/ProductsList'));
Vue.component('add-stock', require('./components/AddToStock'));
Vue.component('remove-parent', require('./components/RemoveParent'));
Vue.component('wysiwyg-editor', Wysiwyg);


window.eventHub = new Vue();

const app = new Vue({
    el: '#app',

    created() {
        eventHub.$on('user-alert', this.showAlert);
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

        showError(message) {
            swal({
                icon: 'error',
                title: 'An error occurred',
                text: message
            });
        }
    }
});

document.body.addEventListener('keyup', (ev) => {
    const ignores = ['INPUT', 'TEXTAREA', 'TRIX-EDITOR'];
    if(ev.keyCode === 191 && ignores.indexOf(ev.target.tagName) === -1) {
        document.querySelector('#nav-search').focus();
    }
}, false);