<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Ürün Ekle</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <form @submit.prevent="addProduct"  enctype="multipart/form-data">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Ürün Bilgileri</h5>
                                        <span>Eklemek istediğiniz ürün bilgilerini eksiksiz olarak giriniz</span>
                                    </div>
                                    <div class="card-body">
                                        <form ref="productInfoForm" class="theme-form">
                                            <div class="form-group">

                                               <div class="row">
                                                   <div class="col-md-12 ">
                                                      <div class="mb-3">
                                                          <vue-upload-multiple-image
                                                              drag-text="Resim Dosyası Seçiniz (JPEG,JPG,PNG Dosyaları Seçiniz)"
                                                              browse-text="Seçim Yapınız"
                                                              primary-text="Varsayılan"
                                                              mark-is-primary-text="Varsayılan Olarak Ayarla"
                                                              accept="image/jpeg,image/png,image/jpg,image/webp"
                                                              @upload-success="uploadImageSuccess"
                                                              @before-remove="beforeRemove"
                                                              @edit-image="editImage"
                                                              :data-images="form.product_images"
                                                          ></vue-upload-multiple-image>
                                                      </div>
                                                   </div>
                                               </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0"
                                                                   for="exampleInputPassword1">Ürün Kategorisi</label>
                                                            <selectize class="form-control"
                                                                       v-model="form.product_category_id">
                                                                <!-- settings is optional -->
                                                                <option v-for="category in categories"
                                                                        :value="category.category_id">
                                                                    {{ category.category_name }}
                                                                </option>
                                                            </selectize>
                                                            <span class="text-danger" v-if="errors.product_category_id">{{ errors.product_category_id[0] }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Ürün Adı</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text" v-model="form.product_name"
                                                                   aria-describedby="emailHelp" placeholder="Ürün Adı">
                                                            <span class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0"
                                                                   for="exampleInputPassword1">Ürün Model Kodu</label>
                                                            <input class="form-control" id="exampleInputPassword1"
                                                                   type="text" v-model="form.product_model_code"
                                                                   placeholder="Ürün Model Kodu">
                                                            <span class="text-danger" v-if="errors.product_model_code">{{ errors.product_model_code[0] }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Ürün Barkod</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text" v-model="form.product_barcode"
                                                                   aria-describedby="emailHelp"
                                                                   placeholder="Ürün Barkod">
                                                            <span class="text-danger" v-if="errors.product_barcode">{{ errors.product_barcode[0] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0"
                                                                   for="exampleInputPassword1">Ürün Marka</label>
                                                            <input class="form-control" id="exampleInputPassword1"
                                                                   type="text" v-model="form.product_brand"
                                                                   placeholder="Ürün Marka">
                                                            <span class="text-danger" v-if="errors.product_brand">{{ errors.product_brand[0] }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Ürün
                                                                Stok</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="number" v-model="form.product_stock"
                                                                   aria-describedby="emailHelp" placeholder="Ürün Stok">
                                                            <span class="text-danger" v-if="errors.product_stock">{{ errors.product_stock[0] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0"
                                                                   for="exampleInputPassword1">Ürün KDV Oran</label>
                                                            <input class="form-control" id="exampleInputPassword1"
                                                                   type="number" step="0.01" v-model="form.product_tax"
                                                                   placeholder="Ürün KDV Oran">
                                                            <span class="text-danger" v-if="errors.product_tax">{{ errors.product_tax[0] }}</span>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Ürün
                                                                Alış Fiyatı</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="number" step="0.01" v-model="form.product_buying_price"
                                                                   aria-describedby="emailHelp"
                                                                   placeholder="Ürün Alış Fiyatı">
                                                            <span class="text-danger" v-if="errors.product_buying_price">{{ errors.product_buying_price[0] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0"
                                                                   for="exampleInputPassword1">Ürün Satış Fiyatı</label>
                                                            <input class="form-control" id="exampleInputPassword1"
                                                                   type="number" step="0.01" v-model="form.product_selling_price"
                                                                   placeholder="Ürün Satış Fiyatı">
                                                            <span class="text-danger" v-if="errors.product_selling_price">{{ errors.product_selling_price[0] }}</span>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Ürün
                                                                Açıklama</label>
                                                            <ckeditor v-model="form.product_description"></ckeditor>
                                                            <span class="text-danger" v-if="errors.product_description">{{ errors.product_description[0] }}</span>
                                                        </div>

                                                        <button @click="newProperty" class="btn btn-primary"
                                                                type="button"><i class="fa fa-plus"></i> Yeni Özellik Ekle
                                                        </button>

                                                        <div class="row" v-for="(item,index) in getPropertyElements">
                                                            <div class="col-md-5 mt-3">
                                                                <label for="">Özellik Adı</label>
                                                                <input type="text" class="form-control" :value="item.property" name="property" @keyup="propertyNameInput(index,$event)">
                                                            </div>

                                                            <div class="col-md-5 mt-3">
                                                                <label for="">Özellik Değeri</label>
                                                                <input type="text" class="form-control" :value="item.value" name="value" @keyup="propertyNameInput(index,$event)">
                                                            </div>

                                                            <div class="col-md-2 mt-5">
                                                                <button type="button" class="btn btn-danger"
                                                                        @click="removeProperty(index)"><i
                                                                    class="fa fa-times"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Kaydet</button>
                                        <router-link :to="{name : 'admin_products'}" class="btn btn-secondary text-white"><i class="fa fa-arrow-left"></i> Ürünler
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
import VueUploadMultipleImage from 'vue-upload-multiple-image'
export default {
    name: "AdminProductComponent",
    created() {
        if (!User.loggedIn()) {
            this.$router.push({name: 'admin_login'});
        }

        this.getCategories();
    },
    data() {
        return {
            categories: [],
            form: {
                product_category_id: '',
                product_name : '',
                product_barcode : '',
                product_model_code : '',
                product_brand : '',
                product_stock : '',
                product_tax : '',
                product_buying_price : '',
                product_selling_price : '',
                product_description : '',
                product_images : [],
                propertyElements: [],
            },
            errors : {}
        }
    },
    components: {
        VueUploadMultipleImage
    },
    computed : {
        getPropertyElements(){
            return this.form.propertyElements;
        }
    },
    methods: {
        newProperty() {  // YENI OZELLIK EKLEME KISMI
            var new_property = {};
            this.form.propertyElements.push(new_property);
        },
        removeProperty(index_deger) { // OZELLIK SILME KISMI
            this.form.propertyElements = this.form.propertyElements.filter((item,index) => {
                return index !== index_deger;
            })
        },
        propertyNameInput(index,event){  // OZELLIK YAZINCA OTOMATIK OLARKA GUNCELLEME ISLEMI (NPUTLARDAN HEMEN GUNCELLENECEK)
            this.form.propertyElements[index][event.target.name] = event.target.value;
        },
        async getCategories() {
            const res = await this.callApi("get", "/api/product/create", {}, {
                'Authorization': "Bearer " + AppStorage.getToken()
            });

            if (res.status == 200) {
                this.categories = res.data;
            }
        },
        async addProduct(){

            let formData = new FormData();
            formData.append("product_category_id",this.form.product_category_id);
            formData.append("product_name",this.form.product_name);
            formData.append("product_barcode",this.form.product_barcode);
            formData.append("product_model_code",this.form.product_model_code);
            formData.append("product_brand",this.form.product_brand);
            formData.append("product_stock",this.form.product_stock);
            formData.append("product_tax",this.form.product_tax);
            formData.append("product_buying_price",this.form.product_buying_price);
            formData.append("product_selling_price",this.form.product_selling_price);
            formData.append("product_description",this.form.product_description);
            formData.append("product_property",JSON.stringify(this.form.propertyElements));

            // RESIM KISMI
            for (var i = 0; i<this.form.product_images.length; i++){
                formData.append('image[]',this.form.product_images[i].path);
            }


            const res = await this.callApi("post","/api/product/store",formData,{
                'Authorization' : "Bearer "+AppStorage.getToken(),
            });

            if (res.status==200){
                Notification.success();
                this.$refs.productInfoForm.reset();
                this.form.product_name = "";
                this.form.product_model_code = "";
                this.form.product_barcode = "";
                this.form.product_brand = "";
                this.form.product_stock = "";
                this.form.product_tax = "";
                this.form.product_buying_price = "";
                this.form.product_selling_price = "";
                this.form.product_description = "";
                this.form.product_category_id = "";
                this.form.propertyElements = [];
                this.form.product_images = [];
            }else{
                Notification.error();
                this.errors = {};
                this.errors = res.data.errors;
            }
        },
        uploadImageSuccess(formData, index, fileList) {
            // console.log('data', formData, index, fileList);
            this.form.product_images = fileList;
            // Upload image api
            // axios.post('http://your-url-upload', formData).then(response => {
            //   console.log(response)
            // })
        },
        beforeRemove (index, done, fileList) {
            console.log('index', index, fileList)
            var r = confirm("Resmi Sileceksiniz. Onaylıyor Musunuz ?")
            if (r == true) {
                done()
            }
        },
        editImage (formData, index, fileList) {
            // console.log('edit data', formData, index, fileList)
        }
    }
}
</script>

<style scoped>

</style>
