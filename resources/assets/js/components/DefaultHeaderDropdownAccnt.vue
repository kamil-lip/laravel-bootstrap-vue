<template>
    <AppHeaderDropdown right no-caret>
        <template slot="header">
            <img
                src="/images/avatars/6.jpg"
                class="img-avatar"
                :alt="profile ? profile.name : 'Please wait'" />
        </template>
        <template slot="dropdown">
            <b-dropdown-item @click="logout"><i class="fa fa-lock"/> Logout</b-dropdown-item>
            <form ref="logoutForm" id="logout-form" action="/logout" method="POST" style="display: none;">
                <input type="hidden" name="_token" :value="csrfToken" />
            </form>
        </template>
    </AppHeaderDropdown>
</template>

<script>
    import {HeaderDropdown as AppHeaderDropdown} from '@coreui/vue'
    import Auth from '../Auth';

    export default {
        name: 'DefaultHeaderDropdownAccnt',
        components: {
            AppHeaderDropdown
        },
        data: () => {
            return {
                itemsCount: 42,
                profile: null
            }
        },
        computed: {
            csrfToken() {
                return document.querySelector('meta[name=csrf-token]').content
            }
        },
        methods: {
            logout() {
                this.$refs.logoutForm.submit();
            },
            async getProfile() {
                this.profile = await Auth.getProfile();
            }
        },
        created() {
            this.getProfile();
        }
    }
</script>
