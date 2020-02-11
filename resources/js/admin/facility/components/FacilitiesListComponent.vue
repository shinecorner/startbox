<template>
    <div class="row match-height">
        <div class="col-12 col-md-6">
            <form class="form-inline" v-on:submit.prevent="showPage(1)">
                <fieldset style="width: 100%;">
                    <div class="input-group pr-0 pl-0">
                        <input type="text" class="form-control" name="search" v-model="query"
                            placeholder="Search facility...">
                        <div class="input-group-append" id="button-addon2">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-12 col-md-6 text-right">
            <div class="form-group">
                <button type="button" class="btn btn-outline-primary btn-min-width mr-1 mb-1"
                    @click="$router.push({ name: 'create_facility'})">Add</button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card active-facilities" style="min-height: 75vh;">
                <div class="card-header border-0">
                    <h4 class="card-title">Facilities</h4> <a class="heading-elements-toggle"><i
                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content">
                    <div v-if="facilities.length > 0" class="table-responsive position-relative">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Organization</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(_facility, index) in facilities" :key="index">
                                    <td class="text-truncate">
                                        <div class="avatar avatar-md mr-1"><img
                                                :src="_facility.logo ? '/storage/' + _facility.logo : '/admin/images/logo-placeholder.jpg'"
                                                alt="Generic placeholder image" class="rounded-circle"></div> <span
                                            class="text-truncate">{{_facility.title}}</span>
                                    </td>
                                    <td class="align-middle"><span>{{_facility.description}}</span></td>
                                    </td>
                                    <td class="align-middle"><span>{{getOrganization(_facility.organization_id)}}</span>
                                    </td>
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <button
                                                @click="$router.push({name: 'edit_facility', params: {id: _facility.id}})"
                                                type="button" class="btn btn-icon btn-outline-primary"><i
                                                    class="fa fa-pencil"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :pagination="pagination" p_classes="justify-content-center" @onFirst="first"
                            @onLast="last" @onShowPage="showPage">
                        </pagination>
                    </div>
                    <div v-else class="table-responsive position-relative mt-5">
                        <table class="table">
                            <tbody>
                                <tr class="text-center">
                                    <h3>{{no_found_msg}}</h3>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PaginationMixin from "./../../../helpers/pagination";
    import PaginationViewComponent from "./../../common/PaginationViewComponent";
    import FacilityServices from '../services/facility-services.js';
    export default {
        mixins: [FacilityServices, PaginationMixin],
        components: {
            pagination: PaginationViewComponent
        },
        props: ['organizations'],
        data() {
            return {
                facilities: [],
                Helpers: Helpers,
                query: "",
                no_found_msg: ''
            }
        },
        methods: {
            getFacilityList(params) {
                params["fields"] = ["id", "title", "description", "organization_id"];
                params["orderby"] = { created_at: 'desc' };
                this.query = this.query.trim();
                if (this.query != "") {
                    let query = this.query;
                    params["query"] = {
                        value: "+*" + query.replace(/\s+/g, "* +*") + "*", // search term
                        fields: ["title", "description"]
                    };
                }
                this.caching(params);
                $.LoadingOverlay("show");
                this.getFacilitiesCall(params, this.getFacilitiesCallback);
            },
            getFacilitiesCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.facilities = response.data;
                    this.calcPages(response.pagination);
                    if (this.facilities.length > 0) {
                        this.no_found_msg = '';
                    } else {
                        this.no_found_msg = 'No facilities were found';
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
            getOrganization(id) {
                if (this.organizations.length > 0) {
                    for (var i in this.organizations) {
                        if (this.organizations[i].id == id) {
                            return this.organizations[i].title;
                        }
                    }
                }
                return 'N/A';
            }
        },
        created() {
            this.paginationInit(15, this.getFacilityList);
            this.query = this.getQueryCached();
        },
        mounted() {
            Helpers.unBlockPage();
            this.showPage(1, false);
        }
    }
</script>