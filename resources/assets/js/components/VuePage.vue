<template>
    <div class="container-fluid">
        <transition name="animated fadeIn">
            <main role="main" class="lbv-page animated fadeIn fadeOut">
                <transition name="fade">
                    <div>
                        <slot v-if="!loading"></slot>
                    </div>
                </transition>
                <block-loader class="block-loader align-self-center justify-content-center"
                              v-if="loading"></block-loader>
            </main>
        </transition>
    </div>
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

    .lbv-page .block-loader {
        height: 100%;
    }
</style>
