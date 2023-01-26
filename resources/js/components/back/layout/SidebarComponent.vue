<template>
    <!-- Page Sidebar Start-->
    <div class="sidebar-wrapper">
        <div v-show="($route.path==='/login' || $route.path==='/register' || $route.path==='/forget') ? false : true">
            <div class="logo-wrapper">
                    <a class="logo" href="javascript:void(0)">
                        <h3>
                            mCRM
                        </h3>
                    </a>
                <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
                </div>
            </div>
            <div class="logo-icon-wrapper">
                <router-link :to="{name : 'admin_home'}"><img class="img-fluid"
                                                              src="/back/assets/images/logo/logo-icon.png" alt="">
                </router-link>
            </div>
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn">
                            <router-link :to="{name : 'admin_home'}"><img class="img-fluid"
                                                                          src="/back/assets/images/logo/logo-icon.png"
                                                                          alt=""></router-link>
                            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                                  aria-hidden="true"></i></div>
                        </li>
                        <li class="sidebar-list">
                            <router-link class="sidebar-link sidebar-title link-nav" :to="{name : 'admin_home'}"><i
                                data-feather="home"> </i><span>Anasayfa</span></router-link>
                        </li>
                        <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                            data-feather="gift"></i><span>Ürünler</span></a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <router-link :to="{name : 'admin_products'}">Ürün Listesi</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name : 'admin_product_create'}">Yeni Ürün</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name : 'admin_product_search'}">Ürün Ara</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                            data-feather="list"></i><span>Kategoriler</span></a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <router-link :to="{name : 'admin_categories'}">Kategori Listesi</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name : 'admin_category_create'}">Yeni Kategori</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name : 'admin_category_search'}">Kategori Ara</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                            data-feather="users"></i><span>Müşteriler</span></a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <router-link :to="{name : 'admin_customers'}">Müşteri Listesi</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name : 'admin_customer_create'}">Yeni Müşteri</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name : 'admin_customer_search'}">Müşteri Ara</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                            data-feather="layers"></i><span>Stoklar</span></a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <router-link :to="{name : 'admin_stocks'}">Stok Listesi</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name : 'admin_stock_create'}">Yeni Stok</router-link>
                                </li>
                                <li>
                                    <router-link :to="{name : 'admin_stock_search'}">Stok Ara</router-link>
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
    name: "SidebarComponent"
}
</script>

<style scoped>

</style>
