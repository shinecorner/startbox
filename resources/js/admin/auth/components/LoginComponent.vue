<template>
    <section class="row flexbox-container">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                    <div class="card-header border-0">
                        <div class="card-title text-center">
                            <img class="brand-logo" src="/admin/images/logo.webp" alt="branding logo">
                        </div>
                        <!-- <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Easily
                                Using</span></h6> -->
                    </div>
                    <div class="card-content">
                        <!-- <div class="text-center">
                            <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span
                                    class="fa fa-facebook"></span></a>
                            <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span
                                    class="fa fa-twitter"></span></a>
                            <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"><span
                                    class="fa fa-linkedin font-medium-4"></span></a>
                            <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-github"><span
                                    class="fa fa-github font-medium-4"></span></a>
                        </div>
                        <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>OR
                                Using
                                Account Details</span></p> -->
                        <div class="card-body">
                            <div v-show="error.general_error" class="alert alert-danger mb-2 text-center" role="alert">
                                <strong>{{error_message.general_error}}</strong>
                            </div>
                            <form class="form-horizontal" autocomplete="off" @submit.prevent="login" method="post"
                                novalidate>
                                <fieldset class="form-group position-relative">
                                    <input v-model="email" type="text" class="form-control form-control-lg" id="email"
                                        v-bind:class="{'is-invalid' : error.email}" placeholder="Username" name="email"
                                        required>
                                    <span v-show="error.email"
                                        class="message-error"><b>{{error_message.email}}</b></span>

                                </fieldset>
                                <fieldset class="form-group position-relative">
                                    <input v-model="password" type="password" class="form-control form-control-lg"
                                        id="user-password" v-bind:class="{'is-invalid' : error.email}" name="password"
                                        placeholder="Password">
                                    <span v-show="error.password"
                                        class="message-error"><b>{{error_message.password}}</b></span>
                                </fieldset>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-12 text-center text-sm-left pr-0"></div>
                                    <div class="col-sm-6 col-12 float-sm-left text-center text-sm-right"><a
                                            href="/admin/recover-password" class="card-link">Forgot Password?</a></div>
                                </div>
                                <button type="submit" class="btn btn-outline-primary btn-block"><i
                                        class="feather icon-unlock"></i> Login</button>
                            </form>
                        </div>
                        <!-- <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>New to
                                {{app_name}} ?</span></p>
                        <div class="card-body">
                            <a href="register" class="btn btn-outline-danger btn-block"><i
                                    class="feather icon-user"></i> Register</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import AuthServices from '../services/auth-service.js'
    export default {
        props: ["app_name"],
        mixins: [AuthServices],
        data() {
            return {
                email: '',
                password: '',
                remember: false,
                error: {
                    email: false,
                    password: false,
                    general_error: false
                },
                error_message: {
                    email: '',
                    password: '',
                    general_error: ''
                }
            };
        },
        methods: {
            login() {
                this.resetErrors();
                if (this.email && this.password) {
                    if (Helpers.validateEmail(this.email)) {
                        this.error.general_error = false;
                        var data = {
                            'email': this.email,
                            'password': this.password
                        }
                        $.LoadingOverlay("show");
                        this.loginCall(data, this.loginCallback)
                    } else {
                        this.error.email = true;
                        this.error_message.email = 'Email format is incorrect';
                    }
                } else {
                    if (!this.email) {
                        this.error.email = true;
                        this.error_message.email = 'Email is required';
                    }
                    if (!this.password) {
                        this.error.password = true;
                        this.error_message.password = 'Password is required';
                    }
                }
            },
            loginCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    Auth.setSession(response.data);
                    window.location = Helpers.getQueryParameter('redirect', '/admin/dashboard');
                } else {
                    this.error.general_error = true;
                    this.error_message.general_error = response.errors[0];
                }
            },
            resetErrors() {
                this.error.email;
                this.error.password;
                this.error.general_error;
            }
        },
        watch: {
            email(val) {
                if (val) {
                    this.error.email = false;
                    this.error_message.email = '';
                }
            },
            password(val) {
                if (val) {
                    this.error.password = false;
                    this.error_message.password = '';
                }
            }
        },
        mounted() {

        }
    };
</script>
<style scoped>
    .brand-logo {
        width: 40%;
        height: auto;
    }

    .message-error {
        float: right;
        color: red;
        font-size: 12px;
        padding-top: 5px;
        padding-top: 5px;
        padding-bottom: 10px;
    }

    .message-error-center {
        text-align: center;
        color: red;
        font-size: 12px;
        padding-top: 5px;
        padding-top: 5px;
        padding-bottom: 10px;
    }
</style>