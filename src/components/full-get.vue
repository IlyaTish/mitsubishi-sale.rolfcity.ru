<template lang='pug'>
  .popup(:class='[device_platform]')
    .popup-bg(@click='hideSelf')
    .popup__cont
      .closer(@click='hideSelf') ×
      .popup__text
        span.popup__title(v-if='data.text') {{ data.text }}
        span.popup__title(v-else) Заказать звонок
      callback-input(v-on='$listeners' :data='data')
</template>

<script>
  import Mask from '../common/mask';
  import Keyup from '../common/keyup';
  import CallbackInput from './callback-form/callback-input';
  import Mixin from '../common/mixin';

  export default {
    name: 'full-get',
    components: { CallbackInput },
    mixins: [Mixin],
    directives: { Mask, Keyup },
    props: ['data'],
    data() {
      return {
        offices: this.CONSTANTS.offices
      };
    },
    methods: {
      hideSelf() {
        this.$emit('close');
      },
      getAgreement() {
        this.$emit('getAgreement');
      }
    }
  };
</script>

<style scoped lang="sass">
  @import '../styles/constants.scss';

  .popup
    width: 100%
    height: 100%
    min-height: 100%
    display: flex
    align-items: center
    justify-content: center
    top: 0
    left: 0
    position: fixed
    z-index: 21

    &__cont
      max-width: 600px
      padding: 44px
      display: flex
      flex-direction: column
      align-items: center
      position: relative
      background: #FFFFFF
      z-index: 21

    &__text
      text-align: center

    &__title
      width: 100%
      display: inline-block
      padding: 0 0 16px
      color: #000000
      font-size: 24px
      font-family: 'MMCOFFICE-Bold'
      text-transform: none

  .mobile
    .input-container
      padding: 30px 5px
      width: 310px

  .popup-bg
    width: 100%
    height: 100%
    top: 0
    left: 0
    position: fixed
    background: #000000
    opacity: 0.75 
    z-index: 20

  .closer
    position: absolute
    top: 0
    right: 0
    width: 40px
    height: 40px
    cursor: pointer
    font-size: 30px
    display: flex
    justify-content: center
    align-items: center

  .offices-container 
    display: flex
    flex-direction: column
    align-items:center
</style>
