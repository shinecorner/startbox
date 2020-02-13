export default {
    methods: {
        //ApiCalls
        getPagesCall(params, callBackHandler) {
            axios({
                method: 'get',
                url: '/pages',
                params: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        createPageCall(params, callBackHandler) {
            axios({
                method: 'post',
                url: '/pages',
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        updatePageCall(id, params, callBackHandler) {
            axios({
                method: 'put',
                url: '/pages/' + id,
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        getPageCall(id, callBackHandler) {
            axios({
                method: 'get',
                url: '/pages/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        removePageCall(id, callBackHandler) {
            axios({
                method: 'delete',
                url: '/pages/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        }
    }
}