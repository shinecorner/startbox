import VueRouter from 'vue-router';
import routes from './admin-routes';

const router = new VueRouter({
    mode: 'history',
    routes
})

const admin = new Vue({
    el: '#admin-module',
    router
});
