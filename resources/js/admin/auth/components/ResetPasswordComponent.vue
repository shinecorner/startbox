<template>
    <section class="row flexbox-container">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                    <div class="card-header border-0 pb-0">
                        <div class="card-title text-center">
                            <img class="brand-logo" src="/admin/images/logo.webp" alt="branding logo">
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div v-show="error_message" class="alert alert-danger mb-2 text-center" role="alert">
                                <strong>{{error_message_text}}</strong>
                            </div>
                            <div v-show="success_message" class="alert alert-success mb-2 text-center" role="alert">
                                <strong>{{success_message_text}}</strong>
                            </div>
                            <form class="form-horizontal" v-on:submit.prevent="onSubmit" novalidate>
                                <fieldset class="form-group position-relative">
                                    <input type="text" class="form-control form-control-lg" v-model="form.email"
                                        v-bind:class="{'is-invalid' : errors.email.invalid}">
                                    <span v-show="errors.email.invalid"
                                        class="message-error"><b>{{errors.email.message}}</b></span>
                                </fieldset>
                                <fieldset class="form-group position-relative">
                                    <input type="password" class="form-control form-control-lg" v-model="form.password"
                                        v-bind:class="{'is-invalid' : errors.password.invalid}">
                                    <span v-show="errors.password.invalid"
                                        class="message-error"><b>{{errors.password.message}}</b></span>
                                </fieldset>
                                <fieldset class="form-group position-relative">
                                    <input type="password" class="form-control form-control-lg"
                                        v-model="form.password_confirmation"
                                        v-bind:class="{'is-invalid' : errors.password_confirmation.invalid}">
                                    <span v-show="errors.password_confirmation.invalid"
                                        class="message-error"><b>{{errors.password_confirmation.message}}</b></span>
                                </fieldset>
                                <button type="submit" class="btn btn-outline-primary btn-lg btn-block"><i
                                        class="feather icon-unlock"></i> Reset Password</button>
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
    import AuthServices from "../services/auth-service";
    export default {
        mixins: [AuthServices],
        props: ["app_name", "token", "email"],
        data() {
            return {
                form: {
                    email: "",
                    password: "",
                    password_confirmation: ""
                },
                errors: {
                    email: {
                        invalid: false,
                        message: ""
                    },
                    password: {
                        invalid: false,
                        message: ""
                    },
                    password_confirmation: {
                        invalid: false,
                        message: ""
                    }
                },
                success_message: false,
                error_message: false,
                error_message_text: "",
                success_message_text: ""
            };
        },
        methods: {
            onSubmit() {
                var mail_format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if (!mail_format.test(this.form.email) || this.form.email == "") {
                    if (this.form.email == "") {
                        this.errors.email.message = "Email is required";
                    } else {
                        this.errors.email.message = "Email is invalid";
                    }
                    this.errors.email.invalid = true;
                } else {
                    this.errors.email.invalid = false;
                }
                if (this.form.password == "") {
                    this.errors.password.invalid = true;
                    this.errors.password.message = "Password is required";
                } else if (this.form.password.length < 6) {
                    this.errors.password.invalid = true;
                    this.errors.password.message =
                        "Password must be at least 6 characters";
                } else {
                    this.errors.password.invalid = false;
                }
                if (this.form.password_confirmation == "") {
                    this.errors.password_confirmation.invalid = true;
                    this.errors.password_confirmation.message =
                        "Password Confirmation is required";
                } else if (this.form.password_confirmation != this.form.password) {
                    this.errors.password_confirmation.invalid = true;
                    this.errors.password_confirmation.message =
                        "Password confirmation does not match";
                } else {
                    this.errors.password_confirmation.invalid = false;
                }

                if (
                    !this.errors.email.invalid &&
                    !this.errors.password.invalid &&
                    !this.errors.password_confirmation.invalid
                ) {
                    var params = {
                        token: this.token,
                        email: this.form.email,
                        password: this.form.password,
                        password_confirmation: this.form.password_confirmation
                    };
                    $.LoadingOverlay("show");
                    this.resetPassword(params, this.resetPasswordCallback);
                }
            },
            resetPasswordCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.success_message = true;
                    this.success_message_text = response.message;
                    this.error_message = false;
                    window.location = "/admin/login";
                } else {
                    this.error_message = true;
                    this.success_message = false;
                    if (Helpers.isAssoc(response.errors)) {
                        for (var key in response.errors) {
                            this.error_message_text = response.errors[key][0];
                        }
                    } else {
                        this.error_message_text = response.errors[0];
                    }
                }
            },
            resetErrors() {
                this.error.email.invalid = false;
                this.error.password.invalid = false;
                this.error.password.invalid = false;
                this.error.password_confirmation.invalid = false;
            }
        },
        mounted() {
            this.form.email = this.email
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