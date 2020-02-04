<template>
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form class="form" autocomplete="off" @submit.prevent="create" method="post" novalidate>
                    <div class="form-body">
                        <h4 class="form-section"><i class="feather icon-users"></i> User Info</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="first_name">Firs tname</label>
                                    <input v-model="user.first_name" type="text" id="first_name" class="form-control"
                                        v-bind:class="{'is-invalid' : error.first_name}" name="first_name">
                                    <span v-show="error.first_name"
                                        class="message-error"><b>{{error_message.first_name}}</b></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <input v-model="user.last_name" type="text" id="last_name" class="form-control"
                                        name="last_name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input v-model="user.email" type="text" id="email" class="form-control"
                                        v-bind:class="{'is-invalid' : error.email}" name="email">
                                    <span v-show="error.email"
                                        class="message-error"><b>{{error_message.email}}</b></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input v-model="user.phone" type="text" id="phone" class="form-control"
                                        name="phone">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group">
                                    <label>Picture</label>
                                    <div class="custom-file">
                                        <input type="file" id="picture" class="custom-file-input">
                                        <label class="custom-file-label" for="picture">Choose file</label>
                                    </div>
                                </fieldset>
                            </div>
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <textarea v-model="user.last_name" id="last_name" class="form-control"
                                        v-bind:class="{'is-invalid' : error.last_name}" rows="5"
                                        name="last_name"></textarea>
                                    <span v-show="error.last_name"
                                        class="message-error"><b>{{error_message.last_name}}</b></span>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <button @click="$router.push({ name: 'users_list'})" type="reset" class="btn btn-warning mr-1">
                            <i class="feather icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <!-- <i class="fa fa-check-square-o"></i> -->
                            <i
                                v-bind:class="{'fa fa-circle-o-notch fa-spin fa-fw' : loading, 'fa fa-check-square-o': !loading}"></i>
                            {{user.id > 0 ? 'Update' : 'Save'}}
                        </button>
                        <!-- <button type="submit" class="btn btn-lg btn-success mb-1">
                                    <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                                    Light Layout
                                </button> -->
                    </div>
                </form>
                <div v-if="user.id > 0" class="row">
                    <div class="col-12 text-right">
                        <button @click="remove" type="button" class="btn btn-danger">
                            <i class="fa fa-remove"></i>
                            Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UserServices from '../services/user-services.js';
    export default {
        mixins: [UserServices],
        props: [],
        data() {
            return {
                user: {
                    id: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    picture: '',
                    token: '',
                    sso_id: '',
                    organization_id: '',
                    is_admin: ''
                },
                Helpers: Helpers,
                error: {
                    first_name: false,
                    email: false
                },
                error_message: {
                    first_name: '',
                    email: ''
                },
                loading: false
            }
        },
        methods: {
            create() {
                if (this.user.first_name && this.user.email) {
                    if (!Helpers.validateEmail(this.user.email)) {
                        this.error.email = true;
                        this.error_message.email = 'Invalid email address';
                        return 0;
                    }
                    $.LoadingOverlay("show");
                    if (this.user.id > 0) {
                        this.updateUserCall(this.user.id, this.user, this.createUserCallback);
                    } else {
                        this.createUserCall(this.user, this.createUserCallback);
                    }
                } else {
                    if (!this.user.first_name) {
                        this.error.first_name = true;
                        this.error_message.first_name = 'First name is required';
                    }
                    if (!this.user.email) {
                        this.error.email = true;
                        this.error_message.email = 'Email is required';
                    }
                }
            },
            createUserCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.$router.push({ name: 'users_list' });
                } else {
                    if (Helpers.isAssoc(response.errors)) {
                        for (var key in response.errors) {
                            toastr.error(response.errors[key][0], 'Error');
                        }
                    } else {
                        toastr.error(response.errors[0], 'Error');
                    }
                }
            },
            getUserCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.user = response.data;
                } else {
                    if (Helpers.isAssoc(response.errors)) {
                        for (var key in response.errors) {
                            toastr.error(response.errors[key][0], 'Error');
                        }
                    } else {
                        toastr.error(response.errors[0], 'Error');
                    }
                }
            },
            remove() {
                var self = this;
                swal.fire({
                    title: "Are you sure?",
                    /* text: "You won't be able to revert this!", */
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                    confirmButtonClass: "btn btn-primary",
                    cancelButtonClass: "btn btn-danger ml-1",
                    buttonsStyling: !1
                }).then((function (t) {
                    if (self.user.id > 0) {
                        $.LoadingOverlay("show");
                        self.removeUserCall(self.user.id, self.removeUserCallback);
                    }
                }));
            },
            removeUserCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.$router.push({ name: 'users_list' });
                } else {
                    if (Helpers.isAssoc(response.errors)) {
                        for (var key in response.errors) {
                            toastr.error(response.errors[key][0], 'Error');
                        }
                    } else {
                        toastr.error(response.errors[0], 'Error');
                    }
                }
            }
        },
        watch: {
            'user.first_name'(val) {
                if (val) {
                    this.error.first_name = false;
                    this.error_message.first_name = '';
                }
            },
            'user.email'(val) {
                if (val) {
                    this.error.email = false;
                    this.error_message.email = '';
                }
            }
        },
        created() {
            if (this.$route.params.id > 0) {
                $.LoadingOverlay("show");
                this.getUserCall(this.$route.params.id, this.getUserCallback);
            }
        },
        mounted() {
            Helpers.unBlockPage();
        }
    }
</script>

<style scoped>
    .message-error {
        float: right;
        color: red;
        font-size: 12px;
        padding-top: 5px;
        padding-top: 5px;
        padding-bottom: 10px;
    }
</style>