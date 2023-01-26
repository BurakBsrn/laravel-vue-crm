import Vue from 'vue';
import VueRouter from "vue-router";

Vue.use(VueRouter);

/** ADMIN KISIMALRI */
let admin_home = require('../components/back/home/AdminHomeComponent').default;

/** AUTH KISIMLARI **/
let admin_login = require('../components/back/auth/AdminLoginComponent').default;
let admin_register = require('../components/back/auth/AdminRegisterComponent').default;
let admin_logout = require('../components/back/auth/AdminLogoutComponent').default;

/** URUNLER KISMI **/
let admin_products = require('../components/back/product/AdminProductListComponent').default;
let admin_product_create = require('../components/back/product/AdminProductCreateComponent').default;
let admin_product_edit = require('../components/back/product/AdminProductEditComponent').default;
let admin_product_search = require('../components/back/product/AdminProductSearchComponent').default;

/** KATEGORILER KISMI **/
let admin_categories = require('../components/back/category/AdminCategoryListComponent').default;
let admin_category_search= require('../components/back/category/AdminCategorySearchComponent').default;
let admin_category_create = require('../components/back/category/AdminCategoryCreateComponent').default;
let admin_category_edit = require('../components/back/category/AdminCategoryEditComponent').default;

/** MUSTERILER KISMI **/
let admin_customers = require('../components/back/customer/AdminCustomerListComponent').default;
let admin_customer_search = require('../components/back/customer/AdminCustomerSearchComponent').default;
let admin_customer_create = require('../components/back/customer/AdminCustomerCreateComponent').default;
let admin_customer_edit = require('../components/back/customer/AdminCustomerEditComponent').default;

/** STOKLAR KISMI **/
let admin_stocks = require('../components/back/stock/AdminStockListComponent').default;
let admin_stock_search = require('../components/back/stock/AdminStockSearchComponent').default;
let admin_stock_create = require('../components/back/stock/AdminStockCreateComponent').default;
let admin_stock_edit = require('../components/back/stock/AdminStockEditComponent').default;

/** PROFİL KISMI **/
let admin_profil = require('../components/back/profile/AdminProfileComponent').default;


const routes = [
    /** ADMIN KISIMLARI */
    {path: '/', component: admin_home, name: 'admin_home'},

    /** AUTH KISIMLARI **/
    {path: '/login', component: admin_login, name: 'admin_login'},
    {path: '/register', component: admin_register, name: 'admin_register'},
    {path: '/logout', component: admin_logout, name: 'admin_logout'},

    /** URUNLER KISIMLARI **/
    {path: '/products', component: admin_products, name: 'admin_products'},
    {path: '/product-search', component: admin_product_search, name: 'admin_product_search'},
    {path: '/product-create', component: admin_product_create, name: 'admin_product_create'},
    {path: '/product-edit/:id', component: admin_product_edit, name: 'admin_product_edit'},

    /** KATEGORILER KISIMLARI **/
    {path: '/categories', component: admin_categories, name: 'admin_categories'},
    {path: '/category-search', component: admin_category_search, name: 'admin_category_search'},
    {path: '/category-create', component: admin_category_create, name: 'admin_category_create'},
    {path: '/category-edit/:id', component: admin_category_edit, name: 'admin_category_edit'},

    /** MUSTERILER KISIMLARI **/
    {path: '/customers', component: admin_customers, name: 'admin_customers'},
    {path: '/customer-search', component: admin_customer_search, name: 'admin_customer_search'},
    {path: '/customer-create', component: admin_customer_create, name: 'admin_customer_create'},
    {path: '/customer-edit/:id', component: admin_customer_edit, name: 'admin_customer_edit'},

    /** STOKLAR KISMI **/
    {path: '/stocks', component: admin_stocks, name: 'admin_stocks'},
    {path: '/stock-search', component: admin_stock_search, name: 'admin_stock_search'},
    {path: '/stock-create', component: admin_stock_create, name: 'admin_stock_create'},
    {path: '/stock-edit/:id', component: admin_stock_edit, name: 'admin_stock_edit'},

    /** PROFİL KISMI **/
    {path: '/profile', component: admin_profil, name: 'admin_profil'},

    /** NOT FOUND KISMI (BASKA BISEY BASILINCA BURAYA GELECEK) **/
    {path : '/:NotFound(.*)*', component : admin_home}
];

export default new VueRouter({
    mode: 'history',
    routes
});
