<template>
    <div class="block-contacts-container"
         :class="device_platform">
        <div class="header-text">Контакты</div>
        <div class="wrapper">
            <div id="ya-karto"></div>

            <div class="input-container">
                <div class="logo-container">
                    <div class="logo"></div>
                    <div class="logo-dealer"></div>
                </div>
                <div class="offices-container">
                    <div class="office-container"
                         v-for="office in offices">
                        <div class="office-phone">
                            <a :href="'tel:' + office.phone_raw"
                               class="phone">
                                {{office.phone}}
                            </a>
                        </div>
                        <div class="office-address">{{office.address}}</div>
                        <div class="office-worktime"
                             v-html="office.worktime"></div>

                    </div>
                </div>
                <callback-input v-on="$listeners"
                                :map="true"
                                :data="{type: 'sale', form: 'contacts'}"
                                class="input-form">Получить предложение
                </callback-input>
            </div>
        </div>
        <div class="bottom-line"></div>
    </div>
</template>

<script>
    import CallbackInput from './callback-form/callback-input';
    import Mask from '../common/mask';
    import Mixin from '../common/mixin';
    import Keyup from '../common/keyup';

    export default {
        name: '',
        components: {CallbackInput},
        directives: {Mask, Keyup},
        mixins: [Mixin],
        props: [''],
        data() {
            return {
                offices: this.CONSTANTS.offices
            }
        },
        mounted() {
            // 5000 is optimal (c) Ernest, 2019
            setTimeout(this.waitYmaps, 5000);
        },
        computed: {},
        methods: {
            initYandexMap() {
                const isMobile = {
                    Android: function () {
                        return navigator.userAgent.match(/Android/i);
                    },
                    BlackBerry: function () {
                        return navigator.userAgent.match(/BlackBerry/i);
                    },
                    iOS: function () {
                        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                    },
                    Opera: function () {
                        return navigator.userAgent.match(/Opera Mini/i);
                    },
                    Windows: function () {
                        return navigator.userAgent.match(/IEMobile/i);
                    },
                    any: function () {
                        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                    }
                };
                let zoomControl = new ymaps.control.ZoomControl({
                    options: {
                        position: {
                            left: 'auto',
                            right: 10,
                            top: 108,
                        }
                    }
                });

                let center_x = this.CONSTANTS.center_coords.x, center_y = this.CONSTANTS.center_coords.y;

                if (this.device_platform === 'tablet') {
                    center_x = center_x;
                    center_y = center_y;
                } else if (this.device_platform === 'mobile') {
                    center_x = center_x + 0.004;
                    center_y = center_y;
                }

                let myMap = new ymaps.Map("ya-karto", {
                    center: [center_y, center_x],
                    zoom: 16,
                    controls: []
                }, {
                    searchControlProvider: 'yandex#search'
                });
                myMap.controls.add(zoomControl);

                this.offices.forEach(office => {
                    myMap.geoObjects
                        .add(new ymaps.Placemark([office.coords.y, office.coords.x], {
                            iconContent: office.short_address,
                        }, {
                            // iconLayout: "default#imageWithContent",
                            // iconImageHref: String(placemarkImg),
                            preset: "islands#blueStretchyIcon",
                            iconColor: '#1e98ff'
                        }));
                })
                ;
                if (isMobile.any() || this.device_platform !== 'desktop') {
                    myMap.behaviors.disable('drag');
                }
                myMap.behaviors.disable('scrollZoom');
            },
            waitYmaps() {
                let script = document.createElement('script');
                script.src = '//api-maps.yandex.ru/2.1/?load=package.standard&lang=ru_RU';
                document.head.appendChild(script);
                script.onload = () => {
                    ymaps.ready(this.initYandexMap);
                };
            }
        }
    }
</script>

<style scoped
       lang="scss">
    @import "../styles/constants";

    .desktop {
        .input-container {
            width: 390px;
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-120%);
        }
    }

    .mobile {
        &.block-contacts-container {
            padding-bottom: 290px;
        }

        .input-container {
            width: 300px;
            padding: 35px 10px;
            top: unset;
            bottom: -310px;
            left: 50%;
            transform: translateX(-50%);
        }

        .logo-container {
            flex-direction: column;
        }

        .logo-dealer, .logo {
            width: 100%;
            margin-bottom: 10px;
        }

        .input-form {
            width: 285px;
        }
    }

    .tablet {

    }

    .block-contacts-container {
        width: 100%;
        position: relative;
    }

    .header-text {
        font-size: 40px;
        font-weight: 300;
        text-align: center;
        margin: 80px auto 60px;
    }

    #ya-karto {
        position: absolute;
        bottom: 0;
        width: 100%;
        max-width: 1920px;
        height: 540px;
        left: 50%;
        transform: translateX(-50%);
    }

    .wrapper {
        width: 100%;
        max-width: 1920px;
        height: 540px;
        position: relative;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }

    .input-container {
        width: 390px;
        position: relative;
        top: 30px;
        left: 30px;
        background: #fff;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 0 5px #ccc;
    }

    .logo-container {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .logo {
        background: url('../images/logos/logo-lada.png') no-repeat center;
        background-size: contain;
        width: 45%;
        height: 39px;
    }

    .logo-dealer {
        background: url("../images/logos/logo-dealer.png") no-repeat center;
        background-size: contain;
        width: 45%;
        height: 39px;
        cursor: pointer;
    }

    .offices-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        margin: 20px;
    }

    .phone {
        color: $headers;
        font-size: 24px;
    }

    .office-address {
        font-size: 16px;
        margin: 5px 0;
    }

    .office-worktime {
        font-size: 12px;
    }

    .input-form {
        width: 300px;
    }

    .bottom-line {
        position: absolute;
        bottom: 0;
        width: 100%;
        max-width: 1920px;
        height: 146px;
        background: url("../images/lada-bottom-map.png") bottom no-repeat;
        background-size: contain;
        left: 50%;
        transform: translateX(-50%);
    }
</style>
