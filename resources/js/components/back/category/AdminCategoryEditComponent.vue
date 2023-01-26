<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Kategori Güncelle</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <form @submit.prevent="updateCategory" enctype="multipart/form-data">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Kategori Güncelle</h5>
                                        <span>Güncellemek istediğiniz kategori bilgilerini eksiksiz olarak giriniz</span>
                                    </div>
                                    <div class="card-body">
                                        <form class="theme-form">
                                            <div class="form-group">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Kategori
                                                                Adı</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text" v-model="form.category_name"
                                                                   aria-describedby="emailHelp"
                                                                   placeholder="Kategori Adı">
                                                            <span class="text-danger" v-if="errors.category_name">{{
                                                                    errors.category_name[0]
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-pencil"></i> Güncelle</button>
                                        <router-link :to="{name : 'admin_categories'}"
                                                     class="btn btn-secondary text-white"><i class="fa fa-arrow-left"></i> Kategoriler
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
    name: "AdminCategoryEditComponent",
    created() {
        if (!User.loggedIn()) {
            this.$router.push({name: 'admin_login'});
        }

        const category_id = this.$route.params.id;
        this.getCategory(category_id);
    },
    data() {
        return {
            form: {
                category_name: ''
            },
            errors: {}
        }
    },
    methods: {
        async getCategory(category_id) {
            const res = await this.callApi("get", "/api/category/" + category_id + "/edit", {}, {
                'Authorization': "Bearer " + AppStorage.getToken()
            });

            if (res.status == 200) {
                this.form.category_name = res.data.category_name;
            } else {
                this.$router.push({name: 'admin_categories'});
            }
        },
        async updateCategory() {
            const category_id = this.$route.params.id;
            const res = await this.callApi("patch", "/api/category/" + category_id + "/update", this.form, {
                'Authorization': "Bearer " + AppStorage.getToken()
            });

            if (res.status == 200) {
                Notification.success();
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
