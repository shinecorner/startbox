<template>
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="col-md-12">
                    <h4 style="margin-bottom:10px;"><strong>Users</strong></h4>
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
                                <!-- <div class="col-12 col-md-3 " style="padding-left:21px; padding-right:21px;">
                                                                <div class="form-group" style="width: 100%;">
                                                                    <label>Roles</label>
                                                                    <select id="select2-roles" class="select2-placeholder form-control"
                                                                        data-placeholder="Select roles..." style="width: 100%">
                                                                        <option value="all">All</option>
                                                                        <option v-for="(role, index) in roles" :key="index" :value="role.name"
                                                                            style="text-transform:capitalize;">
                                                                            {{capitalizeFirstLetter(role.name)}}</option>
                                                                    </select>
                                                                </div>
                                                            </div> -->
                                <div class="col-12 col-md-6 text-right">
                                    <div class="form-group">
                                        <!-- Outline buttons -->
                                        <button type="button" class="btn btn-outline-primary btn-min-width mr-1 mb-1"
                                            @click="$router.push({ name: 'create_user'})">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="users.length >0" class="table-responsive">
                                <table id="recent-customers"
                                    class="table table-hover mb-0 ps-container ps-theme-default">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <!-- <th class="text-center">Status</th>
                                            <template
                                                v-if="user.roles[0].name == 'admin' || user.roles[0].name == 'manager' || hasAdminPermission">
                                                <th class="text-center">Audit</th>
                                                <th class="text-center"></th>
                                            </template> -->
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(_user, index) in users" :key="index">
                                            <td class="text-truncate">{{_user.first_name}} {{_user.last_name}}</td>
                                            <td class="text-truncate">{{_user.phone}}</td>
                                            <td class="text-truncate">{{_user.email}}</td>
                                            <!-- <td class="text-center">
                                                <span
                                                    :class="{'badge badge-warning' : _user.status == 'active',
                                                            'badge badge-secondary' : _user.status == 'inactive'}">{{_user.status}}
                                                </span>
                                            </td>
                                            <template
                                                v-if="user.roles[0].name == 'admin' || user.roles[0].name == 'manager' || hasAdminPermission">
                                                <td style="text-align:center;"><a :href="'/api/admin/su/'+_user.id"><i
                                                            class="fa fa-eye text-warning"></i></a></td>
                                                <td style="text-align:center;"><a
                                                        :href="'/admin/users/edit/' + _user.id"
                                                        class="btn btn-secondary btn-sm square">Edit</a></td>
                                            </template> -->
                                            <td width="10px" class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button
                                                        @click="$router.push({ name: 'edit_user', params: {id: _user.id}})"
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
    import PaginationViewComponent from "./../../common/PaginationViewComponent";
    import UserServices from '../services/user-services.js';
    export default {
        mixins: [UserServices, PaginationMixin],
        props: ['roles'],
        components: {
            pagination: PaginationViewComponent
        },
        data() {
            return {
                users: [],
                Helpers: Helpers,
                query: "",
                no_found_msg: ''
            }
        },
        methods: {
            getUserList(params) {
                params["fields"] = ["id", "first_name", "last_name", "email"];
                params["orderby"] = { created_at: 'desc' };
                this.query = this.query.trim();
                if (this.query != "") {
                    let query = this.query;
                    params["query"] = {
                        value: "+*" + query.replace(/\s+/g, "* +*") + "*", // search term
                        fields: ["first_name", "last_name", "email"]
                    };
                }
                this.caching(params);
                $.LoadingOverlay("show");
                this.getUsersCall(params, this.getUsersCallback);
            },
            getUsersCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.users = response.data;
                    this.calcPages(response.pagination);
                    if (this.users.length > 0) {
                        this.no_found_msg = '';
                    } else {
                        this.no_found_msg = 'No users were found';
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
            this.paginationInit(15, this.getUserList);
            this.query = this.getQueryCached();
        },
        mounted() {
            Helpers.unBlockPage();
            this.showPage(1, false);
        }
    }
</script>