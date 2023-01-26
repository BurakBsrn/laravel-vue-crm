<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Müşteri Ekle</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <form ref="customerInfoForm" @submit.prevent="addCustomer" enctype="multipart/form-data">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Müşteri Bilgileri</h5>
                                        <span>Eklemek istediğiniz müşteri bilgilerini eksiksiz olarak giriniz</span>
                                    </div>

                                    <div class="card-body">
                                        <form class="theme-form">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="">Hesap Tipi</label>
                                                            <selectize class="form-control"
                                                                       v-model="form.customer_type">
                                                                <!-- settings is optional -->
                                                                <option :value="0">Tedarikçi</option>
                                                                <option :value="1">Müşteri</option>
                                                            </selectize>
                                                            <span class="text-danger" v-if="errors.customer_type">{{
                                                                    errors.customer_type[0]
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Müşteri
                                                                Adı</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text" v-model="form.customer_name"
                                                                   aria-describedby="emailHelp"
                                                                   placeholder="Müşteri Adı">
                                                            <span class="text-danger" v-if="errors.customer_name">{{
                                                                    errors.customer_name[0]
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Müşteri
                                                                E-Mail</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text" v-model="form.customer_email"
                                                                   aria-describedby="emailHelp"
                                                                   placeholder="Müşteri E-Mail">
                                                            <span class="text-danger" v-if="errors.customer_email">{{
                                                                    errors.customer_email[0]
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Müşteri
                                                                Telefon</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text" v-model="form.customer_phone"
                                                                   aria-describedby="emailHelp"
                                                                   placeholder="Müşteri Telefon">
                                                            <span class="text-danger" v-if="errors.customer_phone">{{
                                                                    errors.customer_phone[0]
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Müşteri
                                                                Adres</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text" v-model="form.customer_address"
                                                                   aria-describedby="emailHelp"
                                                                   placeholder="Müşteri Adres">
                                                            <span class="text-danger" v-if="errors.customer_address">{{
                                                                    errors.customer_address[0]
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="col-form-label pt-0" for="exampleInputEmail1">Müşteri
                                                            Açıklama</label>
                                                        <ckeditor v-model="form.customer_note"></ckeditor>
                                                        <span class="text-danger" v-if="errors.customer_note">{{
                                                                errors.customer_note[0]
                                                            }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Kaydet</button>
                                        <router-link :to="{name : 'admin_customers'}"
                                                     class="btn btn-secondary text-white"><i class="fa fa-arrow-left"></i> Müşteriler
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminCustomerCreateComponent",
    created() {
        if (!User.loggedIn()) {
            this.$router.push({name: 'admin_login'});
        }
    },
    data() {
        return {
            form: {
                customer_type: '',
                customer_name: '',
                customer_email: '',
                customer_phone: '',
                customer_address: '',
                customer_note: ''
            },
            errors: {}
        }
    },
    methods: {
        async addCustomer() {
            const res = await this.callApi("post", "/api/customer/store", this.form, {
                'Authorization': "Bearer " + AppStorage.getToken()
            });


            if (res.status == 200) {
                Notification.success();
                this.form.customer_name = "";
                this.form.customer_email = "";
                this.form.customer_phone = "";
                this.form.customer_address = "";
                this.form.customer_note = "";
                this.form.customer_type = "";
                this.errors = {};
            } else {
                Notification.error();
                this.errors = {};
                this.errors = res.data.errors;
            }
        }
    }
}
</script>

<style scoped>

</style>
