export default {
    methods: {
        loginCall(params, callBackHandler) {
            axios({
                method: 'post',
                url: '/auth/login',
                data: params,
            }).then(function (response) {
                callBackHandler(response.data);
            }.bind(this)).catch(function (error) {
                if (error.response) {
                    callBackHandler(error.response);
                }
            });
        },
        getUserCall(callBackHandler) {
            axios({
                method: 'get',
                url: '/users/get-user'
            }).then(function (response) {
                callBackHandler(response.data);
            }.bind(this)).catch(function (error) {
                callBackHandler(error);
            });
        },
        logOutCall(callBackHandler) {
            axios({
                method: 'get',
                url: '/auth/logout'
            }).then(function (response) {
                callBackHandler(response.data);
            }.bind(this)).catch(function (error) {
                callBackHandler(error);
            });
        },
        requestResetPasswordCall(data, callBackHandler) {
            axios({
                method: 'post',
                url: '/auth/reset-password',
                data: data
            }).then(function (response) {
                callBackHandler(1, response);
            }.bind(this)).catch(function (error) {
                callBackHandler(0, error.response);
            });
        },

        resetPassword(params, callBackHandler){
            axios({
                method: 'post',
                url: '/auth/reset/password',
                data: params
            }).then(function (response) {
                callBackHandler(response.data);
            }.bind(this)).catch(function (error) {
                callBackHandler(error);
            });
        },
        sendLinkRecoverPassword(params, callBackHandler){
            axios({
                method: 'post',
                url: '/auth/password/email',
                data: params
            }).then(function (response) {
                callBackHandler(response.data);
            }.bind(this)).catch(function (error) {
                callBackHandler(error);
            });
        },
        
        resetPasswordCall(data, callBackHandler) {
            axios({
                method: 'post',
                url: '/auth/reset/password',
                data: data
            }).then(function (response) {
                callBackHandler(1, response);
            }.bind(this)).catch(function (error) {
                callBackHandler(0, error.response);
            });
        }
    }
}