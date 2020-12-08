
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from "vue";
window.vue = Vue;

import swal from "sweetalert";
window.swal = swal;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import DatePicker from "vuejs-datepicker";
import { Wysiwyg } from "@dymantic/trix-vue-wysiwyg";

import Dropdown from "./components/Dropdown.vue";
import Modal from "./components/Modal.vue";
import DeleteModal from "./components/DeleteModal.vue";
import ResetPassword from "./components/ResetPasswordForm.vue";
import RequestPassword from "./components/RequestPasswordReset.vue";
import UserForm from "./components/UserForm.vue";
import UserList from "./components/UserList.vue";
import UserItem from "./components/User.vue";
import ToggleSwitch from "./components/Toggle.vue";
import ImageUpload from "./components/Singleupload.vue";
import ArticlePage from "./components/Article.vue";
import ArticlesList from "./components/ArticlesList.vue";
import ArticleForm from "./components/ArticleInfoForm.vue";
import ArticlePublisher from "./components/ArticlePublisher.vue";
import Editor from "./components/Editor.vue";
import BannerSlide from "./components/BannerSlide.vue";
import SlideIndex from "./components/SlidesIndex.vue";
import LocationFinder from "./components/LocationFinder.vue";
import ManualLocation from "./components/ManualLocation.vue";
import LocationItem from "./components/Location.vue";
import LocationForm from "./components/LocationNameForm.vue";
import LocationIndex from "./components/LocationsIndex.vue";
import CategoryForm from './components/CategoryForm.vue';
import CategoriesIndex from './components/CategoriesIndex.vue';
import CategoryCard from './components/CategoryCard.vue';
import CategoryPage from './components/Category.vue';
import SubcategoriesList from './components/SubcategoriesList.vue';
import SubcategoryPage from './components/Subcategory.vue';
import ToolgroupList from './components/ToolGroupsList.vue';
import ToolGroup from './components/ToolGroup.vue';
import ProductForm from './components/ProductForm.vue';
import ProductList from './components/ProductList.vue';
import ProductPage from './components/Product.vue';
import ProductGallery from './components/ProductGallery.vue';
import ImageGallery from './components/ImageGallery.vue';
import UploadingImage from './components/UploadingImage.vue';
import GalleryImage from './components/GalleryImage.vue';
import ProductSearch from './components/ProductSearch.vue';
import ShowCategory from './components/ShowCategory';
import NestedMenu from './components/NestedMenu';
import ProductsList from './components/ProductsList';
import AddStock from './components/AddToStock';
import RemoveParent from './components/RemoveParent';

Vue.component('dropdown', Dropdown);
Vue.component('modal', Modal);
Vue.component('delete-modal', DeleteModal);
Vue.component('reset-password', ResetPassword);
Vue.component('request-password', RequestPassword);
Vue.component('user-form', UserForm);
Vue.component('user-list', UserList);
Vue.component('user-item', UserItem);
Vue.component('toggle-switch', ToggleSwitch);
Vue.component('image-upload', ImageUpload);
Vue.component('article-page', ArticlePage);
Vue.component('articles-list', ArticlesList);
Vue.component('article-form', ArticleForm);
Vue.component('article-publisher', ArticlePublisher);
Vue.component('editor', Editor);
Vue.component('banner-slide', BannerSlide);
Vue.component('slide-index', SlideIndex);
Vue.component('location-finder', LocationFinder);
Vue.component('manual-location', ManualLocation);
Vue.component('location-item', LocationItem);
Vue.component('location-form', LocationForm);
Vue.component('location-index', LocationIndex);
Vue.component('date-picker', DatePicker);
Vue.component('category-form', CategoryForm);
Vue.component('categories-index', CategoriesIndex);
Vue.component('category-card', CategoryCard);
Vue.component('category-page', CategoryPage);
Vue.component('subcategories-list', SubcategoriesList);
Vue.component('subcategory-page', SubcategoryPage);
Vue.component('toolgroup-list', ToolgroupList);
Vue.component('tool-group', ToolGroup);
Vue.component('product-form', ProductForm);
Vue.component('product-list', ProductList);
Vue.component('product-page', ProductPage);
Vue.component('product-gallery', ProductGallery);
Vue.component('image-gallery', ImageGallery);
Vue.component('uploading-image', UploadingImage);
Vue.component('gallery-image', GalleryImage);
Vue.component('product-search', ProductSearch);
Vue.component('show-category', ShowCategory);
Vue.component('nested-menu', NestedMenu);
Vue.component('products-list', ProductsList);
Vue.component('add-stock', AddStock);
Vue.component('remove-parent', RemoveParent);
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