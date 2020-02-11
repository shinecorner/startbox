export default {
    methods: {
        //ApiCalls
        getLocationsCall(params, callBackHandler) {
            axios({
                method: 'get',
                url: '/locations',
                params: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        createLocationCall(params, callBackHandler) {
            axios({
                method: 'post',
                url: '/locations',
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        updateLocationCall(id, params, callBackHandler) {
            axios({
                method: 'put',
                url: '/locations/' + id,
                data: params,
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        getLocationCall(id, callBackHandler) {
            axios({
                method: 'get',
                url: '/locations/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        removeLocationCall(id, callBackHandler) {
            axios({
                method: 'delete',
                url: '/locations/' + id
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
        getOrganizationFacilitiesCall(id, callBackHandler) {
            axios({
                method: 'get',
                url: '/organization/' + id + '/facilities'
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        }
    }
}