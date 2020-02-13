import VueRouter from 'vue-router';
import routes from './page-routes';

const router = new VueRouter({
    mode: 'history',
    routes
})

const page = new Vue({
    el: '#page-module',
    router
});
