<template lang='pug'>
  form.callback-form.CKiForm(
    @submit.prevent='submitThis' 
    :class='[device_platform, { horizontal: horizontal }, form_class]'
  )
    template(v-if='map')
      .input-block
        input.callback-form__input.callback-form__input--empty(
          name='”tel”'
          type='tel'
          placeholder='Ваш телефон'
          :title='"Введите номер телефона"'
          v-model='phone'
          ref='phone'
          v-mask
          :pattern='".*[0-9]{1}.*[0-9]{3}.*[0-9]{3}.*[0-9]{4}"'
          required
        )
        button.callback-form__btn.btn.btn--white.CKFormTrigger(
          type='submit'
          :disabled='!acceptance'
          :class='[{ disabled: !acceptance }]'
          ref='submitter'
        ) Заказать звонок

    template(v-else)
      .input-block
        input.callback-form__input(
          name='”tel”'
          type='tel'
          placeholder='Ваш телефон'
          :title='"Введите номер телефона"'
          v-model='phone'
          ref='phone'
          v-mask
          :pattern='".*[0-9]{1}.*[0-9]{3}.*[0-9]{3}.*[0-9]{4}"'
          required
        )
        button.callback-form__btn.btn.CKFormTrigger(
          type='submit'
          :disabled='!acceptance'
          :class='[{ disabled: !acceptance }]'
          ref='submitter'
        ) Отправить

        .agreement(v-if='CONSTANTS.need_agreement')
          .agreement-confirm
            span(@click='getAgreement') Я согласен с условиями обработки персональных данных
</template>

<script>
  import Mixin from "@/common/mixin";
  import Mask from "@/common/mask";
  import Checkbox from "../checkbox";

  export default {
    name: "callback-input",
    components: { Checkbox },
    directives: { Mask },
    mixins: [Mixin],
    props: ["horizontal", "data", "form_class", "map"],
    data() {
      return {
        acceptance: true,
        phone: ""
      };
    },
    computed: {},
    methods: {
      submitThis(event) {
        if (
          this.$refs.phone.validity.valueMissing ||
          !this.$refs.phone.validity.valid
        ) {
          this.$refs.phone.setCustomValidity("Введите номер телефона");
        }
        if (
          !this.$refs.phone.validity.valueMissing &&
          !this.$refs.phone.validity.patternMismatch
        ) {
          this.$refs.phone.setCustomValidity("");
        }
        if (this.acceptance && this.$el.reportValidity()) {
          if (typeof ckForms !== "undefined") {
            ckForms.send(this.$el);
          }

          this.$emit("callBack", {
            phone: this.phone,
            data: this.data
          });
        }
      },
      getAgreement() {
        this.$emit("getAgreement");
      }
    }
  };
</script>

<style lang='sass'>
  @import '../../styles/constants.scss'

  .callback-form
    width: 100%

    &__input
      width: 100%
      height: 42px
      margin: 0 0 10px
      padding: 0 40px
      font-size: 14px
      font-family: 'MMCOFFICE-Bold'
      text-align: center
      background: #F4F4F4
      border: none
      outline: none
      &::placeholder
        font-size: 14px
        text-align: center
        color: lighten(#000000, 40%)
      &--empty
        height: 46px
        color: #FFFFFF
        font-size: 20px
        background: transparent
        border: 1px solid #FFFFFF
        &::placeholder
          color: #FFFFFF
          font-size: 20px
          text-align: center

    &__btn
      width: 100%
      font-size: 14px
      font-family: 'MMCOFFICE-Medium'

  .input-block
    margin: 0 0 26px
    display: flex
    flex-direction: column
    align-items: center
    justify-content: flex-start

  .contacts
    .input-block
      margin: 0

  .agreement
    display: flex
    justify-content: center
    position: relative

  .agreement-confirm
    width: auto
    display: inline
    color: #B8B8B8
    font-size: 10px
    font-weight: 500
    font-family: 'MMCOFFICE-Regular'
    text-align: left
    text-decoration: none

  .disabled
    background: #959595
    cursor: default

  .horizontal
    .input-block
      flex-direction: row

    input
      margin-bottom: 0
      margin-right: 10px

    .orange-btn
      margin-bottom: 0

    .agreement
      margin-top: 10px
</style>
