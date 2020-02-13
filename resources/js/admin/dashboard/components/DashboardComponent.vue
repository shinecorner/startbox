<template>
    <div class="content-body">
        <!-- Grouped multiple cards for statistics starts here -->
        <div class="row grouped-multiple-statistics-card">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                                <a href="/admin/users">
                                    <div
                                        class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                        <span class="card-icon primary d-flex justify-content-center mr-3">
                                            <i class="feather icon p-1 icon-users customize-icon font-large-2 p-1"></i>
                                        </span>
                                        <div class="stats-amount mr-3">
                                            <h3 class="heading-text text-bold-600">{{total_users}}</h3>
                                            <p class="sub-heading">Users</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                                <a href="/admin/organizations">
                                    <div
                                        class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                        <span class="card-icon primary d-flex justify-content-center mr-3">
                                            <i class="feather icon p-1 icon-layout customize-icon font-large-2 p-1"></i>
                                        </span>
                                        <div class="stats-amount mr-3">
                                            <h3 class="heading-text text-bold-600">{{total_organizations}}</h3>
                                            <p class="sub-heading">Organizations</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                                <a href="/admin/facilities">
                                    <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                        <span class="card-icon primary d-flex justify-content-center mr-3">
                                            <i class="feather icon p-1 icon-square customize-icon font-large-2 p-1"></i>
                                        </span>
                                        <div class="stats-amount mr-3">
                                            <h3 class="heading-text text-bold-600">{{total_facilities}}</h3>
                                            <p class="sub-heading">Facilities</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                                <a href="/admin/locations">
                                    <div class="d-flex align-items-start">
                                        <span class="card-icon primary d-flex justify-content-center mr-3">
                                            <i
                                                class="feather icon p-1 icon-map-pin customize-icon font-large-2 p-1"></i>
                                        </span>
                                        <div class="stats-amount mr-3">
                                            <h3 class="heading-text text-bold-600">{{total_locations}}</h3>
                                            <p class="sub-heading">Locations</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Grouped multiple cards for statistics ends here -->

        <!-- Minimal modern charts for power consumption, region statistics and sales etc. starts here -->
        <div class="row minimal-modern-charts">
            <!-- <div class="col-xxl-6 col-xl-8 col-lg-8 col-md-12 col-12 power-consumption-stats-chart">
                <div class="card">
                    <div class="card-content pt-2 px-1">
                        <div class="row">
                            <div class="col-8 d-flex">
                                <div class="ml-1">
                                    <h4 class="power-consumption-stats-title text-bold-500">Power consumption</h4>
                                </div>
                                <div class="ml-50 mr-50">
                                    <p>(kWh/100km)</p>
                                </div>
                            </div>
                            <div class="col-4 d-flex justify-content-end pr-3">
                                <div class="dark-text">
                                    <h5 class="power-consumption-active-tab text-bold-500">Week</h5>
                                </div>
                                <div class="light-text ml-2">
                                    <h5>Month</h5>
                                </div>
                            </div>
                        </div>
                        <div id="spline-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12 tracking-stats-chart">
                <div class="card chart-with-tabs">
                    <div class="card-content">
                        <ul class="nav nav-pills card-tabs mb-2 pl-2 border-bottom-blue-grey border-bottom-lighten-5"
                            id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-primary bg-transparent active px-0 mr-1 py-1"
                                    id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                                    aria-controls="pills-home" aria-selected="true">Charts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-primary bg-transparent px-0 py-1" id="pills-profile-tab"
                                    data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile"
                                    aria-selected="false">Tracking</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="body-header pl-2">
                                    <div class="d-flex">
                                        <h3 class="mr-2 body-header-title text-bold-600 mb-0">1,934</h3>
                                        <small class="success"><i class="fa fa-long-arrow-up"></i> +8.0%</small>
                                    </div>
                                    <div class="body-header-subtitle">
                                        <span class="text-muted">Sales</span>
                                    </div>
                                </div>
                                <div id="product_sales_column_basic_chart"></div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="tracking-tab-container px-2">
                                    <div class="tracking-tab-content">
                                        <div class="top-content d-flex flex-wrap justify-content-start mt-2 pb-1 mb-2">
                                            <div class="tracking-heading-icon mr-2">
                                                <i class="icon icon-pie-chart"></i>
                                            </div>
                                            <div class="pb-75">
                                                <h5 class="tracking-tab-title mb-0 text-bold-600">Total Sales</h5>
                                                <small class="text-muted">Top selling products</small>
                                            </div>
                                        </div>
                                        <div class="bottom-content">
                                            <ul class="tracking-list list-group">
                                                <li
                                                    class="list-group-item border py-1 px-0 d-flex justify-content-between align-items-center">
                                                    <span class="tracking-task text-bold-600 text-left">Stack
                                                        Admin</span>
                                                    <span
                                                        class="badge badge-pill badge-warning px-1 py-50">Medium</span>
                                                </li>
                                                <li
                                                    class="list-group-item border py-1 px-0 d-flex justify-content-between align-items-center">
                                                    <span class="tracking-task text-bold-600 text-left">Convex
                                                        Admin</span>
                                                    <span class="badge badge-pill badge-success px-1 py-50">High</span>
                                                </li>
                                                <li
                                                    class="list-group-item border py-1 px-0 d-flex justify-content-between align-items-center">
                                                    <span class="tracking-task text-bold-600 text-left">Frest
                                                        Admin</span>
                                                    <span
                                                        class="badge badge-pill badge-warning px-1 py-50">Medium</span>
                                                </li>
                                                <li
                                                    class="list-group-item border py-1 px-0 d-flex justify-content-between align-items-center">
                                                    <span class="tracking-task text-bold-600 text-left">Material
                                                        Admin</span>
                                                    <span class="badge badge-pill badge-danger px-1 py-50">Low</span>
                                                </li>
                                                <li
                                                    class="list-group-item border py-1 px-0 d-flex justify-content-between align-items-center">
                                                    <span class="tracking-task text-bold-600 text-left">Vuexy
                                                        Admin</span>
                                                    <span class="badge badge-pill badge-success px-1 py-50">High</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12 region-stats-chart">
                <div class="card statistic-card">
                    <div class="card-content">
                        <div class="top-row statistics-card-title border-bottom-blue-grey border-bottom-lighten-5">
                            <div class="py-1 pl-2 primary">
                                <span class="mb-1">Region Statistics</span>
                            </div>
                        </div>
                        <div class="statistics-chart d-flex justify-content-center align-self-center">
                            <div id="sales_in_region_pie_donut"></div>
                        </div>
                        <div class="statistics-chart-data d-flex justify-content-center ml-auto mr-auto pb-50 mb-2">
                            <div class="collection mr-1">
                                <span class="bullet bullet-xs bullet-warning"></span>
                                <span class="font-weight-bold">26%</span>
                            </div>
                            <div class="collection mr-1">
                                <span class="bullet bullet-xs bullet-danger"></span>
                                <span class="font-weight-bold">44%</span>
                            </div>
                            <div class="collection mr-1">
                                <span class="bullet bullet-xs bullet-primary"></span>
                                <span class="font-weight-bold">28%</span>
                            </div>
                        </div>
                        <div class="statistic-card-footer d-flex">
                            <div
                                class="column-data py-1 text-center border-top-blue-grey border-top-lighten-5 flex-grow-1 text-center border-right-blue-grey border-right-lighten-5">
                                <p class="font-large-1 mb-0">$6.9k</p>
                                <span>Revenue</span>
                            </div>
                            <div
                                class="column-data py-1 flex-grow-1 text-center border-top-blue-grey border-top-lighten-5">
                                <p class="font-large-1 mb-0">25</p>
                                <span>Sales</span>
                            </div>
                            <div
                                class="column-data py-1 flex-grow-1 text-center border-top-blue-grey border-top-lighten-5 border-left-blue-grey border-left-lighten-5">
                                <p class="font-large-1 mb-0">11</p>
                                <span>Products</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- latest update tracking chart-->
            <div class="col-xxl-4 col-xl-8 col-lg-8 col-md-12 col-12 latest-update-tracking">
                <div class="card">
                    <div class="card-header latest-update-heading d-flex justify-content-between">
                        <h4 class="card-title">Latest Update
                        </h4>
                        <div class="dropdown update-year-menu pb-1">
                            <a class="bg-transparent dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">2019</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">2018</a>
                                <a class="dropdown-item" href="#">2017</a>
                                <a class="dropdown-item" href="#">2016</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content latest-update-tracking-list pt-0 pb-1 px-2 position-relative">
                        <ul class="list-group">
                            <li
                                class="list-group-item pt-0 px-0 latest-updated-item border-0 d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="list-group-item-icon d-inline mr-1">
                                        <i
                                            class="feather icon text-primary bg-light-primary icon-users total-products-icon rounded-circle p-50"></i>
                                    </span>
                                    <div>
                                        <p class="mb-25 latest-update-item-name text-bold-600">Total Users</p>
                                        <small class="font-small-3">{{total_users}}</small>
                                    </div>
                                </div>
                                <span class="update-profit text-bold-600">{{total_users}}k</span>
                            </li>
                            <li
                                class="list-group-item px-0 latest-updated-item border-0 d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="list-group-item-icon d-inline mr-1">
                                        <i
                                            class="feather icon icon-layout bg-light-info text-info total-sales-icon rounded-circle p-50"></i>
                                    </span>
                                    <div>
                                        <p class="mb-25 latest-update-item-name text-bold-600">Total Organizations</p>
                                        <small class="font-small-3">{{total_organizations}}</small>
                                    </div>
                                </div>
                                <span class="update-profit text-bold-600">{{total_organizations}}M</span>
                            </li>
                            <li
                                class="list-group-item px-0 latest-updated-item border-0 d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="list-group-item-icon d-inline mr-1">
                                        <i
                                            class="feather icon icon-square bg-light-danger text-danger total-products-icon rounded-circle p-50"></i>
                                    </span>
                                    <div>
                                        <p class="mb-25 latest-update-item-name text-bold-600">Total Facilities</p>
                                        <small class="font-small-3">{{total_facilities}}</small>
                                    </div>
                                </div>
                                <span class="update-profit text-bold-600">{{total_facilities}}k</span>
                            </li>
                            <li
                                class="list-group-item px-0 latest-updated-item border-0 d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="list-group-item-icon d-inline mr-1">
                                        <i
                                            class="feather icon icon-map-pin bg-light-primary text-primary total-revenue-icon rounded-circle p-50"></i>
                                    </div>
                                    <div>
                                        <p class="mb-25 latest-update-item-name text-bold-600">Total Locations</p>
                                        <small class="font-small-3">{{total_facilities}}</small>
                                    </div>
                                </div>
                                <span class="update-profit text-bold-600">{{total_facilities}}M</span>
                            </li>
                            <li
                                class="list-group-item px-0 latest-updated-item border-0 d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="list-group-item-icon d-inline mr-1">
                                        <i
                                            class="icon icon-graph bg-light-info text-info total-sales-icon rounded-circle p-50"></i>
                                    </span>
                                    <div>
                                        <p class="mb-25 latest-update-item-name text-bold-600">Total Sales</p>
                                        <small class="font-small-3">39.2k Sales</small>
                                    </div>
                                </div>
                                <span class="update-profit text-bold-600">26M</span>
                            </li>
                            <li
                                class="list-group-item px-0 latest-updated-item border-0 pb-0 d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="list-group-item-icon d-inline mr-1">
                                        <i
                                            class="icon icon-credit-card bg-light-danger text-danger total-revenue-icon rounded-circle p-50"></i>
                                    </div>
                                    <div>
                                        <p class="mb-25 latest-update-item-name text-bold-600">Total Revenue</p>
                                        <small class="font-small-3">45.5k New Revenue</small>
                                    </div>
                                </div>
                                <span class="update-profit text-bold-600">15.6M</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- info and time tracking chart -->
            <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="card info-time-tracking">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-12 border-bottom-blue-grey border-bottom-lighten-5">
                                <div class="card-header latest-update-heading d-flex justify-content-between">
                                    <h4 class="card-title">Procedures
                                    </h4>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-time-tracking-content">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                            <div
                                                class="general-task-loading pr-2 pl-4 px-sm-4 px-md-2 py-md-2 d-flex justify-content-start">
                                                <div id="general_task_radial_bar_chart"></div>
                                                <div
                                                    class="task-content d-flex flex-column align-items-start justify-content-center">
                                                    <h5 class="font-weight-bold mt-2 mt-sm-0">General task loading</h5>
                                                    <p class="leading-para">
                                                        The system automatically detects the loading of your tasks.
                                                        including sales and revenue.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div
                                                class="pr-2 total-stats pl-4 px-sm-4 px-md-2 py-md-2 d-flex justify-content-start">
                                                <div id="info_tracking_total_stats"></div>
                                                <div
                                                    class="pl-2 ml-50 stats-content d-flex flex-column align-items-start justify-content-center pr-2">
                                                    <h5 class="font-weight-bold">Total Stats</h5>
                                                    <p class="leading-para">Your criticaly anylyzed success data
                                                        regarding
                                                        revenue and sales for the
                                                        last week.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Minimal modern charts for power consumption, region statistics and sales etc. starts here -->



        <!-- active users and my task timeline cards starts here -->
        <div class="row match-height">
            <!-- active users card -->
            <div class="col-xl-8 col-lg-12">
                <div class="card active-users" style="min-height: 550px;">
                    <div class="card-header border-0">
                        <h4 class="card-title">Lasts Logins</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div v-if="active_users.length > 0">
                            <div id="audience-list-scroll" class="table-responsive position-relative">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Organization</th>
                                            <th>More</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(_user, index) in active_users" :key="index">
                                            <td class="text-truncate">
                                                <div class="avatar avatar-md mr-1">
                                                    <img :src="_user.picture ? '/storage/' + _user.picture : '/admin/images/avatar-placeholder.png'"
                                                        alt="Generic placeholder image" class="rounded-circle">
                                                </div>
                                                <span
                                                    class="text-truncate">{{_user.first_name}}{{_user.last_name}}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span>{{_user.email}}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span
                                                    class="badge badge-primary">{{_user.status ? _user.status : 'Active'}}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span>{{_user.organization.title.substring(0, 40) + ' ...'}}</span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="dropdown">
                                                    <span class="feather icon-more-vertical dropdown-toggle"
                                                        id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                            :href="'/admin/users/edit/' + _user.id">Details</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-1 text-center">
                                <paginator v-if="paginator.last_page > 1" :pagination="paginator"
                                    @paginate="getActiveUsers" :offset="offset"></paginator>
                            </div>
                        </div>
                        <div v-else class="pt-4 pb-4 text-center">
                            <h4>No active users registered</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- my task Timeline -->
            <div class="col-xl-4 col-lg-12">
                <div class="card" style="max-height: 386.75px;">
                    <div class="card-content">
                        <div class="card-body sales-growth-chart">
                            <div id="monthly-sales" class="height-250"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="chart-title mb-1 text-center">
                            <h6>Total monthly procedures.</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- active users and my task timeline cards ends here -->
    </div>
