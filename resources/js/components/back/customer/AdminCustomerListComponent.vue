<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Müşteriler</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Müşteriler</h5>

                            <div class="row">
                                <div class="col-md-3 my-3">
                                    <input type="text" v-model="searchTerm" class="form-control" placeholder="Müşteri Ara (İsim ile)">
                                </div>
                                <div class="col-md-9 my-3">
                                    <router-link :to="{name : 'admin_customer_create'}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Yeni Müşteri Ekle</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hesap Tipi</th>
                                    <th>Ad Soyad</th>
                                    <th>Telefon</th>
                                    <th>E-Mail</th>
                                    <th>İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in filterCustomers">
                                    <td>{{ item.customer_id }}</td>
                                    <td>{{ (item.customer_type==1) ? 'Tedarikçi' : 'Müşteri' }}</td>
                                    <td>{{ item.customer_name }}</td>
                                    <td>{{ item.customer_phone }}</td>
                                    <td>{{ item.customer_email }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" @click="deleteCustomer(item.customer_id)"><i class="fa fa-times"></i> Sil</button>
                                        <router-link :to="{name : 'admin_customer_edit', params : {id : item.customer_id}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Güncelle</router-link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <pagination :data="items" @pagination-change-page="getCustomers"></pagination>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminCustomerListComponent",
    created() {
        if (!User.loggedIn()) {
            this.$router.push({name: 'admin_login'});
        }

        this.getCustomers();
    },
    computed : {
        filterCustomers(){
            return this.items.data.filter(item => {
                return item.customer_name.match(this.searchTerm);
            })
        }
    },
    data(){
        return {
            items : {
                data : []
            },
            searchTerm : ''
        }
    },
    methods :  {
        async getCustomers(page = 1){
            const res = await this.callApi("get","/api/customer?page="+page,{},{
                'Authorization': "Bearer " + AppStorage.getToken()
            });

            if (res.status==200){
                this.items = res.data;
            }
        },
        async deleteCustomer(customer_id){
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
                    const del = await this.callApi("delete", '/api/customer/' + customer_id + "/delete",{},{
                        'Authorization' : "Bearer "+AppStorage.getToken()
                    });
                    if (del.status == 200) {
                        Swal.fire(
                            'Başarılı!',
                            'Kayıt Başarıyla Silindi',
                            'success'
                        );
                        this.items.data = this.items.data.filter(item => {
                            return item.customer_id != customer_id;
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
