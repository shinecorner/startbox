import VueRouter from 'vue-router';
import routes from './location-routes';

const router = new VueRouter({
    mode: 'history',
    routes
})

const location = new Vue({
    el: '#location-module',
    router
});
