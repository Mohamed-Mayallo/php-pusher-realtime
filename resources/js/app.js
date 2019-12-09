require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import Vuetify from 'vuetify';
const vuetifyOptions = {};
Vue.use(Vuetify);

Vue.component('Home', require('./components/Home.vue').default);

import router from './router';
window.$bus = new Vue();

Vue.mixin({
    data() {
        return {
            isLogged: false
        };
    },
    created() {
        if (localStorage && localStorage.getItem('token')) this.isLogged = true;
        else this.isLogged = false;
    }
});

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(vuetifyOptions),
    router
});
