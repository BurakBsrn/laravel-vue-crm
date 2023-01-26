<template>
    <div>
        <div class="tap-top"><i data-feather="chevrons-up"></i></div>
        <div class="page-wrapper compact-wrapper" id="pageWrapper">
            <header-component></header-component>
            <!-- Page Body Start-->
            <div class="page-body-wrapper">
                <sidebar-component></sidebar-component>

                <router-view></router-view>

                <footer-component></footer-component>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {}
    }
}
</script>
