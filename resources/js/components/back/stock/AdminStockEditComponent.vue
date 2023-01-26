<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Stok Güncelle</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <form @submit.prevent="updateProduct" enctype="multipart/form-data">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Stok Bilgileri</h5>
                                        <span>Güncellemek istediğiniz stok bilgilerini eksiksiz olarak giriniz</span>
                                    </div>
                                    <div class="card-body">
                                        <form ref="stockInfoForm" class="theme-form">
                                            <div class="form-group">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0"
                                                                   for="exampleInputPassword1">İşlem Tipi</label>
                                                            <selectize v-model="form.stock_type" class="form-control">
                                                                <!-- settings is optional -->
                                                                <option v-for="stockType in stockTypes"
                                                                        :key="stockType.id" :value="stockType.id">
                                                                    {{ stockType.name }}
                                                                </option>
                                                            </selectize>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0"
                                                                   for="exampleInputPassword1">Müşteriler</label>
                                                            <selectize v-model="form.stock_customer_id"
                                                                       class="form-control">
                                                                <!-- settings is optional -->
                                                                <option v-for="customer in getCustomerFilter"
                                                                        :key="customer.customer_id"
                                                                        :value="customer.customer_id">
                                                                    {{ customer.customer_name }}
                                                                </option>
                                                            </selectize>
                                                            <span class="text-danger" v-if="errors.stock_customer_id">{{
                                                                    errors.stock_customer_id[0]
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0"
                                                                   for="exampleInputPassword1">Ürünler</label>
                                                            <selectize v-model="form.stock_product_id"
                                                                       class="form-control">
                                                                <!-- settings is optional -->
                                                                <option v-for="product in products"
                                                                        :key="product.product_id"
                                                                        :value="product.product_id">
                                                                    {{ product.product_model_code+"--"+product.product_name }}
                                                                </option>
                                                            </selectize>
                                                            <span class="text-danger" v-if="errors.stock_product_id">{{
                                                                    errors.stock_product_id[0]
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Stok
                                                                Adet</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="number" v-model="form.stock_quantity"
                                                                   aria-describedby="emailHelp" placeholder="Ürün Adet">
                                                            <span class="text-danger" v-if="errors.stock_quantity">{{
                                                                    errors.stock_quantity[0]
                                                                }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Toplam
                                                                Fiyat</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="number" step="0.01"
                                                                   v-model="form.stock_total_price"
                                                                   aria-describedby="emailHelp"
                                                                   placeholder="Toplam Fiyat">
                                                            <span class="text-danger" v-if="errors.stock_total_price">{{
                                                                    errors.stock_total_price[0]
                                                                }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Tarih</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="date" v-model="form.stock_date"
                                                                   aria-describedby="emailHelp" placeholder="Tarih">
                                                            <span class="text-danger" v-if="errors.stock_date">{{
                                                                    errors.stock_date[0]
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row my-4">
                                                    <div class="col-md-12">
                                                        <input type="checkbox" v-model="form.stock_isStock"> Stoğa yansısın mı
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Stok Açıklama</label>
                                                            <ckeditor v-model="form.stock_note"></ckeditor>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-edit"></i> Güncelle</button>
                                        <router-link :to="{name : 'admin_stocks'}" class="btn btn-secondary text-white">
                                            <i class="fa fa-arrow-left"></i> Stoklar
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
    name: "AdminStockEditComponent",
    created() {
        if (!User.loggedIn()) {
            this.$router.push({name: 'admin_login'});
        }

        const stock_id = this.$route.params.id;
        this.getStock(stock_id);
    },
    computed: {
        getCustomerFilter() {
            return this.customers.filter(customer => {
                return customer.customer_type == this.form.stock_type;
            });
        }
    },
    data() {
        return {
            stockTypes: [],
            products: [],
            customers: [],
            form: {
                stock_isStock : false,
                stock_type: '', // SECILEN STOK TİPİ
                stock_customer_id: '',
                stock_product_id: '',
                stock_quantity: '',
                stock_total_price: '',
                stock_date: '',
                stock_note : ''
            },
            errors: {}
        }
    },
    methods : {
        async getStock(stock_id){
            const res = await this.callApi("get","/api/stock/"+stock_id+"/edit",{},{
                'Authorization' : "Bearer "+AppStorage.getToken()
            });

            if (res.status==200){
                this.products = res.data.products;
                this.stockTypes = res.data.stockType;
                this.customers = res.data.customers;
                this.form = res.data.item;
            }else{
                Notification.alert();
                this.$router.push({name : 'admin_stocks'});
            }
        },
        async updateProduct(){
            const stock_id = this.$route.params.id;
            const res = await this.callApi("patch","/api/stock/"+stock_id+"/update",this.form,{
                'Authorization' : "Bearer "+AppStorage.getToken()
            });

            if (res.status==200){
                this.errors = {};
                Notification.success();
            }else{
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
