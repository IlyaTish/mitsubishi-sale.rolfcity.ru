<template lang='pug'>
  section.block-contacts.contacts(:class='device_platform')
    #ya-karto.ya-karto
    .contacts__cont
      .container
        .contacts__content
          h2.contacts__title.title Контакты
          a.logo-2(@click='getCall({ type: "sale", form: "header" })')
            img(src='@/images/dealer-logo-white.svg')
          .contacts__phone
            span {{ CONSTANTS.phone }}
          callback-input(
            v-on='$listeners'
            :map='true'
            :data='{type: "sale", form: "contacts"}'
          ) Получить предложение
</template>

<script>
  import CallbackInput from './callback-form/callback-input';
  import Mask from '../common/mask';
  import Mixin from '../common/mixin';
  import Keyup from '../common/keyup';

  export default {
    name: '',
    components: { CallbackInput },
    directives: { Mask, Keyup },
    mixins: [Mixin],
    props: [''],
    data() {
      return {
        info: this.CONSTANTS,
        offices: this.CONSTANTS.offices
      };
    },
    mounted() {
      // 5000 is optimal (c) Ernest, 2019
      setTimeout(this.waitYmaps, 5000);
    },
    computed: {},
    methods: {
      initYandexMap() {
        const isMobile = {
          Android: function() {
            return navigator.userAgent.match(/Android/i);
          },
          BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
          },
          iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
          },
          Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
          },
          Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
          },
          any: function() {
            return (
              isMobile.Android() ||
              isMobile.BlackBerry() ||
              isMobile.iOS() ||
              isMobile.Opera() ||
              isMobile.Windows()
            );
          }
        };
        let zoomControl = new ymaps.control.ZoomControl({
          options: {
            position: {
              left: 'auto',
              right: 10,
              top: 108
            }
          }
        });

        let center_x = this.CONSTANTS.center_coords.x,
            center_y = this.CONSTANTS.center_coords.y;

        if (this.device_platform === 'tablet') {
          center_x = center_x;
          center_y = center_y;
        } else if (this.device_platform === 'mobile') {
          center_x = center_x + 0.004;
          center_y = center_y;
        }

        let myMap = new ymaps.Map(
          'ya-karto',
          {
            center: [center_y, center_x],
            zoom: 9,
            controls: []
          },
          {
            searchControlProvider: 'yandex#search'
          }
        );
        myMap.controls.add(zoomControl);

        this.offices.forEach(office => {
          myMap.geoObjects.add(
            new ymaps.Placemark(
              [office.coords.y, office.coords.x],
              {
                balloonContent: office.address,
                hintContent: office.name
              },
              {
                iconLayout: 'default#image',
                iconImageHref: 'map-balloon.png',
                iconImageSize: [31, 43],
                iconImageOffset: [-26, -43]
              }
            )
          );
        });
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
  };
</script>

<style scoped lang='sass'>
  @import '../styles/constants';

  .contacts
    &__cont
      margin: -448px 0 60px
      background: #EB0000
      pointer-events: none

    &__content
      width: 100%
      max-width: 540px
      padding: 0 100px 50px 100px
      background: #EB0000
      pointer-events: all
      position: relative
      z-index: 2

    &__title
      margin: 0 0 14px
      padding: 28px 0 0
      color: #FFFFFF
      text-align: left

    &__phone
      padding: 16px 20px
      margin: 0 0 10px
      color: #FFFFFF
      font-size: 20px
      font-family: 'MMCOFFICE-Bold'

    .container
      display: flex
      justify-content: flex-end

    .ya-karto
      width: 1318px
      height: 450px
      max-width: 100%
      margin: 0 0 40px
      position: relative
      order: 1
      z-index: 1

    .logo-2
      display: inline-block
</style>