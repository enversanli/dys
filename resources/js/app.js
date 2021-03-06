/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
const events = require("events");

window.Vue = require('vue').default;
Vue.use(require('vue-resource'));
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

// Menus

Vue.component('admin-menu', require('./components/menus/adminComponent').default);
Vue.component('manager-menu', require('./components/menus/managerComponent').default);
Vue.component('parent-menu', require('./components/menus/parentComponent').default);
Vue.component('student-menu', require('./components/menus/studentComponent').default);
Vue.component('teacher-menu', require('./components/menus/teacherComponent').default);

// end Menus

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/auth/LoginComponent.vue').default);
Vue.component('menu-component', require('./components/layouts/MenuComponent.vue').default);
Vue.component('header-component', require('./components/layouts/HeaderComponent.vue').default);


// Student
Vue.component('users-list', require('./components/users/ListComponent').default);
Vue.component('student-show', require('./components/users/ShowAndStoreComponent').default);
Vue.component('student-create', require('./components/users/CreateComponent').default);
Vue.component('store-student', require('./components/users/StoreComponent').default);
Vue.component('paginate-data', require('./components/layouts/PaginateComponent').default);
// end Student

// Student Class

Vue.component('store-student-class', require('./components/studentClasses/StoreComponent').default);
Vue.component('student-class-list', require('./components/studentClasses/ListComponent').default);
Vue.component('show-class', require('./components/studentClasses/ShowComponent').default);

// end Student Class

// Duesses
Vue.component('duesses-list', require('./components/duesses/ListComponent').default);
// end Duesses

// Daily Attendances
Vue.component('daily-attendances', require('./components/dailyAttendances/ListComponent').default);
Vue.component('store-daily-attendances', require('./components/dailyAttendances/StoreComponent').default);
// end Daily Attendances

Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const userRole = {
    student : 'STUDENT',
    parent : 'PARENT',
    teacher : 'TEACHER',
};

const app = new Vue({
    el: '#app',
});
