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
                                    <input v-model="admin.first_name" type="text" id="first_name" class="form-control"
                                        v-bind:class="{'is-invalid' : error.first_name}" name="first_name">
                                    <span v-show="error.first_name"
                                        class="message-error"><b>{{error_message.first_name}}</b></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <input v-model="admin.last_name" type="text" id="last_name" class="form-control"
                                        name="last_name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input v-model="admin.email" type="text" id="email" class="form-control"
                                        v-bind:class="{'is-invalid' : error.email}" name="email">
                                    <span v-show="error.email"
                                        class="message-error"><b>{{error_message.email}}</b></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group">
                                    <label>Avatar</label>
                                    <div class="custom-file">
                                        <input @change="handleFileUpload" type="file" id="picture" ref="picture"
                                            class="custom-file-input">
                                        <label class="custom-file-label" for="picture">Choose file</label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label v-if="admin.first_name">Full name: <b>{{admin.first_name}}
                                        {{admin.last_name}}</b></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <button @click="$router.push({ name: 'admins_list'})" type="reset" class="btn btn-warning mr-1">
                            <i class="feather icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <!-- <i class="fa fa-check-square-o"></i> -->
                            <i
                                v-bind:class="{'fa fa-circle-o-notch fa-spin fa-fw' : loading, 'fa fa-check-square-o': !loading}"></i>
                            {{admin.id > 0 ? 'Update' : 'Save'}}
                        </button>
                        <!-- <button type="submit" class="btn btn-lg btn-success mb-1">
                                    <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                                    Light Layout
                                </button> -->
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
                    if (!this.admin.avatar) {
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
            this.$nextTick(function () {

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