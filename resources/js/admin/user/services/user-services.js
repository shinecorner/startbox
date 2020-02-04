export default {
    methods: {
        //ApiCalls
        getUsersCall(params, callBackHandler) {
            axios({
                method: 'get',
                url: '/users',
                params: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        createUserCall(params, callBackHandler) {
            axios({
                method: 'post',
                url: '/users',
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        updateUserCall(id, params, callBackHandler) {
            axios({
                method: 'put',
                url: '/users/' + id,
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        getUserCall(id, callBackHandler) {
            axios({
                method: 'get',
                url: '/users/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        removeUserCall(id, callBackHandler) {
            axios({
                method: 'delete',
                url: '/users/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        }
    }
}