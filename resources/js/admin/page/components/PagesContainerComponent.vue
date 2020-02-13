<template>
    <div class="row">
        <div class="col-12">
            <transition :name="transitionName">
                <router-view></router-view>
            </transition>
        </div>
    </div>
</template>
    
<script>
export default {
    data() {
        return {
            transitionName: 'slide-left'
        };
    },
    methods: {
        beforeRouteUpdate (to, from, next) {
            const toDepth = to.path.split('/').length
            const fromDepth = from.path.split('/').length
            this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left'
            next()
        },
    },
};
</script>