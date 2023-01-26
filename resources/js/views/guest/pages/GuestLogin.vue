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
                                    <input class="form-control" type="text" v-model="email"
                                           placeholder="E-Mail Adresiniz">
<!--                                    <span class="text-danger" v-if="errors.email"></span>-->
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Şifreniz</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" v-model="password"
                                               placeholder="Şifreniz">
<!--                                        <span class="text-danger" v-if="errors.password"></span>-->
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Giriş Yap</button>
                                    </div>
                                </div>
                                <p class="mt-4 mb-0 text-center">Hesabınız Yok Mu ?
                                    <router-link class="ms-2" :to="{name: 'register'}">Hemen Oluşturun</router-link>
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
        name: "GuestLogin",
        data() {
            return {
                email: null,
                password: null,
            }
        },
        methods: {
            login() {
                const data = {
                    email: this.email,
                    password: this.password
                };

                this.$auth.login({
                    data,
                    success: function () {

                    },
                    rememberMe: true,
                    fetchUser: true
                })


            }
        },
        mounted() {

        }
    }
</script>

<style scoped>

</style>
