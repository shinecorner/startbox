<template>
    <div class="card" style="min-height: 75vh;">
        <div class="card-content">
            <div class="card-body">
                <form class="form" autocomplete="off" @submit.prevent="create" method="post" novalidate>
                    <div class="form-body">
                        <h4 class="form-section"><i class="feather icon-award"></i> Organization Info</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input v-model="organization.title" type="text" id="title" class="form-control"
                                        v-bind:class="{'is-invalid' : error.title}" name="title">
                                    <span v-show="error.title"
                                        class="message-error"><b>{{error_message.title}}</b></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea v-model="organization.description" id="description" class="form-control"
                                        v-bind:class="{'is-invalid' : error.description}" rows="5"
                                        name="description"></textarea>
                                    <span v-show="error.description"
                                        class="message-error"><b>{{error_message.description}}</b></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <button @click="$router.push({ name: 'organizations_list'})" type="reset"
                            class="btn btn-warning mr-1">
                            <i class="feather icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <!-- <i class="fa fa-check-square-o"></i> -->
                            <i
                                v-bind:class="{'fa fa-circle-o-notch fa-spin fa-fw' : loading, 'fa fa-check-square-o': !loading}"></i>
                            {{organization.id > 0 ? 'Update' : 'Save'}}
                        </button>
                        <!-- <button type="submit" class="btn btn-lg btn-success mb-1">
                                    <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                                    Light Layout
                                </button> -->
                    </div>
                </form>
                <div v-if="organization.id > 0" class="row">
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
    import OrganizationServices from '../services/organization-services.js';
    export default {
        mixins: [OrganizationServices],
        props: [],
        data() {
            return {
                organization: {
                    id: '',
                    title: '',
                    description: ''
                },
                Helpers: Helpers,
                error: {
                    title: false,
                    description: false
                },
                error_message: {
                    title: '',
                    description: ''
                },
                loading: false
            }
        },
        methods: {
            create() {
                if (this.organization.title && this.organization.description) {
                    this.loading = true;
                    $.LoadingOverlay("show");
                    if (this.organization.id > 0) {
                        this.updateOrganizationCall(this.organization.id, this.organization, this.createOrganizationCallback);
                    } else {
                        this.createOrganizationCall(this.organization, this.createOrganizationCallback);
                    }
                } else {
                    if (!this.organization.title) {
                        this.error.title = true;
                        this.error_message.title = 'Title is required';
                    }
                    if (!this.organization.description) {
                        this.error.description = true;
                        this.error_message.description = 'Description is required';
                    }
                }
            },
            createOrganizationCallback(response) {
                $.LoadingOverlay("hide");
                this.loading = false;
                if (response.code == 200) {
                    this.$router.push({ name: 'organizations_list' });
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
            getOrganizationCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.organization = response.data;
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
                    if (self.organization.id > 0) {
                        $.LoadingOverlay("show");
                        self.removeOrganizationCall(self.organization.id, self.removeOrganizationCallback);
                    }
                }));

                /* if (this.organization.id > 0) {
                    $.LoadingOverlay("show");
                    this.removeOrganizationCall(this.organization.id, this.removeOrganizationCallback);
                } */
            },
            removeOrganizationCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.$router.push({ name: 'organizations_list' });
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
            'organization.title'(val) {
                if (val) {
                    this.error.title = false;
                    this.error_message.title = '';
                }
            },
            'organization.description'(val) {
                if (val) {
                    this.error.description = false;
                    this.error_message.description = '';
                }
            }
        },
        created() {
            if (this.$route.params.id > 0) {
                $.LoadingOverlay("show");
                this.getOrganizationCall(this.$route.params.id, this.getOrganizationCallback);
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