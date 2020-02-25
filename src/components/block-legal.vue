<template lang='pug'>
  section.block-legal.legal(:class='[device_platform]')
    .container
      .expander
        span.expander-button(@click='expanded = !expanded') Полные условия акции
        transition(name='slide')
          .legal__text-cont(v-show='expanded')
            p.legal__p 
              | До 1 050 000 руб. на Mitsubishi Pajero Sport, до 650 000 руб. на Mitsubishi Outlander,до 550 000 руб. на Mitsubishi Pajero, до 450 000 руб. на Mitsubishi L200, до 310 000 руб. на Mitsubishi ASX и до 700 000 руб. на Mitsubishi Eclipse Cross действует на автомобили в наличии, которая складывается из прямой скидки на автомобиль, скидки по программе трейд-ин / утилизация и выгоды на дополнительное оборудование.
              <br><br>
              | Кредитор - ПАО "Совкомбанк". Аванс – 0% от стоимости автомобиля. Валюта – рубли. Ставка от 14,99% годовых. При условии «Защита платежей». КАСКО приобретается за наличный расчет. Срок кредитования 60 мес. Предложение не является офертой и действует до 31.01.2020 года на новые автомобили Mitsubishi 2018/2019 года выпуска. Количество автомобилей ограничено. Подробности в ООО «РОЛЬФ» филиал «Сити».
              <br><br>
              | РОЛЬФ Сити - г.Москва, Ярославское шоссе, 31, работаем с 8:00 до 22:00 <a :href='"tel:" + CONSTANTS.phone'>{{ CONSTANTS.phone }}</a>
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
    padding: 60px 0 0

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
</style>
