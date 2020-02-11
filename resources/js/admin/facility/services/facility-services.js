export default {
    methods: {
        //ApiCalls
        getFacilitiesCall(params, callBackHandler) {
            axios({
                method: 'get',
                url: '/facilities',
                params: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        createFacilityCall(params, callBackHandler) {
            axios({
                method: 'post',
                url: '/facilities',
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        updateFacilityCall(id, params, callBackHandler) {
            axios({
                method: 'put',
                url: '/facilities/' + id,
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        getFacilityCall(id, callBackHandler) {
            axios({
                method: 'get',
                url: '/facilities/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        removeFacilityCall(id, callBackHandler) {
            axios({
                method: 'delete',
                url: '/facilities/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        }
    }
}