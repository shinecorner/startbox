import VueRouter from 'vue-router';

import LoginComponent from "./components/LoginComponent.vue";
import RegisterComponent from "./components/RegisterComponent.vue";
import RecoverPasswordComponent from "./components/RecoverPasswordComponent.vue";
import ResetPasswordComponent from "./components/ResetPasswordComponent.vue";

const router = new VueRouter({
    mode: 'history'
});

const auth = new Vue({
    el: '#auth-module',
    components: {
        'login': LoginComponent,
        'register': RegisterComponent,
        'recover-password': RecoverPasswordComponent,
        'reset-password': ResetPasswordComponent
    },
    router
});