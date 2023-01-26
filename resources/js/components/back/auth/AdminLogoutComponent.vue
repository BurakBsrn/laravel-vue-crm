<template>

</template>

<script>
export default {
    name: "AdminLogoutComponent",
    created(){
        AppStorage.clear();
        Toast.fire({
            icon: 'success',
            title: 'Çıkış İşlemi Başarılı'
        });
        this.$router.push({name : 'admin_login'});
    }
}
</script>

<style scoped>
</style>
