import VueRouter from 'vue-router';
import routes from './dashboard-routes';

const router = new VueRouter({
    mode: 'history',
    routes
})

const dashboard = new Vue({
    el: '#dashboard-module',
    router
});
