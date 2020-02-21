<template>
  <div class="block-legal-container" :class="[device_platform]">
    <div class="expander">
      <div class="expander-button" @click="expanded = !expanded">
        Подробные условия акции:
      </div>
    </div>
    <transition name="slide">
      <div class="text-container" v-show="expanded">
        <div class="legal-text-block">
          *Выгода не является постоянной и может меняться в зависимости от условий приобретения автомобиля и
          комплектации автомобиля. Не является публичной офертой.
          <br><br>
          **Стоимость действительна при условии согласия клиента участвовать во всех маркетинговых кампаниях. Количество
          автомобилей ограничено. Не является публичной офертой.
          <br><br>
          ***Рекламируемая ставка 3,6% не является процентной ставкой по кредиту, а отражает размер расходов покупателя
          с использованием кредита на приобретение нового автомобиля LADA Granta 2019 года выпуска по рекомендованной
          розничной цене 400 900 с учетом выгод: 20 000 руб по программе «Трейд-ин», 20 000 руб. по программе «ЛАДА
          Финанс», 15 000 руб. на автомобили 2019 года выпуска. Кредитор – Банк ВТБ (ПАО). Кредитование осуществляется в
          рамках программы «АвтоРалли»: первоначальный взнос – 20% от цены автомобиля, срок кредита – 36 мес., валюта –
          рубли, кредитная ставка – 14,5% годовых без оформлении полиса добровольного страхования жизни и здоровья
          Клиента, сумма кредита – 309 720,00 руб. Расчет приведен для LADA Granta седан с рекомендованной розничной
          ценой 455 900 руб., по состоянию на 23.12.2019. Оформление полиса КАСКО обязательно. Страхование
          осуществляется в соответствии с тарифами выбранной Клиентом страховой компании, соответствующей требованиям
          Кредитора. Обеспечение по кредиту – залог автомобиля. Срок действия предложения с 01.01.2020 по 31.01.2020.
          Предложение ограничено. Подробности по тел. +7 495 933 40 33. Не является офертой
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
  import Mixin from '../common/mixin';

  export default {
    name: "block-legal",
    mixins: [Mixin],
    data() {
      return {
        expanded: false
      }
    }
  }
</script>

<style scoped lang="scss">
  @import "../styles/constants.scss";

  .desktop {
    &.block-legal-container {
      padding: 20px 0 0;
    }
  }

  .mobile {
    &.block-legal-container {
      padding: 20px 10px 0;
    }
  }

  .tablet {
    &.block-legal-container {
      padding: 20px 0 0;
    }
  }

  .expander {
    padding-bottom: 20px;
    position: relative;
  }


  .expander-button {
    font-size: 16px;
    text-decoration: underline;
    cursor: pointer;
    color: #fff;
    text-align: center;
    max-width: 300px;
    margin: auto;
  }

  .block-legal-container {
    width: 100%;
    background: #485865;
    font-size: 14px;
    font-weight: 400;
    font-family: "LADA Pragmatica", sans-serif;
  }

  .legal-text-block {
    max-width: 1300px;
    margin-bottom: 15px;
    color: #fff;
    margin-left: auto;
    margin-right: auto;
  }

  .text-container {
    background: #485865;
    margin-bottom: 50px;
  }

  .slide-enter-active {
    transition: all .3s ease;
  }

  .slide-leave-active {
    transition: all .3s;
  }

  .slide-enter, .slide-leave-to {
    transform: translateY(10px);
    opacity: 0;
  }

</style>
