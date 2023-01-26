<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Ürün Ara</h3>
                </div>
            </div>
        </div>


        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <form @submit.prevent="searchProduct" enctype="multipart/form-data">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="theme-form">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Ürün Ara (Barkod)</label>
                                                            <input class="form-control" id="exampleInputEmail1" v-model="product_barcode"
                                                                   type="text" aria-describedby="emailHelp" placeholder="Barkod Numarası">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Ara</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Ürünler</h5>
                            <div class="row">
                                <div class="col-md-3 my-3">
                                    <input type="text" v-model="searchTerm" class="form-control" placeholder="Ürün Ara (Barkod)">
                                </div>
                                <div class="col-md-9 my-3">
                                    <router-link :to="{name : 'admin_product_create'}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Yeni Ürün Ekle</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Model Numarası</th>
                                    <th>Barkod Numarası</th>
                                    <th>Ürün Adı</th>
                                    <th>Stok</th>
                                    <th>Satış Fiyatı</th>
                                    <th>İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in filterProducts">
                                    <th>{{ item.product_id }}</th>
                                    <td>{{ item.product_model_code }}</td>
                                    <td>{{ item.product_barcode }}</td>
                                    <td>{{ item.product_name }}</td>
                                    <td>{{ item.product_stock }}</td>
                                    <td>{{ item.product_selling_price }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" @click="deleteProduct(item.product_id)"><i class="fa fa-times"></i> Sil</button>
                                        <router-link :to="{name : 'admin_product_edit', params : {id : item.product_id}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Güncelle</router-link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <pagination :data="items" @pagination-change-page="searchProduct"></pagination>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminProductSearchComponent",
    created() {
        if (!User.loggedIn()) {
            this.$router.push({name: 'admin_login'});
        }
    },
    data(){
        return {
            items : {
                data : []
            },
            product_barcode : '',
            searchTerm : ''
        }
    },
    computed : {
        filterProducts(){
            return this.items.data.filter(item => {
                return item.product_barcode.match(this.searchTerm);
            })
        }
    },
    methods : {
        async searchProduct(page = 1){
            const res = await this.callApi("get","/api/product/search?aranan="+this.product_barcode+"&page="+page,{
                aranan : this.product_barcode
            },{
                'Authorization': "Bearer " + AppStorage.getToken()
            });

            if (res.status==200){
                this.items = res.data;
            }
        },
        async deleteProduct(product_id){
            Swal.fire({
                title: 'Dikkat !',
                text: "Kayıt Silinecektir. Onaylıyor Musunuz ? (Bu İşlem Geri Alınamaz)",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, Kaydı Sil!',
                cancelButtonText : 'Vazgeç'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const del = await this.callApi("delete", '/api/product/' + product_id + "/delete",{},{
                        'Authorization' : "Bearer "+AppStorage.getToken()
                    });
                    if (del.status == 200) {
                        Swal.fire(
                            'Başarılı!',
                            'Kayıt Başarıyla Silindi',
                            'success'
                        );
                        this.items.data = this.items.data.filter(item => {
                            return item.product_id != product_id;
                        });
                    }else{
                        Notification.error();
                    }
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
