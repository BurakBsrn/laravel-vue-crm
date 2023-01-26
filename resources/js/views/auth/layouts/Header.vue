<template>
    <!-- Page Header Start-->
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <form class="form-inline search-full col" action="#" method="get">
                <div class="form-group w-100">
                    <div class="Typeahead Typeahead--twitterUsers">
                        <div class="u-posRelative">
                            <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .."  title="" autofocus>
                            <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                        </div>
                        <div class="Typeahead-menu"></div>
                    </div>
                </div>
            </form>
            <div class="header-logo-wrapper col-auto p-0">
                <div class="logo-wrapper"><router-link :to="{name: 'auth.dashboard'}"><img class="img-fluid" src="/back/assets/images/logo/logo.png" alt=""></router-link></div>
                <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
            </div>
            <div class="left-header col horizontal-wrapper ps-0">
            </div>
            <div class="nav-right col-8 pull-right right-header p-0">
                <ul class="nav-menus">
                    <li class="maximize"><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                    <li class="profile-nav onhover-dropdown p-0 me-0">
                        <div class="media profile-media"><img class="b-r-10" :width="37" :height="37" :src="'/back/assets/images/dashboard/profile.jpg'" :alt="$auth.user().full_name">
                            <div class="media-body"><span>{{ $auth.user().full_name }}</span>
                                <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
                            </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">
                            <li><router-link :to="{name: 'auth.profile'}"><i data-feather="settings"></i><span>Profil</span></router-link></li>
                            <li @click="logout()">
                                <a href="javascript: void(0);" class="green">
                                    <i data-feather="log-out"></i>
                                    <span>Çıkış Yap</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
           </div>
    </div>
    <!-- Page Header Ends-->
</template>

<script>
export default {
    name: "Header",
    data(){
        return {
        }
    },
    methods: {
        logout() {
            this.$auth.logout({
                success: function () {
                },
            })
        },
    }
}
</script>

<style scoped>

</style>
