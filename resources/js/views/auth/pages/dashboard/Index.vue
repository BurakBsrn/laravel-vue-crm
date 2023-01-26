<template>
    <div class="page-body">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Anasayfa</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden static-top-widget-card">
                        <div class="card-body">
                            <div class="media static-top-widget">
                                <div class="media-body">
                                    <h6 class="font-roboto">Toplam Hesaplar</h6>
                                    <h4 class="mb-0 counter">Adet</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden static-top-widget-card">
                        <div class="card-body">
                            <div class="media static-top-widget">
                                <div class="media-body">
                                    <h6 class="font-roboto">Toplam Ürünler</h6>
                                    <h4 class="mb-0 counter">Adet</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden static-top-widget-card">
                        <div class="card-body">
                            <div class="media static-top-widget">
                                <div class="media-body">
                                    <h6 class="font-roboto">Toplam İşlemler</h6>
                                    <h4 class="mb-0 counter">Adet</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden static-top-widget-card">
                        <div class="card-body">
                            <div class="media static-top-widget">
                                <div class="media-body">
                                    <h6 class="font-roboto">Toplam Kategoriler</h6>
                                    <h4 class="mb-0 counter">Adet</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6 col-xl-6 col-lg-6">
                    <div class="card o-hidden static-top-widget-card">
                        <div class="card-body">
                            <div class="media static-top-widget">
                                <div class="media-body">
                                    <h6 class="font-roboto">Stoktaki Ürün Sayısı</h6>
                                    <h4 class="mb-0 counter">Adet</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-6 col-lg-6">
                    <div class="card o-hidden static-top-widget-card">
                        <div class="card-body">
                            <div class="media static-top-widget">
                                <div class="media-body">
                                    <h6 class="font-roboto">Stokta Olmayan Ürün Sayısı</h6>
                                    <h4 class="mb-0 counter">Adet</h4>
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
    export default {
        name: "Index",
        mounted() {
        }
    }
</script>

<style scoped>

</style>
