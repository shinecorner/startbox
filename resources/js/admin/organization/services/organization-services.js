export default {
    methods: {
        //ApiCalls
        getOrganizationsCall(params, callBackHandler) {
            axios({
                method: 'get',
                url: '/organizations',
                params: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        createOrganizationCall(params, callBackHandler) {
            axios({
                method: 'post',
                url: '/organizations',
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        updateOrganizationCall(id, params, callBackHandler) {
            axios({
                method: 'put',
                url: '/organizations/' + id,
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        getOrganizationCall(id, callBackHandler) {
            axios({
                method: 'get',
                url: '/organizations/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        removeOrganizationCall(id, callBackHandler) {
            axios({
                method: 'delete',
                url: '/organizations/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        }
    }
}