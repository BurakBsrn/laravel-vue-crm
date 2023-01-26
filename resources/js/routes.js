import Vue from 'vue';
import VueRouter from 'vue-router';
import NProgress from "nprogress";

Vue.use(VueRouter);

const GuestLayout = () => import('./views/guest/layouts/GuestLayout');
const GuestLogin = () => import('./views/guest/pages/GuestLogin');
const GuestForbidden = () => import('./views/guest/pages/GuestForbidden');
const GuestRegister = () => import('./views/guest/pages/GuestRegister');

const AuthLayout = () => import('./views/auth/layouts/AuthLayout');
const AuthIndex = () => import('./views/auth/pages/dashboard/Index');

const ProfileIndex = () => import('./views/auth/pages/profile/index');

// const PersonsLayout = () => import('./views/auth/pages/persons/layout');
// const PersonsList = () => import('./views/auth/pages/persons/show');
// const PersonCreate = () => import('./views/auth/pages/persons/create');

const CategoryIndex = () => import('./views/auth/pages/category/index');
const CategoryCreate = () => import('./views/auth/pages/category/create');
const CategoryEdit = () => import('./views/auth/pages/category/edit');
const CategorySearch = () => import('./views/auth/pages/category/search');


const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'green',
    routes: [

        {
            path: '',
            component: GuestLayout,
            meta: {
                auth: false
            },
            redirect: '/login',
            children: [
                {
                    path:'/login',
                    name:'login',
                    component: GuestLogin
                },
                {
                    path:'/forbidden',
                    name:'forbidden',
                    component: GuestForbidden
                },
                {
                    path:'/register',
                    name:'register',
                    component: GuestRegister
                },
            ]
        },

        {
            path: '',
            component: AuthLayout,
            meta: {
                auth: true
            },
            children: [
                {
                    path:'dashboard',
                    name:'auth.dashboard',
                    component: AuthIndex,
                },

                {
                    path:'categories',
                    name:'auth.categories',
                    component: CategoryIndex,
                },
                {
                    path:'category-create',
                    name:'auth.category.create',
                    component: CategoryCreate,
                },
                {
                    path:'category-edit/:id',
                    name:'auth.category.edit',
                    component: CategoryEdit,
                },
                {
                    path:'category-search',
                    name:'auth.category.search',
                    component: CategorySearch,
                },

                {
                    path:'profile',
                    name:'auth.profile',
                    component: ProfileIndex,
                },


            ]
        },

        {
            path: '/:NotFound(.*)*',
            redirect: '/dashboard',
            meta: {
                auth: true
            },
        },

    ],
});

router.beforeResolve((to, from, next) => {
    if (to.path) {
        NProgress.start();
    }
    next();
});

router.afterEach((to, from) => {
    NProgress.done();
});

export default router;
