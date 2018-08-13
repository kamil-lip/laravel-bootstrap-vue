<template>
    <nav class="col-sm-3 col-lg-2 bg-light sidebar main-nav px-2">

        <b-nav vertical>
            <b-nav-item :to="{ name: 'home' }" exact><i class="fas fa-home"></i> Home</b-nav-item>
        </b-nav>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
            <span>Resources</span>
        </h6>

        <b-nav vertical>
            <b-nav-item :to="item.to" v-for="item in menuItems" :key="item.label" exact><i :class="item.iconClass"></i>
                {{ item.label }}
            </b-nav-item>
        </b-nav>

    </nav>

</template>

<script>
    export default {
        data() {
            return {
                menuItems: [
                    {
                        iconClass: 'fas fa-users',
                        to: { name: 'resource.index', params: {resource: 'users'} },
                        label: 'Users',
                    }
                ]
            }
        }
    }
</script>