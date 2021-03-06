/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');
import VueRouter from 'vue-router';
import { Form, HasError, AlertError } from 'vform';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar'
import Swal from 'sweetalert2'


Vue.use(VueRouter);
window.Form = Form;
window.Fire = new Vue();
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
    });
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
  
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.Swal = Swal;
window.toast = Toast;

import dashboard from './components/Dashboard.vue';
import profile from './components/Profile.vue';
import developer from './components/Developer.vue';
import users from './components/Users.vue';
import events from './components/Events.vue';
import venues from './components/Venues.vue';

Vue.filter('upcase', function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('formatDate', function (mydate) {
    return moment(mydate).format('MMM Do YYYY')
})

let routes = [
    {path: '/dashboard', component: dashboard},
    {path: '/events', component: events},
    {path: '/venues', component: venues},
    {path: '/profile', component: profile},
    {path: '/developer', component: developer},
    {path: '/users', component: users}
];

const router = new VueRouter({
    mode: 'history',
    routes 
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const App = new Vue({
    el: '#app',
    router
}).$mount('#app');