</template>

<script>
    import Paginator from "./../../common/Paginator";
    import DashboardServices from '../services/dashboard-services.js';
    import AuthServices from '../../auth/services/auth-service.js';
    import UserServices from '../../user/services/user-services.js';
    export default {
        mixins: [DashboardServices, AuthServices, UserServices],
        components: {
            paginator: Paginator
        },
        data() {
            return {
                active_users: [],
                total_organizations: '',
                total_facilities: '',
                total_locations: '',
                total_users: '',
                paginator: {
                    total: 0,
                    per_page: 3,
                    from: 1,
                    to: 0,
                    current_page: 1,
                    data_length: 0,
                    last_page: 0
                },
                offset: 4
            };
        },
        methods: {
            getSummary() {
                $.LoadingOverlay("show");
                this.getSummaryCall(this.getSummaryCallback);
            },
            getSummaryCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    if (response.data.active_users.data) {
                        this.active_users = response.data.active_users.data;
                    }
                    this.paginator = response.data.active_users;
                    this.total_users = response.data.total_users;
                    this.total_organizations = response.data.total_organizations;
                    this.total_facilities = response.data.total_facilities;
                    this.total_locations = response.data.total_locations;
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
            logout() {
                $.LoadingOverlay("show");
                this.logOutCall(this.logOutCallback);
            },
            logOutCallback(response) {
                $.LoadingOverlay("hide");
                if (response.data.status == 1) {
                    if (storage.get('token')) {
                        storage.remove('token');
                    }
                    if (storage.get('refresh_token')) {
                        storage.remove('refresh_token');
                    }
                    if (storage.get('token_type')) {
                        storage.remove('token_type');
                    }
                    if (storage.get('expires_in')) {
                        storage.remove('expires_in');
                    }
                    window.location.href = '/admin/login';
                }
            },
            getActiveUsers(page) {
                $.LoadingOverlay("show");
                page = (typeof page == 'undefined') ? 1 : page;
                var params = {
                    page: page,
                    limit: 6,
                    orderby: {
                        created_at: 'DESC'
                    },
                    with: ['organization'],
                    fields: ['id', 'first_name', 'last_name', 'organization_id', 'email'],
                };
                params['where'] = [];
                this.getUsersCall(params, this.getUsersCallback);
            },
            getUsersCallback(response) {
                $.LoadingOverlay("hide");
                if (response.code == 200) {
                    this.active_users = response.data;
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
        mounted() {
            Helpers.unBlockPage();
            this.getSummary();
        }
    };
</script>
<style scoped>

</style>