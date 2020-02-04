<template>
    <section class="row flexbox-container">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                    <div class="card-header border-0 pb-0">
                        <div class="card-title text-center">
                            <img class="brand-logo" src="/admin/images/logo.webp" alt="branding logo">
                        </div>
                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>We will
                                send
                                you a link to reset password.</span></h6>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div v-show="general_error" class="alert alert-danger mb-2 text-center" role="alert">
                                <strong>{{message}}</strong>
                            </div>
                            <div v-show="success" class="alert alert-success mb-2 text-center" role="alert">
                                <strong>{{message}}</strong>
                            </div>
                            <form class="form-horizontal" v-on:submit.prevent="onSubmit">
                                <fieldset class="form-group position-relative">
                                    <input type="text" class="form-control form-control-lg" v-model="form.email"
                                        placeholder="Your Email" v-bind:class="{'is-invalid' : error}">
                                    <span v-show="error" class="message-error"><b>{{message}}</b></span>
                                </fieldset>
                                <button type="submit" class="btn btn-outline-primary btn-lg btn-block"><i
                                        class="feather icon-unlock"></i> Recover Password</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer border-0">
                        <p class="float-sm-left text-center"><a href="/admin/login" class="card-link">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import AuthServices from '../services/auth-service';
    export default {
        mixins: [AuthServices],
        props: ['app_name'],
        data() {
            return {
                form: {
                    email: ""
                },
                message: '',
                error: false,
                general_error: false,
                success: false
            };
        },
        methods: {
            onSubmit() {
                var mail_format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if (!mail_format.test(this.form.email) || this.form.email == '') {
                    this.general_error = false;
                    this.error = true;
                    if (this.form.email == '') {
                        this.message = 'Email is required';
                    } else {
                        this.message = 'Email is invalid';
                    }
                } else {
                    this.error = false;
                    this.general_error = false;
                    this.message = '';
                    $.LoadingOverlay("show");
                    this.sendLinkRecoverPassword({ 'email': this.form.email }, this.sendLinkRecoverPasswordCallback);
                }
            },
            sendLinkRecoverPasswordCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.error = false;
                    this.general_error = false;
                    this.success = true;
                    this.message = response.message;
                } else {
                    this.success = false;
                    this.error = false;
                    this.general_error = true;
                    if (Helpers.isAssoc(response.errors)) {
                        for (var key in response.errors) {
                            this.message = response.errors[key][0];
                        }
                    } else {
                        this.message = response.errors[0];
                    }
                }
            }
        },
        mounted() {
            Helpers.unBlockPage();
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