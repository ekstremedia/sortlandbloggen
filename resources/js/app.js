/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

// Include moment
Vue.use(require("vue-moment"));

// Minimal Growl-style Notification Component – vue-notice
import CripNotice from "crip-vue-notice";
Vue.use(CripNotice);

Vue.component("pagination", require("laravel-vue-pagination"));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// Global variable with baseURL

window.axios.defaults.baseURL = document.head.querySelector(
  'meta[name="api-base-url"]'
).content;

Vue.mixin({
    data: function() {
        return {
            get appBaseUrl() {
                return window.axios.defaults.baseURL;
            }
        };
    }
});

const app = new Vue({
    el: "#app"
});
