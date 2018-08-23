<template>
    <div class="app">
        <AppHeader fixed>
            <SidebarToggler class="d-lg-none" display="md" mobile />
            <b-link class="navbar-brand" to="#">
                LBV Admin
            </b-link>
            <SidebarToggler class="d-md-down-none" display="lg" />
            <b-navbar-nav class="ml-auto">
                <DefaultHeaderDropdownAccnt/>
            </b-navbar-nav>
            <AsideToggler class="d-none d-lg-block" />
            <!--<AsideToggler class="d-lg-none" mobile />-->
        </AppHeader>
        <div class="app-body">
            <AppSidebar fixed>
                <SidebarHeader/>
                <SidebarForm/>
                <SidebarNav :navItems="nav" ></SidebarNav>
                <SidebarFooter/>
                <SidebarMinimizer/>
            </AppSidebar>
            <main class="main">
                <Breadcrumbs :list="breadcrumbs" />
                <div class="container-fluid">
                    <transition name="animated fadeIn">
                        <router-view></router-view>
                    </transition>
                </div>
            </main>
            <AppAside fixed>
                <!--aside-->
                <DefaultAside/>
            </AppAside>
        </div>
        <TheFooter>
            <!--footer-->
            <div class="ml-auto">
                <span class="mr-1">Powered by</span>
                <a href="https://coreui.io">CoreUI for Vue</a>
            </div>
        </TheFooter>
        <notifications group="app" position="top right"></notifications>
        <yes-no-dialog></yes-no-dialog>
    </div>
</template>

<script>
    import { Header as AppHeader, SidebarToggler, Sidebar as AppSidebar, SidebarFooter, SidebarForm, SidebarHeader, SidebarMinimizer, SidebarNav, Aside as AppAside, AsideToggler, Footer as TheFooter } from '@coreui/vue'
    import DefaultAside from '../DefaultAside'
    import DefaultHeaderDropdownAccnt from '../DefaultHeaderDropdownAccnt'
    import nav from '../../nav'
    import Breadcrumbs from '../common/Breadcrumbs';

    export default {
        name: 'full',
        components: {
            AsideToggler,
            AppHeader,
            AppSidebar,
            AppAside,
            TheFooter,
            Breadcrumbs,
            DefaultAside,
            DefaultHeaderDropdownAccnt,
            SidebarForm,
            SidebarFooter,
            SidebarToggler,
            SidebarHeader,
            SidebarNav,
            SidebarMinimizer
        },
        data () {
            return {
                nav: nav.items
            }
        },
        computed: {
            breadcrumbs() {
                return this.$route.matched.filter((route) => route.meta.label )
            }
        }
    }
</script>
