<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Stoklar</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Stoklar</h5>

                            <div class="row">
                                <div class="col-md-3 my-3">
                                    <input type="date" v-model="searchTerm" class="form-control" placeholder="Stok Ara (Tarih)">
                                </div>
                                <div class="col-md-9 my-3">
                                    <router-link :to="{name : 'admin_stock_create'}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Yeni Stok Ekle</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>İşlem Tipi</th>
                                    <th>Hesap</th>
                                    <th>Ürün</th>
                                    <th>Adet</th>
                                    <th>Fiyat</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in getFilterStocks">
                                    <td>{{ item.stock_id }}</td>
                                    <td>{{ item.stockTypeString }}</td>
                                    <td>{{ item.customer_name }}</td>
                                    <td>{{ item.product_name }}</td>
                                    <td>{{ item.stock_quantity }}</td>
                                    <td>{{ item.stock_total_price }} ₺</td>
                                    <td>{{ item.stock_date }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="deleteStock(item.stock_id)"><i class="fa fa-times"></i> Sil</button>
                                        <router-link :to="{name : 'admin_stock_edit',params : {id : item.stock_id}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Güncelle</router-link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <pagination :data="items" @pagination-change-page="getStock"></pagination>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminStockListComponent",
    created() {
        if (!User.loggedIn()) {
            this.$router.push({name: 'admin_login'});
        }

        this.getStock();
    },
    data(){
        return {
            items : {
                data  : []
            },
            searchTerm : ''
        }
    },
    computed : {
        getFilterStocks(){
            return this.items.data.filter(item=>{
                return item.stock_date.match(this.searchTerm);
            })
        }
    },
    methods : {
        async getStock(page=1){
            const res = await this.callApi("get","/api/stock?page="+page,{},{
                'Authorization' : "Bearer "+AppStorage.getToken()
            })

            if (res.status==200){
                this.items = res.data;
            }
        },
        async deleteStock(stock_id){
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
                    const del = await this.callApi("delete", '/api/stock/' + stock_id + "/delete",{},{
                        'Authorization' : "Bearer "+AppStorage.getToken()
                    });
                    if (del.status == 200) {
                        Swal.fire(
                            'Başarılı!',
                            'Kayıt Başarıyla Silindi',
                            'success'
                        );
                        this.items.data = this.items.data.filter(item => {
                            return item.stock_id != stock_id;
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
