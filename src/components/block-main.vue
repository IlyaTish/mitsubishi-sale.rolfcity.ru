<template lang='pug'>
  section.block-main.main(:class='device_platform')
    .main__cont
      .main-offer
        .container
          .main__title-cont
            h1.main__title <span class='red'>Масштабная реализация склада</span> MITSUBISHI в РОЛЬФ!
            h2.main__subtitle.title только 3 дня. Выгода до 1 050 000 ₽. Эксклюзивное предложение.
      .submenu
        .container
          ul.submenu__list
            li.submenu__item
              a.submenu__link.btn.zvon(@click='getCall({ type: "sale", form: "main" })') Заказать звонок
            li.submenu__item
              a.submenu__link.btn.gray-bg.obmen(@click='getCall({ type: "sale", form: "main", text: `Обмен моего авто на MITSUBISHI` })') Обмен моего авто на MITSUBISHI
            li.submenu__item
              a.submenu__link.btn.gray-bg.vig_kred(@click='getCall({ type: "sale", form: "main", text: `Выгодный кредит на MITSUBISHI` })') Выгодный кредит на MITSUBISHI
            li.submenu__item
              a.submenu__link.btn.gray-bg.td(@click='getCall({ type: "sale", form: "main", text: `Записаться на тест-драйв` })') Записаться на тест-драйв
</template>

<script>
  import Mixin from '../common/mixin';
  import finance from '../common/finance';
  import CallbackInput from './callback-form/callback-input';
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
      text-shadow: 0px 4px 4px #000000

    &__subtitle
      color: #FFFFFF
      text-shadow: 0px 4px 4px #000000

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

  .main.tablet
    .main__title-cont
      padding: 25px 30px

    .main__title
      font-size: 38px

    .submenu
      .container
        width: 100%
        margin: 0
        padding: 0

    .submenu__list
      flex-wrap: wrap
      justify-content: center

    .submenu__item
      width: 50%

    .submenu__link
      width: 100%
      border: 0px

  .main.mobile
    margin: 38% 0 0

    .main-offer
      height: auto

    .main__title-cont
      padding: 20px

    .main__title
      color: #000000
      font-size: 20px
      text-shadow: none

    .main__subtitle
      display: none

    .submenu
      background: none

    .submenu__list
      flex-wrap: wrap

    .submenu__item
      width: 100%

    .submenu__link
      width: 100%
      display: inline-flex
      align-items: center
      border: 1px solid #FFFFFF
      border-bottom: 0px
</style>