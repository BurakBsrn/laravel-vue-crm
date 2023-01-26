<template>
    <div>
        <div class="tap-top"><i data-feather="chevrons-up"></i></div>
        <div class="page-wrapper compact-wrapper" id="pageWrapper">
            <Header></Header>
            <div class="page-body-wrapper">
                <Sidebar></Sidebar>
                <router-view></router-view>
            </div>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>

    import Header from "./Header";
    import Sidebar from "./Sidebar";
    import Footer from "./Footer";
    export default {
        name: "AuthLayout",
        components: {Footer, Sidebar, Header},
        data() {
            return {
                isMenuCondensed: false
            };
        },
        mounted() {

        }
    }
</script>

<style scoped>

</style>
