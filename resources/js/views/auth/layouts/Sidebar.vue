<template>
    <!-- Page Sidebar Start-->
    <div class="sidebar-wrapper">
        <div>
            <div class="logo-wrapper">
                <router-link class="logo" :to="{name: 'auth.dashboard'}">
                    <h3>mCRM</h3>
                </router-link>
                <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
                </div>
            </div>
            <div class="logo-icon-wrapper">
                <router-link :to="{name: 'auth.dashboard'}">
                    <img class="img-fluid" src="/back/assets/images/logo/logo-icon.png" alt="">
                </router-link>
            </div>
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn">
                            <router-link :to="{name: 'auth.dashboard'}">
                                <img class="img-fluid" src="/back/assets/images/logo/logo-icon.png" alt="">
                            </router-link>
                            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                                  aria-hidden="true"></i></div>
                        </li>
                        <li class="sidebar-list">
                            <router-link class="sidebar-link sidebar-title link-nav" :to="{name: 'auth.dashboard'}"><i
                                data-feather="home"> </i><span>Anasayfa</span></router-link>
                        </li>
                        <li class="sidebar-list">
                            <router-link class="sidebar-link sidebar-title" :to="{name: 'auth.products'}">
                                <i data-feather="gift"></i><span>Ürünler</span>
                            </router-link>
                            <ul class="sidebar-submenu">
                                <li>
                                    <router-link :to="{name: 'auth.products'}">Ürün Listesi</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'auth.product_create'}">Yeni Ürün</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'auth.product_search'}">Ürün Ara</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-list">
                            <router-link class="sidebar-link sidebar-title" :to="{name: 'auth.categories'}">
                                <i data-feather="gift"></i><span>Kategoriler</span>
                            </router-link>
                            <ul class="sidebar-submenu">
                                <li>
                                    <router-link :to="{name: 'auth.categories'}">Kategori Listesi</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'auth.category.create'}">Yeni Kategori</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'auth.category.search'}">Kategori Ara</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                            data-feather="users"></i><span>Müşteriler</span></a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <router-link :to="{name: 'auth.customers'}">Müşteri Listesi</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'auth.customer_create'}">Yeni Müşteri</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'auth.customer_search'}">Müşteri Ara</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                            data-feather="layers"></i><span>Stoklar</span></a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <router-link :to="{name: 'auth.stocks'}">Stok Listesi</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'auth.stock_create'}">Yeni Stok</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'auth.stock_search'}">Stok Ara</router-link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
        </div>
    </div>
    <!-- Page Sidebar Ends-->
</template>

<script>
export default {
    name: "Sidebar"
}
</script>

<style scoped>

</style>
