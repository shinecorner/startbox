import VueRouter from 'vue-router';
import routes from './facility-routes';

const router = new VueRouter({
    mode: 'history',
    routes
})

const facility = new Vue({
    el: '#facility-module',
    router
});
