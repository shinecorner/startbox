export default {
    methods: {
        //ApiCalls
        getSummaryCall(callBackHandler) {
            axios({
                method: 'get',
                url: '/dashboard',
            }).then(response => {
                return callBackHandler(response.data);
            }).catch((error) => {
                return callBackHandler(error);
            });
        },
    }
}