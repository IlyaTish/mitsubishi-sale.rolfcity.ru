<template>
    <div id='app'>
      <block-header id='header' v-on='block_handlers'></block-header>
    </div>
</template>

<script>
import './styles/main.sass';
import BlockHeader from './components/block-header';

export default {
  name: 'App',
  components: {
    BlockHeader
  },
}
</script>

<style lang='sass' scoped>
  #app
    display: flex
    flex-direction: column
    align-items: center
</style>
