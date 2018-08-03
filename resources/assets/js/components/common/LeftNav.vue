<template>
    <nav class="col-md-2 d-none d-md-block bg-light sidebar main-nav">

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
                        to: { name: 'users.index'},
                        label: 'Users',
                    }
                ]
            }
        }
    }
</script>