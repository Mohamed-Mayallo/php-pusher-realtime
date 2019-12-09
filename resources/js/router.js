import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Login from './components/Login';
import Signup from './components/Signup';
import List from './components/questions/List';
import Single from './components/questions/Single';

const routes = [
    { path: '/login', component: Login },
    { path: '/signup', component: Signup },
    { path: '/forum', component: List },
    { path: '/forum/:slug', component: Single }
];

const router = new VueRouter({
    routes,
    mode: 'history'
});

export default router;
