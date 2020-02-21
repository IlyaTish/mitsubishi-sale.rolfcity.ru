<template>
    <div class="block-footer-container" :class="[device_platform]">
        <div class="content-container">
            <div class="info">Данный сайт носит исключительно информационно-справочный характер, не является публичной
                офертой.
                <br>
                Подробности акции по телефону <a :href="'tel:' + CONSTANTS.phone_raw"
                                                 class="phone"
                                                 v-text="CONSTANTS.phone"></a><br> и в дилерском центре ТЕХНИЧЕСКИЙ ЦЕНТР КУНЦЕВО
            </div>
        </div>
    </div>
</template>

<script>
    import Mixin from '../common/mixin';

    export default {
        name: "block-footer",
        mixins: [Mixin],
        data() {
            return {}
        },
        created() {

        }
    }
</script>

<style scoped lang="scss">
    @import "../styles/constants.scss";

    .mobile {
        &.block-footer-container {
            height: 115px;
        }
        .content-container {
            padding: 10px;
        }

    }

    .block-footer-container {
        width: 100%;
        height: 115px;
        background: #485865;
        color: #fff;
        font-family: "LADA Pragmatica", sans-serif;
    }

    a {
        color: #fff;
    }

    .content-container {
        max-width: 1300px;
        width: 100%;
        margin: 0 auto;
        padding-top: 30px;
    }

    .center-name {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .info {
        font-size: 12px;
        text-align: center;
    }


</style>
