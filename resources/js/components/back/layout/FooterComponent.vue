<template>
    <footer class="footer" v-show="($route.path==='/login' || $route.path==='/register' || $route.path==='/forget') ? false : true">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 footer-copyright text-center">
                    <p class="mb-0">Tüm Hakları Saklıdır 2022 © <a href="https://mfsoftware.net" target="_blank">MFSoftware</a>  </p>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "FooterComponent"
}
</script>

<style scoped>

</style>
