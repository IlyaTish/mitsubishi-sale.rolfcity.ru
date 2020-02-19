<template lang='pug'>
  form.callback-form(@submit.prevent='submitThis' :class='[device_platform, {"horizontal": horizontal}, form_class]')
    .input-block
      input(
        name='tel'
        type='tel'
        placeholder='Ваш телефон'
        :title='"Введите номер телефона"'
        v-model='phone'
        ref='phone'
        v-mask
        :pattern='".*[0-9]{1}.*[0-9]{3}.*[0-9]{3}.*[0-9]{4}"'
        required
      )
      button(
        type='submit'
        :disabled='!acceptance'
        class='btn'
        :class="[{disabled: !acceptance}]"
        ref="submitter"
      )
        slot
        .btn-arrow
</template>

<script>
  export default {
    name: 'callback-input',
    props: ['horizontal', 'data', 'form_class', 'map'],
    data() {
      return {
        acceptance: true,
        phone: ''
      }
    },
    methods: {
      submitThis() {
        if (this.$refs.phone.validity.valueMissing || !this.$refs.phone.validity.valid) {
          this.$refs.phone.setCustomValidity('Введите номер телефона');
        }
        if (!this.$refs.phone.validity.valueMissing && !this.$refs.phone.validity.patternMismatch) {
          this.$refs.phone.setCustomValidity('');
        }
        if (this.acceptance && this.$el.reportValidity()) {
          if (typeof ckForms !== 'undefined') {
            // ckForms.send(this.$el);
          }

          this.$emit('callBack', {
            phone: this.phone,
            data: this.data,
          });
        }
      }
    }
  }
</script>