<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Müşteri Güncelle</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <form ref="customerInfoForm" @submit.prevent="updateCustomer" enctype="multipart/form-data">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Müşteri Bilgileri</h5>
                                        <span>Güncellemek istediğiniz müşteri bilgilerini eksiksiz olarak giriniz</span>
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
                                                                <option :value="1">Tedarikçi</option>
                                                                <option :value="2">Müşteri</option>
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
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-edit"></i> Güncelle</button>
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
    name: "AdminCustomerEditComponent",
    created() {
        if (!User.loggedIn()) {
            this.$router.push({name: 'admin_login'});
        }

        const customer_id = this.$route.params.id;
        this.getCustomer(customer_id);
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
    methods : {
        async getCustomer(customer_id){
            const res = await this.callApi("get","/api/customer/"+customer_id+"/edit",{},{
                'Authorization' : "Bearer "+AppStorage.getToken()
            });

            if (res.status==200){
                this.form = res.data;
            }else{
                Notification.alert();
                this.$router.push({name : 'admin_customers'});
            }
        },
        async updateCustomer(){
            const customer_id = this.$route.params.id;
            const res = await this.callApi("patch","/api/customer/"+customer_id+"/update",this.form,{
                'Authorization' : "Bearer "+AppStorage.getToken()
            });

            if (res.status == 200) {
                Notification.success();
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
