<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Kategoriler</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Kategoriler</h5>

                            <div class="row">
                                <div class="col-md-3 my-3">
                                    <input type="text" v-model="search" class="form-control" placeholder="Kategori Ara">
                                </div>
                                <div class="col-md-9 my-3">
                                    <router-link :to="{name: 'auth.category.create'}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Yeni Kategori Ekle</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <b-table
                                    :items="data.items"
                                    :fields="headers"
                                    responsive="sm"
                                    :per-page="data.meta.per_page"
                                    :busy.sync="loading"
                                    :sort-by.sync="orderBy"
                                    :sort-desc.sync="sortDesc"
                                    @sort-changed="sortChanged"
                                >
                                    <template v-slot:table-busy>
                                        <div class="text-center text-danger my-2">
                                            <b-spinner class="align-middle"></b-spinner>
                                            <strong>{{ loadingMessage + '...' }}</strong>
                                        </div>
                                    </template>
                                    <template v-slot:cell(id)="{ item }">
                                        {{ item.id }}
                                    </template>
                                    <template v-slot:cell(name)="{ item }">
                                        {{ item.name }}
                                    </template>
                                    <template v-slot:cell(actions)="{ item }">
                                        <button type="button" class="btn btn-danger btn-sm" @click="deleteCategories(item.id)"><i class="fa fa-times"></i> Sil</button>
                                        <router-link :to="{name: 'auth.category.edit', params: {id: item.id}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Güncelle</router-link>
                                    </template>
                                </b-table>
                            </div>
                            <div class="row">
                                <div class="col-2 d-flex justify-content-start mt-2 mb-2">
                                    <div>
                                        {{ $t('common.show') }}:
                                        <b-form-select v-model="perPage" small :options="pageOptions" @input="pageChange"></b-form-select>
                                    </div>
                                </div>
                                <div class="col-8 d-flex justify-content-center mt-2 mb-2">
                                    <div>
                                        <!-- pagination -->
                                        <b-pagination v-model="page" :total-rows="data.meta.total" :per-page="perPage" @input="pageChange"></b-pagination>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CategoryService from "../../../../services/api/CategoryService";
import Notification from "../../../../helpers/Notification";

export default {
    name: "AdminCategoryListComponent",
    data(){
        return {
            page: 1,
            perPage: 10,
            pageOptions: [10, 25, 50, 100],

            search: null,
            awaitingSearch: false,

            orderBy: "name",
            sortedBy: "desc",
            sortDesc : true,

            loading: true,

            data: {
                items: [],
                meta: {
                    current_page: 1,
                    per_page: 10,
                    total: 0,
                }
            },
        }
    },
    computed: {
        headers () {
            return [
                { key: 'id', label: 'ID', sortable: true },
                { key: 'name', label: 'Name', sortable: true },
                { key: 'actions', label: 'İşlemler', sortable: false },
            ]
        },
        loadingMessage () {
            return this.$t('common.loading');
        }
    },
    mounted() {
        this.list({page: this.page,perPage: this.perPage, orderBy: this.orderBy, sortedBy: this.sortedBy});
    },
    methods: {
        async list({page = 1, perPage = 10, orderBy = 'id', sortedBy = 'desc'}) {
            this.loading = true;
            let query = (new CategoryService())
                .paginate(page, perPage)
                .filter(this.search)
                .sort(orderBy, sortedBy)
                .all();

            let {data: response} = await query;
            this.data = response.data;
            this.loading = false;
        },
        pageChange() {
            this.list({page: this.page,perPage: this.perPage, orderBy: this.orderBy, sortedBy: this.sortedBy});
        },
        sortChanged(sort) {
            this.perPage = sort.perPage;
            this.orderBy = sort.sortBy;
            this.sortedBy = (sort.sortDesc ? 'desc' : 'asc');
            this.sortDesc = sort.sortDesc;
            this.list({page: this.page,perPage: this.perPage, orderBy: this.orderBy, sortedBy: this.sortedBy});
        },
        async deleteCategories(categoryId){
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
                    let query = (new CategoryService()).destroy(categoryId);
                    let {data: response} = await query;
                    await Notification.success(response);
                    this.pageChange();
                }
            })
        }
    },
    watch: {
        search: function(val) {
            if (!this.awaitingSearch) {
                setTimeout(() => {
                    this.list({});
                    this.awaitingSearch = false;
                }, 1000);
            }
            this.awaitingSearch = true;
        }
    }
}
</script>

<style scoped>

</style>
