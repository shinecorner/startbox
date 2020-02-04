<template>
    <div class="card">
        <div class="card-header">
            <div class="float-left">
                <h4 class="card-title">Organizations</h4>
            </div>
            <div class="float-right">
                <ul class="list-inline mb-0" style="margin-top:-5px;">
                    <li><a href="#" @click="showPage(pagination.current_page)" style="padding: 0 8px;"><i
                                class="ft-rotate-cw"></i></a></li>
                </ul>
            </div>
        </div>
        <div>
            <div class="card-content">
                <div class="card-body">
                    <div>
                        <!-- <div class="form-group mb-2 col-8 col-xs-12">
                            <button class="btn btn-outline-primary" type="button" @click="$router.push({ name: 'create_organization'})"><i class="fa fa-microchip"></i> Add</button>
                        </div> -->
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <form class="form-inline" v-on:submit.prevent="showPage(1)">
                                    <fieldset style="width: 100%;">
                                        <div class="input-group pr-0 pl-0">
                                            <input type="text" class="form-control" name="search" v-model="query"
                                                placeholder="Search...">
                                            <div class="input-group-append" id="button-addon2">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- <div class="form-group mb-2 col-8 col-xs-12">
                                    <div class="input-group col-12 pr-0 pl-0">
                                        <input type="text" class="form-control" name="search" v-model="query"
                                            placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon2">
                                        <div class="input-group-btn">
                                            <button class="btn btn-outline-info" type="button" @click="showPage(1)"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div> -->
                                </form>
                            </div>
                            <div class="col-12 col-md-6 text-right">
                                <div class="form-group">
                                    <!-- Outline buttons -->
                                    <button type="button" class="btn btn-outline-primary btn-min-width mr-1 mb-1"
                                        @click="$router.push({ name: 'create_organization'})">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="organizations.length >0">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="recent-customers"
                                    class="table table-hover mb-0 ps-container ps-theme-default">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(_organization, index) in organizations" :key="index">
                                            <td class="text-truncate">{{_organization.title}}</td>
                                            <td class="text-truncate">{{_organization.description}}</td>
                                            <td width="10px" class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button
                                                        @click="$router.push({ name: 'edit_organization', params: {id: _organization.id}})"
                                                        type="button" class="btn btn-icon btn-outline-primary"><i
                                                            class="fa fa-pencil"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <div v-html="this.print_show()"></div>
                        </div>
                        <div class="col-12 mt-1">
                            <pagination :pagination="pagination" p_classes="justify-content-center" @onFirst="first"
                                @onLast="last" @onShowPage="showPage">
                            </pagination>
                        </div>
                    </div>
                    <div v-else class="text-center">
                        <div style="padding: 20px">
                            <h4>{{no_found_msg}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PaginationMixin from "./../../../helpers/pagination";
    import PaginationViewComponent from "./../../common/PaginationViewComponent";
    import OrganizationServices from '../services/organization-services.js';
    export default {
        mixins: [OrganizationServices, PaginationMixin],
        components: {
            pagination: PaginationViewComponent
        },
        props: ['roles'],
        data() {
            return {
                organizations: [],
                Helpers: Helpers,
                query: "",
                no_found_msg: ''
            }
        },
        methods: {
            getOrganizationList(params) {
                params["fields"] = ["id", "title", "description"];
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
                this.getOrganizationsCall(params, this.getOrganizationsCallback);
            },
            getOrganizationsCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.organizations = response.data;
                    this.calcPages(response.pagination);
                    if (this.organizations.length > 0) {
                        this.no_found_msg = '';
                    } else {
                        this.no_found_msg = 'No organizations were found';
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
            }
        },
        created() {
            this.paginationInit(15, this.getOrganizationList);
            this.query = this.getQueryCached();
        },
        mounted() {
            Helpers.unBlockPage();
            this.showPage(1, false);
        }
    }
</script>