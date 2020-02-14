<template>
    <div class="modal fade text-left mt-4" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Profile Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section id="page-account-settings">
                        <div class="row">
                            <!-- left menu section -->
                            <div class="col-md-3 mb-2 mb-md-0">
                                <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                                    <li class="nav-item">
                                        <a class="nav-link d-flex active" id="account-pill-general" data-toggle="pill"
                                            href="#account-vertical-general" aria-expanded="true">
                                            <i class="feather icon-globe"></i>
                                            General
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex" id="account-pill-password" data-toggle="pill"
                                            href="#account-vertical-password" aria-expanded="false">
                                            <i class="feather icon-lock"></i>
                                            Change Password
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- right content section -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active"
                                                    id="account-vertical-general" aria-labelledby="account-pill-general"
                                                    aria-expanded="true">
                                                    <div class="media">
                                                        <div class="avatar-wrapper">
                                                            <img class="profile-pic-profile" src="" />
                                                            <div class="upload-button-profile">
                                                                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                                            </div>
                                                            <input class="file-upload-profile" type="file"
                                                                accept="image/*" ref="picture" />
                                                        </div>
                                                        <div v-if="user.id > 0 && user.avatar && (typeof user.avatar == 'string')"
                                                            class="media-body mt-75">
                                                            <div
                                                                class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                                <button @click="removeAvatar"
                                                                    class="btn btn-sm btn-secondary ml-50">Delete
                                                                    avatar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label for="first_name">First name</label>
                                                                    <input v-model="user.first_name" type="text"
                                                                        class="form-control"
                                                                        v-bind:class="{'is-invalid' : error.first_name}"
                                                                        placeholder="First name">
                                                                    <span v-show="error.first_name"
                                                                        class="message-error"><b>{{error_message.first_name}}</b></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label for="last_name">Last name</label>
                                                                    <input v-model="user.last_name" type="text"
                                                                        v-bind:class="{'is-invalid' : error.last_name}"
                                                                        class="form-control"
                                                                        placeholder="Last name">
                                                                    <span v-show="error.last_name"
                                                                        class="message-error"><b>{{error_message.last_name}}</b></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label for="email">Email</label>
                                                                    <input v-model="user.email" type="email"
                                                                        v-bind:class="{'is-invalid' : error.email}"
                                                                        class="form-control"
                                                                        placeholder="Email">
                                                                    <span v-show="error.email"
                                                                        class="message-error"><b>{{error_message.email}}</b></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-if="!user.email_verified_at" class="col-12">
                                                            <div class="alert alert-warning alert-dismissible mb-2"
                                                                role="alert">
                                                                <button type="button" class="close" data-dismiss="alert"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                                <p class="mb-0">
                                                                    Your email is not confirmed. Please check your
                                                                    inbox.
                                                                </p>
                                                                <a href="javascript: void(0);">Resend
                                                                    confirmation</a>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button @click="save('general')" type="button"
                                                                class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                                changes</button>
                                                            <button type="button" class="btn btn-light"
                                                                data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="tab-pane fade " id="account-vertical-password"
                                                    role="tabpanel" aria-labelledby="account-pill-password"
                                                    aria-expanded="false">
                                                    <form novalidate>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label for="current_password">Current
                                                                            Password</label>
                                                                        <input v-model="user.current_password"
                                                                            type="password" class="form-control"
                                                                            v-bind:class="{'is-invalid' : error.current_password}"
                                                                            id="current_password"
                                                                            placeholder="Current password">
                                                                        <span v-show="error.current_password"
                                                                            class="message-error"><b>{{error_message.current_password}}</b></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label for="account-new-password">New
                                                                            Password</label>
                                                                        <input v-model="user.password" type="password"
                                                                            class="form-control"
                                                                            v-bind:class="{'is-invalid' : error.password}"
                                                                            id="password" placeholder="New password">
                                                                        <div class="message-error"
                                                                            v-show="error.password"
                                                                            v-html="error_message.password">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label for="account-retype-new-password">Confirm
                                                                            New
                                                                            Password</label>
                                                                        <input v-model="user.password_confirmation"
                                                                            type="password" class="form-control"
                                                                            v-bind:class="{'is-invalid' : error.password_confirmation}"
                                                                            id="password_confirmation"
                                                                            placeholder="Confirm new password">
                                                                        <span v-show="error.password_confirmation"
                                                                            class="message-error"><b>{{error_message.password_confirmation}}</b></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button type="button" @click="save('password')"
                                                                    class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                                    changes</button>
                                                                <button type="button" data-dismiss="modal"
                                                                    class="btn btn-light">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AdminServices from '../../system-admin/services/admin-services.js';
    export default {
        props: ['command'],
        mixins: [AdminServices],
        name: 'user-profile',
        data() {
            return {
                transitionName: 'slide-left',
                user: '',
                error: {
                    id: '',
                    first_name: false,
                    last_name: false,
                    email: false,
                    current_password: false,
                    password: false,
                    password_confirmation: false,
                },
                error_message: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                },
            };
        },
        methods: {
            save(tab) {
                switch (tab) {
                    case 'general':
                        if (this.user.first_name && this.user.last_name && this.user.email) {
                            if (Helpers.validateEmail(this.user.email)) {
                                if (this.$refs.picture.files.length == 0) {
                                    delete this.user.avatar;
                                }
                                delete this.user.current_password;
                                delete this.user.password;
                                delete this.user.password_confirmation;
                                this.user._method = 'PUT';
                                $.LoadingOverlay("show");
                                this.updateAdminCall(this.jsonToFormData(this.user), 0, this.updateUserCallback);
                            } else {
                                this.error.email = true;
                                this.error_message.email = 'Invalid email address';
                            }
                        } else {
                            if (!this.user.first_name) {
                                this.error.first_name = true;
                                this.error_message.first_name = 'First name is required';
                            }
                            if (!this.user.last_name) {
                                this.error.last_name = true;
                                this.error_message.last_name = 'Last name is required';
                            }
                            if (!this.user.email) {
                                this.error.email = true;
                                this.error_message.email = 'Email is required';
                            }
                        }
                        break;
                    case 'password':
                        if (this.user.current_password && this.user.password && this.user.password_confirmation) {
                            $.LoadingOverlay("show");
                            delete this.user.first_name;
                            delete this.user.last_name;
                            delete this.user.email;
                            delete this.user.avatar;
                            this.changePasswordCall(this.jsonToFormData(this.user), this.changePasswordCallback);
                        } else {
                            if (!this.user.current_password) {
                                this.error.current_password = true;
                                this.error_message.current_password = 'Current password is required';
                            }
                            if (!this.user.password) {
                                this.error.password = true;
                                this.error_message.password = 'Password is required';
                            }
                            if (!this.user.password_confirmation) {
                                this.error.password_confirmation = true;
                                this.error_message.password_confirmation = 'Password confirmation is required';
                            }
                        }
                        break;
                    default:
                        break;
                }
            },
            getAdminCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.user = Object.assign({}, response.data);
                    if (this.user.avatar) {
                        $('.profile-pic-profile').attr('src', '/storage/' + this.user.avatar);
                    }
                    this.showModal();
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
            changePasswordCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    toastr.success(response.message, 'Success');
                    $('#large').modal('hide');
                } else {
                    if (Helpers.isAssoc(response.errors)) {
                        var errors = '';
                        for (var key in response.errors) {
                            errors = response.errors[key].join('</br>');
                        }
                        this.error.password = true;
                        this.error_message.password = errors;
                    } else {
                        this.error.current_password = true;
                        this.error_message.current_password = response.errors[0];
                    }
                }
            },
            showModal() {
                $('#large').modal('show');
            },
            updateUserCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.user = Object.assign({}, response.data);
                    this.$emit('profile-updated', { first_name: this.user.first_name, last_name: this.user.last_name, avatar: this.user.avatar });
                    $('#large').modal('hide');
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
            buildFormData(formData, data, parentKey) {
                var self = this;
                if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
                    Object.keys(data).forEach(key => {
                        self.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                    });
                } else {
                    const value = data == null ? '' : data;
                    formData.append(parentKey, value);
                }
            },

            jsonToFormData(data) {
                const formData = new FormData();
                this.buildFormData(formData, data);
                return formData;
            },
            removeAvatar() {
                if (this.user.id > 0) {
                    this.removeAvatarCall(this.user.id, this.removeAvatarCallback)
                }
            },
            removeAvatarCallback(response) {
                if (response.code == 200) {
                    this.user = Object.assign({}, response.data);
                    toastr.success(response.message, 'Success');
                    $('.profile-pic-profile').attr('src', "");
                    this.$emit('profile-updated', { first_name: this.user.first_name, last_name: this.user.last_name, avatar: this.user.avatar });
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
            readURL(input) {
                if (input.files && input.files[0]) {
                    this.user.avatar = input.files[0];
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.profile-pic-profile').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
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
            'user.last_name'(val) {
                if (val) {
                    this.error.last_name = false;
                    this.error_message.last_name = '';
                }
            },
            'user.email'(val) {
                if (val) {
                    this.error.email = false;
                    this.error_message.email = '';
                }
            },
            'user.current_password'(val) {
                if (val) {
                    this.error.current_password = false;
                    this.error_message.current_password = '';
                }
            },
            'user.password'(val) {
                if (val) {
                    this.error.password = false;
                    this.error_message.password = '';
                }
            },
            'user.password_confirmation'(val) {
                if (val) {
                    this.error.password_confirmation = false;
                    this.error_message.password_confirmation = '';
                }
            },
            'command'(val) {
                if (val) {
                    switch (val) {
                        case 'get-user-info':
                            $.LoadingOverlay("show");
                            this.getAdminCall(0, this.getAdminCallback);
                            break;

                        default:
                            break;
                    }
                }
            },
        },
        created() {

        },
        mounted() {
            var self = this;
            this.$nextTick(function () {
                $(".file-upload-profile").on('change', function () {
                    self.readURL(this);
                });
                $(".upload-button-profile").on('click', function () {
                    $(".file-upload-profile").click();
                });
            });

            $('#large').on('hidden.bs.modal', function (e) {
                self.$emit('reset-command');
                $(".file-upload-profile").val('');
                $('.profile-pic-profile').attr('src', "");
            });
        }
    };
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

    .select2-result-repository__title {
        font-size: 0.90rem !important;
    }

    .select2-result-repository__title,
    .select2-result-repository__description {
        padding-left: 10px !important;
    }

    .select2-result-repository__description {
        font-size: 11px !important;
        text-overflow: ellipsis !important;
    }

    .avatar-wrapper {
        position: relative;
        height: 150px;
        width: 150px;
        border-radius: 50%;
        overflow: hidden;
        /* box-shadow: 1px 1px 15px -5px black; */
        transition: all .3s ease;
    }

    .avatar-wrapper:hover {
        transform: scale(1.05);
        cursor: pointer;
    }

    .avatar-wrapper:hover .profile-pic-profile {
        opacity: .5;
    }

    .avatar-wrapper .profile-pic-profile {
        height: 100%;
        width: 100%;
        transition: all .3s ease;
    }

    .avatar-wrapper .profile-pic-profile:after {
        font-family: FontAwesome;
        content: "\f007";
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        position: absolute;
        font-size: 150px;
        background: #ecf0f1;
        color: #34495e;
        text-align: center;
    }

    .avatar-wrapper .upload-button-profile {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
    }

    .avatar-wrapper .upload-button-profile .fa-arrow-circle-up {
        position: absolute;
        font-size: 169px;
        top: -10px;
        left: 2;
        text-align: center;
        opacity: 0;
        -webkit-transition: all .3s ease;
        transition: all .3s ease;
        color: #34495e;
    }

    .avatar-wrapper .upload-button-profile:hover .fa-arrow-circle-up {
        opacity: .9;
    }
</style>