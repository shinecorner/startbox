<template>
    <div class="card" style="min-height: 75vh;">
        <div class="card-content">
            <div class="card-body">
                <form class="form" autocomplete="off" @submit.prevent="create" method="post" novalidate>
                    <div class="form-body">
                        <h4 class="form-section"><i class="feather icon-map-pin"></i> Location Info</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input v-model="location.title" type="text" id="title" class="form-control"
                                        v-bind:class="{'is-invalid' : error.title}" name="title">
                                    <span v-show="error.title"
                                        class="message-error"><b>{{error_message.title}}</b></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label>Facility</label>
                                    <select class="select2-data-array form-control" id="facilities-select">
                                        <option></option>
                                    </select>
                                    <span v-show="error.facility"
                                        class="message-error"><b>{{error_message.facility}}</b></span>
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group">
                                    <label>Latitude</label>
                                    <input v-model="location.latitude" type="text" id="latitude" class="form-control"
                                        v-bind:class="{'is-invalid' : error.latitude}" name="latitude">
                                    <span v-show="error.latitude"
                                        class="message-error"><b>{{error_message.latitude}}</b></span>
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group">
                                    <label>Longitude</label>
                                    <input v-model="location.longitude" type="text" id="longitude" class="form-control"
                                        v-bind:class="{'is-invalid' : error.longitude}" name="longitude">
                                    <span v-show="error.longitude"
                                        class="message-error"><b>{{error_message.longitude}}</b></span>
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea v-model="location.description" id="description" class="form-control"
                                        v-bind:class="{'is-invalid' : error.description}" rows="5"
                                        name="description"></textarea>
                                    <span v-show="error.description"
                                        class="message-error"><b>{{error_message.description}}</b></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <button @click="$router.push({ name: 'locations_list'})" type="reset"
                            class="btn btn-warning mr-1">
                            <i class="feather icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <!-- <i class="fa fa-check-square-o"></i> -->
                            <i
                                v-bind:class="{'fa fa-circle-o-notch fa-spin fa-fw' : loading, 'fa fa-check-square-o': !loading}"></i>
                            {{location.id > 0 ? 'Update' : 'Save'}}
                        </button>
                        <!-- <button type="submit" class="btn btn-lg btn-success mb-1">
                                    <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                                    Light Layout
                                </button> -->
                    </div>
                </form>
                <div v-if="location.id > 0" class="row">
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
    import LocationServices from '../services/location-services.js';
    export default {
        mixins: [LocationServices],
        props: ['facilities'],
        data() {
            return {
                location: {
                    id: '',
                    title: '',
                    description: '',
                    facility_id: '',
                    creator_id: '',
                    latitude: '',
                    longitude: '',
                },
                Helpers: Helpers,
                error: {
                    title: false,
                    description: false,
                    facility: false,
                    latitude: false,
                    longitude: false,
                },
                error_message: {
                    title: '',
                    description: '',
                    facility: '',
                    latitude: '',
                    longitude: '',
                },
                loading: false
            }
        },
        methods: {
            create() {
                if (this.location.title && this.location.description && this.location.facility_id && this.location.latitude && this.location.longitude) {
                    this.loading = true;
                    $.LoadingOverlay("show");
                    if (this.location.id > 0) {
                        this.updateLocationCall(this.location.id, this.location, this.createLocationCallback);
                    } else {
                        this.createLocationCall(this.location, this.createLocationCallback);
                    }
                } else {
                    if (!this.location.title) {
                        this.error.title = true;
                        this.error_message.title = 'Title is required';
                    }
                    if (!this.location.description) {
                        this.error.description = true;
                        this.error_message.description = 'Description is required';
                    }
                    if (!this.location.facility_id) {
                        this.error.facility = true;
                        this.error_message.facility = 'Facility is required';
                    }
                    if (!this.location.latitude) {
                        this.error.latitude = true;
                        this.error_message.latitude = 'Latitude is required';
                    }
                    if (!this.location.longitude) {
                        this.error.longitude = true;
                        this.error_message.longitude = 'Longitude is required';
                    }
                }
            },
            createLocationCallback(response) {
                $.LoadingOverlay("hide");
                this.loading = false;
                if (response.code == 200) {
                    this.$router.push({ name: 'locations_list' });
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
            getLocationCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.location = response.data;
                    if (this.location.id > 0) {
                        $("#facilities-select").val(this.location.facility_id).trigger("change");
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
                        if (self.location.id > 0) {
                            $.LoadingOverlay("show");
                            self.removeFacilityCall(self.location.id, self.removeLocationCallback);
                        }
                    }
                }));
            },
            removeLocationCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.$router.push({ name: 'locations_list' });
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
                this.location.logo = this.$refs.logo.files.length > 0 ? this.$refs.logo.files[0] : '';
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
            /* getOrganizationFacilities(id) {
                this.getOrganizationFacilitiesCall(id, this.getOrganizationFacilitiesCallback);
            },
            getOrganizationFacilitiesCallback(response) {
                if (response.code == 200) {
                    this.facilities = response.data;
                } else {
                    if (Helpers.isAssoc(response.errors)) {
                        for (var key in response.errors) {
                            toastr.error(response.errors[key][0], 'Error');
                        }
                    } else {
                        toastr.error(response.errors[0], 'Error');
                    }
                }
            } */
        },
        watch: {
            'location.title'(val) {
                if (val) {
                    this.error.title = false;
                    this.error_message.title = '';
                }
            },
            'location.description'(val) {
                if (val) {
                    this.error.description = false;
                    this.error_message.description = '';
                }
            },
            'location.facility_id'(val) {
                if (val) {
                    this.error.facility = false;
                    this.error_message.facility = '';
                }
            },
            'location.latitude'(val) {
                if (val) {
                    this.error.latitude = false;
                    this.error_message.latitude = '';
                }
            },
            'location.longitude'(val) {
                if (val) {
                    this.error.longitude = false;
                    this.error_message.longitude = '';
                }
            }
        },
        created() {
            if (this.$route.params.id > 0) {
                $.LoadingOverlay("show");
                this.getLocationCall(this.$route.params.id, this.getLocationCallback);
            }
        },
        mounted() {
            Helpers.unBlockPage();
            this.$nextTick(function () {
                var self = this;
                $("#facilities-select").select2({
                    placeholder: "Select facility",
                    allowClear: true,
                    width: "100%",
                    data: $.map(self.facilities, function (item) {
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

                $("#facilities-select").on("select2:select", function (e) {
                    self.location.facility_id = $(e.currentTarget).val();
                });
                $('#facilities-select').on('select2:clear', function (e) {
                    self.location.facility_id = '';
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