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
                                    <h4 class="mb-0 counter">{{ hesaplar }} Adet</h4>
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
                                    <h4 class="mb-0 counter">{{ urunler }} Adet</h4>
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
                                    <h4 class="mb-0 counter">{{ islemler }} Adet</h4>
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
                                    <h4 class="mb-0 counter">{{ kategoriler }} Adet</h4>
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
                                    <h4 class="mb-0 counter">{{ instock }} Adet</h4>
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
                                    <h4 class="mb-0 counter">{{ outstock }} Adet</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- BAR KISMI -->
            <div class="row">
                <!-- STOK GİRİŞ -->
                <div class="col-sm-6 col-xl-6 col-lg-6">
                    <Bar
                        :chart-options="chartOptions"
                        :chart-data="stockGirisData"
                        :chart-id="chartId"
                        :dataset-id-key="datasetIdKey"
                        :plugins="plugins"
                        :css-classes="cssClasses"
                        :styles="styles"
                        :width="width"
                        :height="height"
                    />
                </div>

                <!-- STOK ÇIKIŞ -->
                <div class="col-sm-6 col-xl-6 col-lg-6">
                    <Bar
                        :chart-options="chartOptions"
                        :chart-data="stockCikisData"
                        :chart-id="chartId"
                        :dataset-id-key="datasetIdKey"
                        :plugins="plugins"
                        :css-classes="cssClasses"
                        :styles="styles"
                        :width="width"
                        :height="height"
                    />
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: "AdminHomeComponent",
    components: { Bar },
    props: {
        chartId: {
            type: String,
            default: 'bar-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        plugins: {
            type: Object,
            default: () => {}
        }
    },
    created(){
        if (!User.loggedIn()){
            this.$router.push({name : 'admin_login'});
        }

        this.getAnaliytcs();
    },
    data(){
        return{
            hesaplar : '',
            urunler  : '',
            islemler : '',
            kategoriler : '',
            instock : '',
            outstock : '',
            stockGirisData: {
                labels: [],
                datasets: [ {
                    label : "Stok Giriş",
                    data: []
                } ]
            },
            stockCikisData: {
                labels: [],
                datasets: [ {
                    label : "Stok Çıkış",
                    data: []
                } ]
            },
            chartOptions: {
                responsive: true
            }
        }
    },
    methods : {
        async getAnaliytcs(){
            const res = await this.callApi("get","/api/home",{},{
                'Authorization' : "Bearer "+AppStorage.getToken()
            });

            console.log(res);

            if (res.status==200){
                this.hesaplar = res.data.hesaplar;
                this.urunler = res.data.urunler;
                this.islemler = res.data.islemler;
                this.kategoriler = res.data.kategoriler;
                this.instock = res.data.instock
                this.outstock = res.data.outstock

                /** STOK GİRİŞ **/
                this.stockGirisData.labels = res.data.stockGiris.labels;
                this.stockGirisData.datasets[0].data = res.data.stockGiris.data;

                /** STOK ÇIKIŞ **/
                this.stockCikisData.labels = res.data.stockCikis.labels;
                this.stockCikisData.datasets[0].data = res.data.stockCikis.data;
            }
        }
    }
}
</script>

<style scoped>

</style>
