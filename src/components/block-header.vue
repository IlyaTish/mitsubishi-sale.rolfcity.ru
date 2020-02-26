<template lang='pug'>
  header.header(:class='device_platform')
    .header__row-1
      .container
        a.logo-1(@click='getCall({ type: "sale", form: "header" })')
          img(src='@/images/logo1.png')
        a.logo-2(@click='getCall({ type: "sale", form: "header" })')
          img(src='@/images/dealer-logo.svg')
        a.phone(:href='"tel:" + CONSTANTS.phone') {{ CONSTANTS.phone }}
        a.header__btn.btn(@click='getCall({ type: "sale", form: "header" })') Заказать звонок
        div.mobile-button(:class='{ active: isActive }' @click='setActive()')
          span
          span
          span
    .header__row-2
      .container
        .header__menu(:class='{ active: isActive }')
          a(@click='scrollTo("cars")') МОДЕЛЬНЫЙ РЯД
          a() выбрать комплектацию
          a(@click='scrollTo("offer")') кредитные предложения
          a(@click='scrollTo("advantages")') преимущества
          a(@click='scrollTo("contacts")') контакты
</template>

<script>
  import Mixin from '../common/mixin';

  export default {
    name: 'block-header',
    components: {},
    directives: {},
    mixins: [Mixin],
    data() {
      let offices = this.CONSTANTS.offices;
      return {
        offices: offices,
        isActive: false
      };
    },
    methods: {
      scrollTo(where) {
        let newhash = '#' + where;
        history.replaceState(null, null, newhash);
        this.$emit('scrollTo', where);
      },
      getCall(data) {
        this.$emit('getCall', data);
      },
      setActive() {
        this.isActive = !this.isActive;
      }
    }
  };
</script>

<style lang='sass'>
  .header
    &__row-1
      padding: 24px 0px
      background: white

      .container
        display: flex
        align-items: center
        justify-content: space-between

      .phone
        color: #EB0000
        font-size: 18px
        font-family: 'MMCOFFICE-Bold'
        background: url(data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAWBAMAAAAP/cBTAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAMFBMVEX////bDibbDibbDibbDibbDibbDibbDibbDibbDibbDibbDibbDibbDibbDib///8mPtiEAAAADnRSTlMAVZkRRHciu+7dzDOqiErnqhgAAAABYktHRACIBR1IAAAAB3RJTUUH4wcQFjIpCVRb3AAAAFVJREFUCNdVjbsJgEAAQ6MixxWKuIJ7OIsTOJa1K/lBROTN4OU6m9ckeZF6BlWwqYBTNVwq4VDg7hRZpJY14ZE0v8b+h4ORyb1Ujp4FCxqrsjTrffQBD18qU2tioIMAAAAASUVORK5CYII=) left center no-repeat
        padding-left: 17px
        &:before, &:after
          content: ''

    &__btn
      min-width: 213px
      height: 35px

    &__row-2
      background: #EB0000

    &__menu
      display: flex
      align-items: center
      a
        color: white
        padding: 12px 20px
        font-family: 'MMCOFFICE-Bold'
        display: block
        text-transform: uppercase
        transition: .3s
        &:hover
          background-color: #861020

    .mobile-button
      display: none
      span
        width: 33px
        height: 4px
        display: block
        margin: 0 0 5px
        position: relative
        background: #BB162A
        z-index: 3
        transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0), background 0.5s cubic-bezier(0.77,0.2,0.05,1.0), opacity 0.55s ease, -webkit-transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0)

  .header.tablet, .header.mobile
    .header__row-1
      padding: 8px 0

    .header__btn
      min-width: 170px

    .header__menu
      flex-wrap: wrap
      justify-content: center

  .header.mobile
    .header__row-1
      padding: 5px 0

      .phone
        display: none

      .logo-1, .logo-2
        margin: 0 0 10px

      .container
        flex-wrap: wrap

      .mobile-button
        width: auto
        display: inline-block
        top: 40px
        right: 22px
        user-select: none
        z-index: 3
        span
          transform-origin: 4px 0px

      .mobile-button.active
        span
          opacity: 1
          transform: rotate(45deg) translate(-7px, -21px)
          &:nth-last-child(3)
            opacity: 0
            transform: rotate(0deg) scale(0.2, 0.2)
          &:nth-last-child(2)
            transform: rotate(-45deg) translate(0, 10px)

    .header__row-2
      background: transparent
      .container
        width: 540px
        max-width: 100%

    .header__menu
      width: 100%
      padding: 20px 0
      display: none
      flex-direction: column
      background: #F2F2F2
      position: absolute
      z-index: 2
      transition: all 0.5s
      a
        width: 100%
        display: inline-block
        padding: 12px 20px 12px 15px
        color: #000000
        font-size: 18px
        line-height: 30px
        text-align: right

    .header__menu.active
      display: block
      top: 0
      right: 0
      position: absolute
</style>