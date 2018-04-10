<template>
    <!-- <pulseLoader></pulseLoader> -->
    <div v-if="visible" class="loading">
        <clip-loader class="spinner"
            :loading="visible"
            :size="size"
            :radius="radius"
            :color="color"></clip-loader>
    </div>
</template>

<script>
    export default {

        props: {
            size: {
                type: String,
                default: '100px',
            },
            radius: {
                type: String,
                default: '100px',
            },
            color: {
                type: String,
                default: '#337AB7',
            }
        },
        data() {
            return {
                visible: false,
            }
        },
        methods: {
            showLoading() {
                this.visible = true
            },
            hideLoading() {
                this.visible = false
            }
        },
        mounted() {
            Event.$on('show-loading', () => {
                this.showLoading()
            })

            Event.$on('hide-loading', () => {
                this.hideLoading()
            })
        }
    }
</script>

<style>
    .loading {
        position: fixed;
        height: 100%;
        width:100%;
        background-color: rgba(0,0,0,.4);
        z-index:10;
    }
    .spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 11;
    }
</style>