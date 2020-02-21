<template lang='pug'>
  .advantages
    h2.advantages__title.title Наши преимущества
      .container
        ul.advantages__list
          li.advantages__item(v-for='(item, index) in advantages' @click='getCall({ type: "sale", form: "advantages", text: `` + $options.filters.uppercase(item.text, item.text.uppercase) + `` })')
            img.advantages__item-img(:src='item.img')
            span.advantages__item-text {{ item.text }}
</template>

<script>
  import Mixin from '../common/mixin';
  import Advantages from '../common/advantages';

  export default {
    name: 'block-advantages',
    components: {},
    mixins: [Mixin],
    data() {
      return {
        advantages: Advantages.ITEMS
      }
    },
    methods: {
      getAgreement() {
        this.$emit('getAgreement');
      }
    },
    filters: {
      uppercase: (value) => {
        return value.toUpperCase();
      }
    }
  }
</script>

<style lang='sass'>
  .advantages
    margin: 40px auto 90px

    &__list
      margin: 26px 0 0
      padding: 0
      display: flex
      justify-content: space-between

    &__item
      width: 18%
      min-height: 160px
      display: flex
      flex-direction: column
      align-items: center
      list-style: none
      text-align: center
      border: 5px solid #F2F2F2
      white-space: pre-line
      cursor: pointer
      &:hover
        img
          opacity: .6

    &__item-img
      margin: 30px 0
      opacity: 1

    &__item-text
      font-size: 12px
      font-family: 'MMCOFFICE-Bold'
</style>