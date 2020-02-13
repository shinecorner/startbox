<template>
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="col-md-12">
                    <h4 style="margin-bottom:10px;"><strong>Pages</strong></h4>
                </div>
                <div>
                    <div class="card-content">
                        <div class="card-body">
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
                                    </form>
                                </div>
                               
                                <div class="col-12 col-md-6 text-right">
                                    <div class="form-group">
                                        <!-- Outline buttons -->
                                        <button type="button" class="btn btn-outline-primary btn-min-width mr-1 mb-1"
                                            @click="$router.push({ name: 'create_page'})">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="pages.length >0" class="table-responsive">
                                <table id="recent-customers"
                                    class="table table-hover mb-0 ps-container ps-theme-default">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(_page, index) in pages" :key="index">
                                            <td class="text-truncate">{{_page.title}}</td>
                                            <td class="text-truncate">{{_page.slug}}</td>
                                            
                                            <td width="10px" class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button
                                                        @click="$router.push({ name: 'edit_page', params: {id: _page.id}})"
                                                        type="button" class="btn btn-icon btn-outline-primary"><i
                                                            class="fa fa-pencil"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else class="text-center">
                                <div style="padding: 20px">
                                    <h4>{{no_found_msg}}</h4>
                                </div>
                            </div>
                        </div>
                        <pagination :pagination="pagination" p_classes="justify-content-center" @onFirst="first"
                            @onLast="last" @onShowPage="showPage">
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PaginationMixin from "./../../../helpers/pagination";
    import Helpers from "./../../../helpers/helpers";
    import PaginationViewComponent from "./../../common/PaginationViewComponent";
    import PageServices from '../services/page-services.js';
    export default {
        mixins: [PageServices, PaginationMixin],
        components: {
            pagination: PaginationViewComponent
        },
        data() {
            return {
                pages: [],
                Helpers: Helpers,
                query: "",
                no_found_msg: ''
            }
        },
        methods: {
            getPageList(params) {
                params["fields"] = ["id", "title", "slug"];
                params["orderby"] = { created_at: 'desc' };
                this.query = this.query.trim();
                if (this.query != "") {
                    let query = this.query;
                    params["query"] = {
                        value: "+*" + query.replace(/\s+/g, "* +*") + "*", // search term
                        fields: ["title", "slug"]
                    };
                }
                this.caching(params);
                $.LoadingOverlay("show");
                this.getPagesCall(params, this.getPagesCallback);
            },
            getPagesCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.pages = response.data;
                    this.calcPages(response.pagination);
                    if (this.pages.length > 0) {
                        this.no_found_msg = '';
                    } else {
                        this.no_found_msg = 'No Pages were found';
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
        watch: {
            query: _.debounce(function () {

            }, 300),
            role: _.debounce(function () {

            }, 300)
        },
        created() {
            this.paginationInit(15, this.getPageList);
            this.query = this.getQueryCached();
        },
        mounted() {
            Helpers.unBlockPage();
            this.showPage(1, false);
        }
    }
</script>