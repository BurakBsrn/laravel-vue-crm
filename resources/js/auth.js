import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'

const config = {
    auth: bearer,
    http: axios,
    router: router,
    tokenDefaultName: 'dashboard_session',
    tokenStore: ['localStorage'],
    authRedirect: {name: 'login'},
    registerData: {url: "register", method: 'POST', redirect: '/login'},
    loginData: {url: "login", method: 'POST', redirect: '/dashboard', fetchUser: true},
    logoutData: {url: "logout", method: 'GET', redirect: '/login', makeRequest: true},
    fetchData: {url: "user", method: 'GET', enabled: true},
    refreshData: {url: "refresh", method: 'GET', enabled: true, interval: 30},
    rolesKey: 'permissions',
    parseUserData: (data) => {
        if (data?.data) {
            data = data?.data;
            data['roles'] = data?.data?.has_role_permissions.map((roles) => roles.slug);
            data['permissions'] = data?.data?.has_role_permissions.map(
                (items) => items.permissions.map(
                    (permissions) => permissions.slug
                )
            ).values().next().value;
        }
        return data;
    }
};
export default config
