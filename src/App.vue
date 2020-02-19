<template lang='pug'>
    #app
      block-header#header
      block-main
      block-cars
</template>

<script>
import BlockHeader from './components/block-header';
import BlockMain from './components/block-main';
import BlockCars from './components/block-cars';

export default {
  name: 'App',
  data: function () {
    return {
      show: {
        agreement: false,
        load: false,
        get: false,
        thanks: false
      },
      cur_office: 1,
      data: {},
    };
  },
  components: {
    BlockHeader,
    BlockMain,
    BlockCars
  },
  computed: {
    block_handles() {
      return {
        'callBack': this.callThere,
        'getCall': this.handleGetCall
      }
    }
  },
  methods: {
    handleGetCall(data) {
      this.show.get = true;
      this.data = data;
    }
  }
}
</script>

<style lang='sass'>
  #app
    display: flex
    flex-direction: column
    align-items: center
</style>
