export default {
    methods: {
        //ApiCalls
        getAdminsCall(params, callBackHandler) {
            axios({
                method: 'get',
                url: '/admins',
                params: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        createAdminCall(params, callBackHandler) {
            axios({
                method: 'post',
                url: '/admins',
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        updateAdminCall(data, id, callBackHandler) {
            axios({
                method: 'post',
                url: '/admins/' + id,
                data: data,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        getAdminCall(id, callBackHandler) {
            axios({
                method: 'get',
                url: '/admins/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        removeAdminCall(id, callBackHandler) {
            axios({
                method: 'delete',
                url: '/admins/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        changePasswordCall(data, callBackHandler) {
            axios({
                method: 'post',
                url: '/admins/change-password',
                data: data
            }).then(function (response) {
                return callBackHandler(response.data);
            }.bind(this)).catch(function (error) {
                return callBackHandler(error.response);
            });
        },
        removeAvatarCall(id, callBackHandler) {
            axios({
                method: 'get',
                url: '/admins/remove-avatar/' + id,
            }).then(function (response) {
                return callBackHandler(response.data);
            }.bind(this)).catch(function (error) {
                return callBackHandler(error.response);
            });
        }
    }
}