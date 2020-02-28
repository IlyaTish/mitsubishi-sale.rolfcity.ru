<template lang='pug'>
  .stock-table
    .stock-table__row(v-for='(item, idx) in cars')
      .stock-table__column(v-for='col in columns')
        template(v-if='col.alias === "model"')
          span.stock-table__text MITSUBISHI <span :class='[col.alias]'><b>{{ item[col.alias] || '' }}</b></span>
        template(v-else)
          span.stock-table__text(:class='[col.alias]') {{ item[col.alias] || '' }}

      .stock-table__column
        button.btn(@click='getCall({ type: "sale", form: "stock" })') Узнать цену

    .more-button(@click='addCount' v-if='data.length > 6 && count < data.length') Показать еще
      .more-sign
</template>

<script>
import finance from '../common/finance';
import Mixin from '../common/mixin';

const INITIAL_COUNT = 6;

export default {
  name: 'stock-table',
  props: ['data'],
  mixins: [Mixin, finance],
  data() {
    return {
      count: INITIAL_COUNT
    };
  },
  watch: {
    data() {
      this.count = INITIAL_COUNT;
    }
  },
  computed: {
    cars() {
      return this.data.slice(0, this.count);
    },
    columns() {
      return [
        {
          alias: 'model'
        },
        {
          alias: 'comp'
        },
        {
          alias: 'engine'
        }
      ];
    }
  },
  methods: {
    addCount() {
      this.count += 10;
    }
  }
};
</script>

<style lang="sass">
.stock-table
  width: 100%

  &__row
    height: 115px
    display: flex
    justify-content: flex-start
    align-items: center
    transition: .2s
    &:hover
      background-color: #F2F2F2

  &__column
    width: 100%
    padding: 27px 18px

  &__text
    font-size: 25px

  .model, .comp
    white-space: nowrap

  .engine
    color: #EB0000
    font-size: 20px

  .btn
    min-width: 320px

.more-button
  margin: 20px 0 0
  padding: 20px 30px
  color: #515151
  font-size: 14px
  font-family: 'MMCOFFICE-Bold'
  text-align: center
  text-decoration: underline
  cursor: pointer
  transition: .2s
  &:hover
    text-decoration: none

  .more-sign
    transform: rotate(0deg)

.tablet
  .stock-table__row
    justify-content: space-between

  .stock-table__column
    width: auto

  .stock-table__text
    font-size: 18px

  .btn
    min-width: 190px

.mobile
  .stock-table__row
    height: auto
    flex-direction: column
    padding: 10px

  .stock-table__column
    margin: 5px 0
    padding: 0

  .btn
    width: 100%
    min-width: auto
</style>