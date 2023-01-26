<template>
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div>
                        <div>
                            <h2>
                                <a class="logo" href="javascript:void(0)">mCRM</a>
                            </h2>
                        </div>
                        <div class="login-main">
                            <form class="theme-form" @submit.prevent="register">
                                <h4>Yeni hesap Oluştur</h4>
                                <p>Sisteme Kayıt Olmak İçin Bilgilerinizi Eksiksiz Giriniz</p>
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Ad Soyad</label>
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <input class="form-control" v-model="form.name" type="text" placeholder="Adınız Soyadınız">
                                            <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">E-Mail Adresiniz</label>
                                    <input class="form-control" type="text" v-model="form.email" placeholder="E-Mail Adresiniz">
                                    <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Şifreniz</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" v-model="form.password" placeholder="Şifreniz">
                                        <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Şifre Tekrar</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" v-model="form.password_confirmation" placeholder="Şifreniz">
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Hesap Oluştur</button>
                                </div>
                                <p class="mt-4 mb-0">Hesabınız Var Mı ?
                                    <router-link class="ms-2" :to="{name : 'admin_login'}">Hemen Giriş Yapın
                                    </router-link>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminRegisterComponent",
    created() {
        if (User.loggedIn()){
            this.$router.push({name : 'admin_home'});
        }
    },
    data(){
        return {
            form : {
                name : '',
                email : '',
                password : '',
                password_confirmation : ''
            },
            errors : {}
        }
    },
    methods : {
        async register(){
            const res = await this.callApi("post","/api/auth/signup/",this.form,{});
            if (res.status==200){
                User.responseAfterLogin(res);
                Toast.fire({
                    icon: 'success',
                    title: 'Hoşgeldiniz: '+User.name()
                });
                this.errors = [];
                this.$router.push({name : 'admin_home'});
            }else{
                this.errors = res.data.errors;
                Toast.fire({
                    icon: 'error',
                    title: 'Kayıt İşleminde Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz'
                });
            }
        }
    }
}
</script>

<style scoped>

</style>
