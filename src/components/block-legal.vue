<template lang='pug'>
  section.block-legal.legal(:class='[device_platform]')
    .container
      .expander
        a.expander-button(href='https://www.rolfcity.ru/agreement' target='_blank') Полные условия акции
</template>

<script>
  import Mixin from '../common/mixin';

  export default {
    name: 'block-legal',
    mixins: [Mixin],
    data() {
      return {
        expanded: false
      }
    }
  }
</script>

<style lang='sass'>
  .legal
    padding: 60px 0 40px

    &__text-cont
      margin: 10px 0 0

    &__p
      color: #7B7B7B
      font-size: 10px

  .expander-button
    width: 100%
    display: inline-block
    color: #000000
    font-size: 12px
    line-height: 100%
    text-align: center
    text-decoration: underline
    cursor: pointer

  .slide-enter-active
    transition: all .3s ease

  .slide-leave-active
    transition: all .3s

  .slide-enter, .slide-leave-to
    transform: translateY(10px)
    opacity: 0

  .legal.mobile
    padding: 0 0 40px
</style>
