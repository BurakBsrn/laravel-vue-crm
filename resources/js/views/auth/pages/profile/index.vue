<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Profil Bilgileri</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <form @submit.prevent="updateProfile" enctype="multipart/form-data">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Profil Bilgileri</h5>
                                    </div>
                                    <div class="card-body">
                                        <form class="theme-form">
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
                                                                :data-images="form.images"
                                                            ></vue-upload-multiple-image>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Ad Soyad</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text" v-model="form.name"
                                                                   aria-describedby="emailHelp" placeholder="Adınız Soyadınız">
                                                            <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">E-Mail Adresiniz</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="text" v-model="form.email"
                                                                   aria-describedby="emailHelp" placeholder="Adınız Soyadınız">
                                                            <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Şifreniz</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="password" v-model="form.password"
                                                                   aria-describedby="emailHelp" placeholder="Şifreniz">
                                                            <span class="text-danger" v-if="form.password">{{ errors.password[0] }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Şifre (Tekrar)</label>
                                                            <input class="form-control" id="exampleInputEmail1"
                                                                   type="password" v-model="form.password_confirmation"
                                                                   aria-describedby="emailHelp" placeholder="Şifre (Tekrar)">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">Güncelle</button>
                                        <router-link :to="{name : 'admin_home'}" class="btn btn-secondary text-white">Anasayfa
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
    name: "ProfileIndex",
    created() {
        this.getProfile();
    },
    data(){
        return {
            form : {
                images : [],
                name : '',
                email : '',
                password : '',
                password_confirmation : ''
            },
            errors : {}
        }
    },
    components: {
        VueUploadMultipleImage
    },
    methods : {
        async getProfile(){
            const res = await this.callApi("post","/api/auth/me",{},{
                'Authorization' : "Bearer "+AppStorage.getToken()
            });

            if (res.status==200){
                this.form.images = res.data.images;
                this.form.name = res.data.name;
                this.form.email = res.data.email;
            }
        },
        async updateProfile(){
            const id = User.id();

            let formData = new FormData();
            formData.append("_method","PATCH");
            formData.append("name",this.form.name);
            formData.append("email",this.form.email);
            formData.append("password",this.form.password);
            formData.append("password_confirmation",this.form.password_confirmation);

            // RESIM KISMI
            for (var i = 0; i<this.form.images.length; i++){
                formData.append('images[]',this.form.images[i].path);
            }

            const res = await this.callApi("post","/api/profile/"+id+"/update",formData,{
                'Authorization' : "Bearer "+AppStorage.getToken()
            });

            if (res.status==200){
                Notification.success();
                this.form.password = "";
                this.form.password_confirmation = "";
            }else{
                Notification.error();
                this.errors = {};
                this.errors = res.data.errors;
            }
        },
        uploadImageSuccess(formData, index, fileList) {
            // console.log('data', formData, index, fileList);
            // console.log(fileList);
            this.form.images = fileList;
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
