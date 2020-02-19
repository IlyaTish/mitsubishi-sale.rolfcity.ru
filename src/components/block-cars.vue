<template lang='pug'>
  section.block-cars.cars
    .container
      h2.cars__title.title Модельный ряд

      .cars-list
        .car(v-for='car in cars')
          .car__col.car__col--col-1
            a.popup(href='#')
              h3.car__name Mitsubishi <b>{{ car.name }}</b>
            a(href='#')
              .car__img-cont
                img(:src='car.imgUrl')

          .car__col.car__col--col-2
            a.popup(href='#' @click='getCall({ type: "sale", form: "car" })')
              span.car__price от <span class='large'>{{ car.price }}</span><span class='rub'></span>
            ul.car__dop-items
              li.car__dop-item(v-for='info_item in car.dopInfo') {{ info_item }}

          .car__col.car__col--col-3
            span.car__in-stock Осталось {{ car.stok }} авто по акции
            .car__advantage
              span.car__advantage-text Выгода до
              span.car__advantage-price {{ car.advantage }}
              p.car__rub-sym <span class='rub'></span> <sup>*</sup>
              a.car__btn.popup.btn(href='# ') узнайте свою цену
              p.car__p <b>Пользуется спросом!</b> За последние 2&nbsp;часа заказали звонок {{ car.amount }} раз
</template>

<script>
  import CarsInfo from '../common/cars-info';
  import CallbackInput from "./callback-form/callback-input";

  export default {
    name: 'block-cars',
    components: {CallbackInput},
    data() {
      return {
        cars: CarsInfo.CARS,
      }
    }
  }
</script>

<style lang='sass'>
  .cars
    &__title
      margin: 10px 0 0
      padding: 28px 0 38px

  .cars-list
    margin: 50px 0 0

  .car
    margin: 0 0 32px
    display: flex
    align-items: center
    justify-content: space-between
    position: relative
    background: url(../assets/images/car.ramka.png) 206px center no-repeat
    &__col
      &--col-1
        width: 38%
      &--col-2
        width: 30%
        border-right: 4px solid #f2f2f2
      &--col-3
        width: 28%

    &__name
      margin: 0
      font-size: 32px
      text-transform: uppercase
      top: -10px
      left: 0
      position: absolute

    &__price
      width: 100%
      margin: 0 0 18px
      display: inline-block
      color: #EB0000
      font-size: 18px
      font-family: 'MMCOFFICE-Bold'
      .large
        font-size: 28px

    &__dop-items
      margin: 0
      padding: 0

    &__dop-item
      display: block
      padding: 0 0 10px 30px
      position: relative
      font-size: 16px
      font-family: 'MMCOFFICE-Bold'
      &:before
        content: ''
        width: 20px
        height: 20px
        background: #EB0000
        border-radius: 100px
        display: block
        position: absolute
        left: 0px
      &:after
        content: ''
        width: 6px
        height: 6px
        border-top: 2px solid white
        border-right: 2px solid white
        display: block
        position: absolute
        left: 5px
        top: 6px
        transform: rotate(45deg)
        z-index: 2

    &__in-stock
      margin: 0 0 8px
      display: inline-block
      font-size: 19px
      font-family: 'MMCOFFICE-Bold'

    &__advantage-text
      margin: 0 0 8px
      display: block
      color: #979797
      font-family: 'MMCOFFICE-Bold'

    &__advantage-price
        color: #EB0000
        font-size: 65px
        font-family: 'MMCOFFICE-Bold'

    &__rub-sym
      display: inline
      color: #EB0000
      font-size: 25px
      font-family: 'MMCOFFICE-Bold'

    &__btn
      width: 100%
      margin: 10px 0 0

    &__p
      margin: 0
      color: #000000
      font-size: 16px
</style>