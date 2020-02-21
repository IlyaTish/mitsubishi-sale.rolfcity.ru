<template lang='pug'>
  .info
    .container
      .info__cont
        h2.info__title Воспользуйся <br>программой <br>трейд-ин Mitsubishi
        p.info__p Узнайте больше о предложение трейд-ин <br> программы в нашем дилерском центре <br>по телефону <a v-for='office in offices' :href='"tel:" + office.phone_raw'> {{ office.phone }}</a> <br>или закажите звонок
        button.info__btn.btn Узнать подробнее
</template>

<script>
  import Mixin from '../common/mixin';
  import filters from '../common/finance';
  import CallbackInput from './callback-form/callback-input';

  export default {
    name: 'block-info',
    components: { CallbackInput },
    mixins: [Mixin, filters],
    data() {
      let offices = this.CONSTANTS.offices;
      return {
        offices: offices
      };
    },
    methods: {
      getAgreement() {
        this.$emit('getAgreement');
      }
    }
  };
</script>

<style scoped lang='sass'>
  .info
    min-height: 450px
    margin: 0 0 40px
    display: flex
    flex-direction: column
    justify-content: center
    background: url(../images/block-info-bg.jpg) center center no-repeat

    .container
      display: flex
      justify-content: flex-end

    &__cont
      width: auto

    &__title
      color: #FFFFFF
      font-size: 24px
      font-family: 'MMCOFFICE-Bold'
      text-transform: uppercase

    &__p
      margin: 0 0 20px
      padding: 16px 20px
      color: #FFFFFF
      font-family: 'MMCOFFICE-Bold'
      a
        color: #FFFFFF

    &__btn
      width: 100%
      max-width: 298px
      color: #EB0000
      background: #FFFFFF
      border: 1px solid #FFFFFF
</style>