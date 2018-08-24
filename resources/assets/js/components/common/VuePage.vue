<template>
    <div :class="{ 'loader-container': loading }">
        <div class="container-fluid" v-if="!loading">
            <transition name="animated fadeIn">
                <main role="main" class="lbv-page animated fadeIn fadeOut">
                    <slot></slot>
                </main>
            </transition>
        </div>
        <block-loader class="block-loader align-self-center justify-content-center"
                      v-if="loading">
        </block-loader>
    </div>
</template>

<script>
    import BlockLoader from './BlockLoader';

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

    .loader-container {
        display: flex;
        flex-grow: 1;
        justify-content: center;
    }

    .lbv-page .block-loader {
        height: 100%;
    }
</style>
