<template lang='pug'>
  .block-header
    .block-header__row-1
      .container
        a.logo-1.popup(href='#form_popup' _title='Заказать звонок' title='Mitsubishi' alt='Mitsubishi')
          img(src='@/assets/images/logo1.png')
        a.logo-2.popup(href='#form_popup' _title='Заказать звонок')
          img(src='@/assets/images/dealer-logo.svg')
        a.phone(href='tel:+74957851994') {{ CONSTANTS.phone }}
        a.block-header__btn.btn.popup(href='#form_popup' _comment='' _name='vizov' _title='Заказать звонок') Заказать звонок
    .block-header__row-2
      .container
        .block-header__menu
          a(href='#present' class='submenu') МОДЕЛЬНЫЙ РЯД
          a(href='#filter_table' class='anchor') выбрать комплектацию
          a(href='#kred' class='anchor') кредитные предложения
          a(href='#preim' class='anchor') преимущества
          a(href='#contacts' class='anchor') контакты
</template>

<script>
  export default {
    name: 'block-header',
    data() {
    },
  }
</script>

<style lang='sass'>
  .block-header__row-1
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
      background: url(data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAWBAMAAAAP/cBTAAAABGdBTUE…wq4VDg7hRZpJY14ZE0v8b+h4ORyb1Ujp4FCxqrsjTrffQBD18qU2tioIMAAAAASUVORK5CYII=) left center no-repeat
      padding-left: 17px
      &:before, &:after
        content: ''

  .block-header__btn
    min-width: 213px
    height: 35px

  .block-header__row-2
    background: #EB0000

  .block-header__menu
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
</style>