<template lang='pug'>
  section.block-main.main(:class='device_platform')
    .main__cont
      .main-offer
        .container
          .main__title-cont
            h1.main__title Закрытая ночь продаж <span class='red'>mitsubishi</span> в рольф
            h2.main__subtitle.title Специальные цены.Предложение ограничено.
      .submenu
        .container
          ul.submenu__list
            li.submenu__item
              a.submenu__link.btn.zvon Заказать звонок
            li.submenu__item
              a.submenu__link.btn.gray-bg.obmen Обмен моего авто на MITSUBISHI
            li.submenu__item
              a.submenu__link.btn.gray-bg.vig_kred Выгодный кредит на MITSUBISHI
            li.submenu__item
              a.submenu__link.btn.gray-bg.td Записаться на тест-драйв
</template>

<script>
  import Mixin from '../common/mixin';
  import finance from '../common/finance';
  import CallbackInput from './callback-form/callback-input';
  import Swiper from 'swiper';
  import $ from 'jquery';
  import Inputmask from 'inputmask';

  export default {
    name: 'block-main',
    components: { CallbackInput },
    mixins: [Mixin, finance],
    mounted() {
      window.addEventListener('click', event => {
        if (!event.target || !event.target.id) {
          return;
        }
        if (event.target.id === 'btn-common-1') {
          this.getCall({ type: 'sale', form: 'main' });
        }
      });
    },
    watch: {
      device_platform() {
        if (this.swiper) {
          this.swiper.destroy();
          this.swiper = null;
          this.$nextTick(this.initSwiper);
        }
      }
    },
    methods: {
      getAgreement() {
        this.$emit('getAgreement');
      }
    }
  };
</script>

<style lang='sass'>
  .main
    &__cont
      margin: 20px 0 0

    &__title-cont
      margin: 0 auto
      padding: 25px 90px
      display: inline-block
      text-align: center

    &__title
      margin: 0
      color: #FFFFFF
      font-size: 40px
      font-family: 'MMCOFFICE-Bold'
      text-transform: uppercase

    &__subtitle
      color: #FFFFFF

  .main-offer
    height: 628px

  .submenu
    width: 100%
    background: #979797

    &__list
      margin: 0
      padding: 0
      display: flex

    &__item
      list-style: none
      &:first-of-type
        a
          border-left: 1px solid #FFFFFF
          border-right: 1px solid #FFFFFF

    &__link
      min-height: 46px
      border-right: 1px solid #FFFFFF
</style>