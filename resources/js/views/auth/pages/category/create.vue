<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Kategori Ekle</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <form @submit.prevent="addCategory">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Kategori Bilgileri</h5>
                                        <span>Eklemek istediğiniz kategori bilgilerini eksiksiz olarak giriniz</span>
                                    </div>
                                    <div class="card-body">
                                        <form class="theme-form">
                                            <div class="form-group">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Kategori Adı</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text"
                                                                   v-model="form.name"
                                                                   @blur="$v.form.name.$touch()"
                                                                   aria-describedby="emailHelp" placeholder="Kategori Adı">
                                                            <div v-if="$v.form.name.$error">
                                                                <span class="text-danger" v-if="!$v.form.name.required">{{ $t('validations.required') }}</span>
                                                                <span class="text-danger" v-if="!$v.form.name.minLength">{{ $t('validations.minLength', [3]) }}</span>
                                                                <span class="text-danger" v-if="!$v.form.name.maxLength">{{ $t('validations.maxLength', [250]) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Kaydet</button>
                                        <router-link :to="{name: 'auth.categories'}" class="btn btn-secondary text-white"><i class="fa fa-arrow-left"></i> Kategoriler
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
import CategoryService from "../../../../services/api/CategoryService";
import {required, maxLength, minLength} from "vuelidate/lib/validators";
import Notification from "../../../../helpers/Notification";

export default {
    name: "CategoryCreate",
    data(){
        return {
            form : {},
        }
    },
    validations: {
        form:{
            name: {
                required, minLength: minLength(3), maxLength: maxLength(250)
            },
        },
    },
    methods : {
        async addCategory() {
            this.$v.$touch();
            if(!this.$v.$invalid) {
                let query = (new CategoryService()).store(this.form);
                let {data: response} = await query;
                await Notification.success(response);
            }
        }
    }
}
</script>

<style scoped>

</style>
