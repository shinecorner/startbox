<template>
    <div class="card" style="min-height: 75vh;">
        <div class="card-content">
            <div class="card-body">
                <form class="form" autocomplete="off" @submit.prevent="create" method="post" novalidat>
                    <div class="form-body">
                        <h4 class="form-section"><i class="feather icon-users"></i> Admin Info</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="first_name">First name</label>
                                    <input v-model="admin.first_name" type="text" class="form-control"
                                        v-bind:class="{'is-invalid' : error.first_name}" name="first_name">
                                    <div class="pt-2 pb-2" style="height: 20px;">
                                        <label v-show="admin.first_name">Full name: <b>{{admin.first_name}}
                                                {{admin.last_name}}</b></label>
                                    </div>
                                    <span v-show="error.first_name"
                                        class="message-error"><b>{{error_message.first_name}}</b></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <input v-model="admin.last_name" type="text" class="form-control"
                                        name="last_name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input v-model="admin.email" type="text" class="form-control"
                                        v-bind:class="{'is-invalid' : error.email}" name="email">
                                    <span v-show="error.email"
                                        class="message-error"><b>{{error_message.email}}</b></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pl-5">
                                <fieldset class="form-group">
                                    <div class="avatar-wrapper">
                                        <img class="profile-pic-admin" src="" />
                                        <div class="upload-button-admin">
                                            <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                        </div>
                                        <input class="file-upload-admin" type="file" accept="image/*" ref="picture" />
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button @click="$router.push({ name: 'admins_list'})" type="reset" class="btn btn-warning mr-1">
                            <i class="feather icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i
                                v-bind:class="{'fa fa-circle-o-notch fa-spin fa-fw' : loading, 'fa fa-check-square-o': !loading}"></i>
                            {{admin.id > 0 ? 'Update' : 'Save'}}
                        </button>
                    </div>
                </form>
                <div v-if="admin.id > 0" class="row">
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
    import UserServices from '../services/admin-services.js';
    export default {
        mixins: [UserServices],
        data() {
            return {
                admin: {
                    id: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    avatar: ''
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
                if (this.admin.first_name && this.admin.email) {
                    if (!Helpers.validateEmail(this.admin.email)) {
                        this.error.email = true;
                        this.error_message.email = 'Invalid email address';
                        return 0;
                    }
                    $.LoadingOverlay("show");
                    if (this.$refs.picture.files.length == 0) {
                        delete this.admin.avatar;
                    }
                    if (this.admin.id > 0) {
                        this.admin._method = 'PUT';
                        this.updateAdminCall(this.jsonToFormData(this.admin), this.admin.id, this.createAdminCallback);
                    } else {
                        this.createAdminCall(this.jsonToFormData(this.admin), this.createAdminCallback);
                    }
                } else {
                    if (!this.admin.first_name) {
                        this.error.first_name = true;
                        this.error_message.first_name = 'First name is required';
                    }
                    if (!this.admin.email) {
                        this.error.email = true;
                        this.error_message.email = 'Email is required';
                    }
                }
            },
            createAdminCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    /* if (this.admin.id > 0) {
                        Auth.setUser({ first_name: response.data.first_name, last_name: response.data.last_name, avatar: response.data.avatar });
                    } */
                    this.$router.push({ name: 'admins_list' });
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
            getAdminCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.admin = response.data;
                    if (this.admin.avatar) {
                        $('.profile-pic-admin').attr('src', '/storage/' + this.admin.avatar);
                    }
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
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                    confirmButtonClass: "btn btn-primary",
                    cancelButtonClass: "btn btn-danger ml-1",
                    buttonsStyling: !1
                }).then((function (t) {
                    if (t.value) {
                        if (self.admin.id > 0) {
                            $.LoadingOverlay("show");
                            self.removeAdminCall(self.admin.id, self.removeAdminCallback);
                        }
                    }
                }));
            },
            removeAdminCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.$router.push({ name: 'admins_list' });
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
            handleFileUpload() {
                this.admin.avatar = this.$refs.picture.files.length > 0 ? this.$refs.picture.files[0] : '';
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

            readURL(input) {
                if (input.files && input.files[0]) {
                    this.admin.avatar = input.files[0];
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.profile-pic-admin').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        },
        watch: {
            'admin.first_name'(val) {
                if (val) {
                    this.error.first_name = false;
                    this.error_message.first_name = '';
                }
            },
            'admin.email'(val) {
                if (val) {
                    this.error.email = false;
                    this.error_message.email = '';
                }
            }
        },
        created() {
            if (this.$route.params.id > 0) {
                $.LoadingOverlay("show");
                this.getAdminCall(this.$route.params.id, this.getAdminCallback);
            }
        },
        mounted() {
            Helpers.unBlockPage();
            var self = this;
            this.$nextTick(function () {
                $(".file-upload-admin").on('change', function () {
                    self.readURL(this);
                });
                $(".upload-button-admin").on('click', function () {
                    $(".file-upload-admin").click();
                });
            });
        }
    }
</script>

<style>
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
</style>

<style scoped>
    .avatar-wrapper {
        position: relative;
        height: 150px;
        width: 150px;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 1px 1px 15px -5px black;
        transition: all .3s ease;
    }

    .avatar-wrapper:hover {
        transform: scale(1.05);
        cursor: pointer;
    }

    .avatar-wrapper:hover .profile-pic-admin {
        opacity: .5;
    }

    .avatar-wrapper .profile-pic-admin {
        height: 100%;
        width: 100%;
        transition: all .3s ease;
    }

    .avatar-wrapper .profile-pic-admin:after {
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

    .avatar-wrapper .upload-button-admin {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
    }

    .avatar-wrapper .upload-button-admin .fa-arrow-circle-up {
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

    .avatar-wrapper .upload-button-admin:hover .fa-arrow-circle-up {
        opacity: .9;
    }
</style>