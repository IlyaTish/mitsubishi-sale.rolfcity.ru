<template lang='pug'>
  section.block-offer.offer(:class='device_platform')
    .container
      h2.offer__title Кредит
      p.offer__p Выгодные кредитные условия банков- <br>партнёров с максимальным комфортом <br>помогут вам стать владельуем Mitsubishi
      .offer__info
        span.offer__info-sup 5,9% <sup>*****</sup>
        span.offer__info-text процентная <br>ставка
      .offer__btn.btn(@click='getCall({ type: "credit", form: "offer", text: "РАССЧИТАТЬ КРЕДИТ" })') Рассчитать кредит
</template>

<script>
  import Mixin from '../common/mixin';
  import CallbackInput from './callback-form/callback-input';

  export default {
    name: 'block-offer',
    components: { CallbackInput },
    mixins: [Mixin],
    methods: {
      getAgreement() {
        this.$emit('getAgreement');
      }
    }
  };
</script>

<style scoped lang='sass'>
  .offer
    min-height: 450px
    margin: 0 0 50px
    display: flex
    flex-direction: column
    justify-content: center
    background: url(../images/block-offer-bg.jpg) center center no-repeat

    &__title
      color: #FFFFFF
      font-size: 24px
      font-family: 'MMCOFFICE-Bold'
      text-transform: uppercase

    &__p
      margin: 0 0 10px
      padding: 16px 20px
      color: #FFFFFF

    &__info
      color: #E29B98
      font-size: 10px
      font-family: 'MMCOFFICE-Bold'
      text-transform: uppercase

    &__info-sup
      margin: 0 0 5px
      display: block
      color: #FFFFFF
      font-size: 36px

    &__btn
      margin: 34px 0 0 94px
      max-width: 290px
      color: #EB0000
      background: #FFFFFF
      &:hover
        color: #FFFFFF
        background: transparent
        border: 3px solid #FFFFFF

  .offer.tablet
    background-size: 1000px
    background-position: left center

    .offer__title
      color: #000000

    .offer__p
      margin: 30px 0 10px

    .offer__btn
      margin: 34px 0 0 0
      border: 1px solid #BB162A

  .offer.mobile
    padding: 184px 0 0
    background-size: 700px
    background-position: -320px top

    .offer__title
      color: #000000

    .offer__p
      padding: 16px 0
      color: #000000
      br
        display: none

    .offer__info-sup
      color: #000000
      font-size: 20px

    .offer__info-text
      color: #BB162A

    .offer__btn
      max-width: 100%
      margin: 34px 0 0
      border: 1px solid #BB162A
</style>