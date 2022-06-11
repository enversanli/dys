/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
const events = require("events");

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import Vue from "vue"
import VueSimpleAlert from "vue-simple-alert";

Vue.use(VueSimpleAlert);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/auth/LoginComponent.vue').default);
Vue.component('menu-component', require('./components/layouts/MenuComponent.vue').default);
Vue.component('header-component', require('./components/layouts/HeaderComponent.vue').default);


// Student
Vue.component('student-list', require('./components/students/ListComponent').default);
Vue.component('student-show', require('./components/students/ShowComponent').default);
Vue.component('student-create', require('./components/students/CreateComponent').default);
Vue.component('store-student', require('./components/students/StoreComponent').default);
Vue.component('paginate-data', require('./components/layouts/PaginateComponent').default);
// end Student

// Student Class

Vue.component('store-student-class', require('./components/studentClasses/StoreStudentClassComponent').default);
Vue.component('student-class-list', require('./components/studentClasses/ListComponent').default);
Vue.component('show-class', require('./components/studentClasses/ShowComponent').default);

// end Student Class

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
