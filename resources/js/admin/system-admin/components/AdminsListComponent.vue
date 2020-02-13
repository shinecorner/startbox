<template>
    <div class="row match-height">
        <div class="col-12 col-md-6">
            <form class="form-inline" v-on:submit.prevent="showPage(1)">
                <fieldset style="width: 100%;">
                    <div class="input-group pr-0 pl-0">
                        <input type="text" class="form-control" name="search" v-model="query"
                            placeholder="Search admin...">
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
                    @click="$router.push({ name: 'create_admin'})">Add</button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card active-admins" style="min-height: 75vh;">
                <div class="card-header border-0">
                    <h4 class="card-title">Admins</h4> <a class="heading-elements-toggle"><i
                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content">
                    <div v-if="admins.length >0" class="table-responsive position-relative">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(_admin, index) in admins" :key="index">
                                    <td class="text-truncate">
                                        <div class="avatar avatar-md mr-1">
                                            <img :src="_admin.avatar ? '/storage/' + _admin.avatar : '/admin/images/avatar-placeholder.png'"
                                                alt="Generic placeholder image" class="rounded-circle"></div> <span
                                            class="text-truncate">{{_admin.first_name}} {{_admin.last_name}}</span>
                                    </td>
                                    <td class="align-middle"><span>{{_admin.email}}</span></td>
                                    <td class="align-middle"><span
                                            :class="{'badge badge-primary' : _admin.status == 'active', 'badge badge-danger' : _admin.status == 'inactive'}">{{_admin.status | capitalize}}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <button
                                                @click="$router.push({ name: 'edit_admin', params: {id: _admin.id}})"
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
    import AdminServices from '../services/admin-services.js';
    export default {
        mixins: [AdminServices, PaginationMixin],
        components: {
            pagination: PaginationViewComponent
        },
        data() {
            return {
                admins: [],
                Helpers: Helpers,
                query: "",
                no_found_msg: ''
            }
        },
        methods: {
            getAdminList(params) {
                params["fields"] = ["id", "first_name", "last_name", "email", "avatar", "status"];
                params["orderby"] = { created_at: 'desc' };
                this.query = this.query.trim();
                if (this.query != "") {
                    let query = this.query;
                    params["query"] = {
                        value: "+*" + query.replace(/\s+/g, "* +*") + "*", // search term
                        fields: ["first_name", "last_name", "email", "status"]
                    };
                }
                this.caching(params);
                $.LoadingOverlay("show");
                this.getAdminsCall(params, this.getAdminsCallback);
            },
            getAdminsCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.admins = response.data;
                    this.calcPages(response.pagination);
                    if (this.admins.length > 0) {
                        this.no_found_msg = '';
                    } else {
                        this.no_found_msg = 'No admins were found';
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
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        },
        created() {
            this.paginationInit(15, this.getAdminList);
            this.query = this.getQueryCached();
        },
        mounted() {
            Helpers.unBlockPage();
            this.showPage(1, false);
        }
    }
</script>

<style scoped>
    .avatar {
        width: 50px;
        height: 50px;
    }
</style>