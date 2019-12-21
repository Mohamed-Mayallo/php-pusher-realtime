require('./bootstrap');

import Vue from 'vue';
window.Vue = Vue;

import Vuetify from 'vuetify';
const vuetifyOptions = {};
Vue.use(Vuetify);

Vue.component('Home', require('./components/Home.vue').default);

import router from './router';
window.$bus = new Vue();

Vue.mixin({
    methods: {
        logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.$router.push('/login');
        }
    }
});

new Vue({
    el: '#app',
    vuetify: new Vuetify(vuetifyOptions),
    router
});
