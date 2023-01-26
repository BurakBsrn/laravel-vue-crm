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
                            <form class="theme-form" @submit.prevent="login">
                                <h4>Giriş Yap</h4>
                                <p>Bilgilerinizle Giriş Yapınız</p>
                                <div class="form-group">
                                    <label class="col-form-label">Email Adresiniz</label>
                                    <input class="form-control" type="text" v-model="form.email"
                                           placeholder="E-Mail Adresiniz">
                                    <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Şifreniz</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" v-model="form.password"
                                               placeholder="Şifreniz">
                                        <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Giriş Yap</button>
                                    </div>
                                </div>
                                <p class="mt-4 mb-0 text-center">Hesabınız Yok Mu ?
                                    <router-link class="ms-2" :to="{name : 'admin_register'}">Hemen Oluşturun
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
    name: "AdminLoginComponent",
    created() {
        if (User.loggedIn()) {
            this.$router.push({name: 'admin_home'});
        }
    },
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            errors: {}
        }
    },
    methods: {
        async login() {
            const res = await this.callApi("post","/api/login",this.form,{});
            if (res.status==200){
                User.responseAfterLogin(res);
                Toast.fire({
                    icon: 'success',
                    title: 'Hoşgeldiniz: '+User.name()
                });
                this.errors = [];
                this.$router.push({name : 'admin_home'});
            }else{
                this.errors = [];
                this.form.password = "";
                this.errors = res.data.errors;
                Toast.fire({
                    icon: 'error',
                    title: 'E-Mail Adresi ve/veya Şifre Hatalı'
                });
            }
        }
    }
}
</script>

<style scoped>

</style>
