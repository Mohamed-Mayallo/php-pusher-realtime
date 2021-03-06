import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Login from './components/Login';
import Signup from './components/Signup';
import List from './components/questions/List';
import Single from './components/questions/Single';
import Ask from './components/questions/Ask';
import EditQuestion from './components/questions/Edit';
import CategoriesList from './components/categories/List';

const routes = [
    { path: '/', component: List },
    { path: '/login', component: Login },
    { path: '/signup', component: Signup },
    { path: '/forum', component: List },
    { path: '/forum/ask', component: Ask },
    { path: '/forum/:slug', component: Single },
    { path: '/forum/edit/:slug', component: EditQuestion },
    { path: '/categories/', component: CategoriesList }
];

const router = new VueRouter({
    routes,
    mode: 'history'
});

export default router;
