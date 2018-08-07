<template>
    <transition name="fade">
    <main role="main" class="lbv-page col-sm-9 ml-sm-auto col-lg-10 px-4">
        <transition name="fade">
            <slot v-if="!loading"></slot>
        </transition>
        <block-loader class="block-loader align-self-center justify-content-center" v-if="loading"></block-loader>
    </main>
    </transition>
</template>

<script>
    import BlockLoader from './common/BlockLoader';

    export default {
        inject: {
            $validator: '$validator'
        },
        components: {
            BlockLoader
        },
        props: {
            loading: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style>
    .lbv-page {
        height: 100vh;
    }

    .lbv-page .block-loader {
        height: 100%;
    }
</style>