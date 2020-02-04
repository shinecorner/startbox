import VueRouter from 'vue-router';
import routes from './organization-routes';

const router = new VueRouter({
    mode: 'history',
    routes
})

const dashboard = new Vue({
    el: '#organization-module',
    router
});
