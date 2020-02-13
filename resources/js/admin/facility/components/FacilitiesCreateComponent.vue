<template>
    <div class="card" style="min-height: 75vh;">
        <div class="card-content">
            <div class="card-body">
                <form class="form" autocomplete="off" @submit.prevent="create" method="post" novalidate>
                    <div class="form-body">
                        <h4 class="form-section"><i class="feather icon-square"></i> Facility Info</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input v-model="facility.title" type="text" id="title" class="form-control"
                                        v-bind:class="{'is-invalid' : error.title}" name="title">
                                    <span v-show="error.title"
                                        class="message-error"><b>{{error_message.title}}</b></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label>Organization</label>
                                    <select class="select2-data-array form-control" id="organizations-select">
                                        <option></option>
                                    </select>
                                    <span v-show="error.organization"
                                        class="message-error"><b>{{error_message.organization}}</b></span>
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea v-model="facility.description" id="description" class="form-control"
                                        v-bind:class="{'is-invalid' : error.description}" rows="5"
                                        name="description"></textarea>
                                    <span v-show="error.description"
                                        class="message-error"><b>{{error_message.description}}</b></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <button @click="$router.push({ name: 'facilities_list'})" type="reset"
                            class="btn btn-warning mr-1">
                            <i class="feather icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <!-- <i class="fa fa-check-square-o"></i> -->
                            <i
                                v-bind:class="{'fa fa-circle-o-notch fa-spin fa-fw' : loading, 'fa fa-check-square-o': !loading}"></i>
                            {{facility.id > 0 ? 'Update' : 'Save'}}
                        </button>
                        <!-- <button type="submit" class="btn btn-lg btn-success mb-1">
                                    <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                                    Light Layout
                                </button> -->
                    </div>
                </form>
                <div v-if="facility.id > 0" class="row">
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
    import FacilityServices from '../services/facility-services.js';
    export default {
        mixins: [FacilityServices],
        props: ['organizations'],
        data() {
            return {
                facility: {
                    id: '',
                    title: '',
                    description: '',
                    organization_id: ''
                },
                Helpers: Helpers,
                error: {
                    title: false,
                    description: false,
                    organization: false
                },
                error_message: {
                    title: '',
                    description: '',
                    organization: ''
                },
                loading: false
            }
        },
        methods: {
            create() {
                if (this.facility.title && this.facility.description && this.facility.organization_id) {
                    this.loading = true;
                    $.LoadingOverlay("show");
                    if (this.facility.id > 0) {
                        this.updateFacilityCall(this.facility.id, this.facility, this.createFacilityCallback);
                    } else {
                        this.createFacilityCall(this.facility, this.createFacilityCallback);
                    }
                } else {
                    if (!this.facility.title) {
                        this.error.title = true;
                        this.error_message.title = 'Title is required';
                    }
                    if (!this.facility.description) {
                        this.error.description = true;
                        this.error_message.description = 'Description is required';
                    }
                    if (!this.facility.organization_id) {
                        this.error.organization = true;
                        this.error_message.organization = 'Organization is required';
                    }
                }
            },
            createFacilityCallback(response) {
                $.LoadingOverlay("hide");
                this.loading = false;
                if (response.code == 200) {
                    this.$router.push({ name: 'facilities_list' });
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
            getFacilityCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.facility = response.data;
                    if (this.facility.id > 0) {
                        $("#organizations-select").val(this.facility.organization_id).trigger("change");
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
                    if (t.value) {
                        if (self.facility.id > 0) {
                            $.LoadingOverlay("show");
                            self.removeFacilityCall(self.facility.id, self.removeFacilityCallback);
                        }
                    }
                }));
            },
            removeFacilityCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.$router.push({ name: 'facilities_list' });
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
            getLogo(t) {
                if (t.logo) {
                    return "/storage/" + t.logo;
                } else {
                    return "/admin/images/logo-placeholder.jpg";
                }
            },
            handleFileUpload() {
                this.facility.picture = this.$refs.picture.files.length > 0 ? this.$refs.picture.files[0] : '';
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
            'facility.title'(val) {
                if (val) {
                    this.error.title = false;
                    this.error_message.title = '';
                }
            },
            'facility.description'(val) {
                if (val) {
                    this.error.description = false;
                    this.error_message.description = '';
                }
            },
            'facility.organization_id'(val) {
                if (val) {
                    this.error.organization = false;
                    this.error_message.organization = '';
                }
            }
        },
        created() {
            if (this.$route.params.id > 0) {
                $.LoadingOverlay("show");
                this.getFacilityCall(this.$route.params.id, this.getFacilityCallback);
            }
        },
        mounted() {
            Helpers.unBlockPage();
            this.$nextTick(function () {
                var self = this;
                $("#organizations-select").select2({
                    placeholder: "Select organization",
                    allowClear: true,
                    width: "100%",
                    data: $.map(self.organizations, function (item) {
                        return {
                            id: item.id,
                            text: item.title,
                            description: item.description
                        };
                    }),
                    cache: !0,
                    escapeMarkup: function (t) {
                        return t
                    },
                    templateResult: function (t) {
                        if (t.loading) return t.text;
                        var e = "<div class='select2-result-repository clearfix'><div class='select2-result-repository__avatar'><img src='" + self.getLogo(t) + "' /></div><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + t.text + "</div>";
                        t.text && (e += "<div class='select2-result-repository__description'>" + t.description.substring(0, 60) + ' ...' + "</div>");
                        return e;
                    },
                    templateSelection: function (t) {
                        return t.text;
                    }
                });

                $("#organizations-select").on("select2:select", function (e) {
                    self.facility.organization_id = $(e.currentTarget).val();
                });
                $('#organizations-select').on('select2:clear', function (e) {
                    self.facility.organization_id = '';
                });


            });
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

<style>
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