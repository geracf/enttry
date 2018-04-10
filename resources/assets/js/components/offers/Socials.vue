<template>
    <div class="row bubble__container">
        <div class="col-xs-4">
            <div class="circle--small">
                <a :href="left_bubble_url">
                    <i class="fa fa-2x" :class="left_bubble"></i>
                </a>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="circle">
                <a :href="center_bubble_url">
                    <img class="img--round" :src="center_bubble">
                </a>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="circle--small">
                <a :href="right_bubble_url">
                    <i class="fa fa-2x" :class="right_bubble"></i>
                </a>
            </div>
        </div>
        <div class="col-xs-12">
            <h4 class="offer__title">{{ company_name }}</h4>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            left_bubble: {
                type: String,
                default: 'fa-globe'
            },
            left_bubble_url: {
                type: String,
                default: '/'
            },
            center_bubble: {
                type: String,
                default: '/img/lapiz.png'
            },
            center_bubble_url: {
                type: String,
                default: '/'
            },
            right_bubble: {
                type: String,
                default: 'fa-twitter'
            },
            right_bubble_url: {
                type: String,
                default: '/'
            },
            company_name: {
                type: String,
                default: ''
            }
        }
    }
</script>

<style>

    .circle--small .fa {
        margin: 16px auto;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .img--round {
        width: 100%;
        height: 100%;
        border-radius: 90px;
    }

</style>