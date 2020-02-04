<template>
    <section class="row flexbox-container">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                    <div class="card-header border-0 pb-0">
                        <div class="card-title text-center">
                                <img class="brand-logo" src="/admin/images/logo.webp" alt="branding logo">
                        </div>
                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Easily
                                Using</span></h6>
                    </div>
                    <div class="card-content">
                        <div class="text-center">
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
                                Email</span></p>
                        <div class="card-body">
                            <form class="form-horizontal" action="index.html" novalidate>
                                <fieldset class="form-group position-relative">
                                    <input type="text" class="form-control" id="user-name" placeholder="User Name">
                                </fieldset>
                                <fieldset class="form-group position-relative">
                                    <input type="email" class="form-control" id="user-email" placeholder="Email Address"
                                        required>
                                </fieldset>
                                <fieldset class="form-group position-relative">
                                    <input type="password" class="form-control" id="user-password"
                                        placeholder="Password" required>
                                </fieldset>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-12 text-center text-sm-left pr-0">
                                        <fieldset>
                                            <input type="checkbox" id="remember-me" class="chk-remember">
                                            <label for="remember-me"> Remember Me</label>
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-6 col-12 float-sm-left text-center text-sm-right"><a
                                            href="/recover-password" class="card-link">Forgot Password?</a></div>
                                </div>
                                <button type="submit" class="btn btn-outline-primary btn-block"><i
                                        class="feather icon-user"></i> Register</button>
                            </form>
                            <a href="/login" class="btn btn-outline-danger btn-block mt-2"><i
                                    class="feather icon-unlock"></i> Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    export default {
        props: ["app_name"],
        data() {
            return {};
        },
        methods: {

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
</style>