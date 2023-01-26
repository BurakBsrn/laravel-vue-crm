<template>
    <div>
        <div class="tap-top"><i data-feather="chevrons-up"></i></div>
        <div class="page-wrapper compact-wrapper" id="pageWrapper">
            <div class="page-body-wrapper">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "GuestLayout",
        mounted() {

        }
    }
</script>

<style scoped>

</style>
