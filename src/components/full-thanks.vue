<template>
  <div>
    <div class="blacking" @click="hideSelf"></div>
    <div class="callback-request">
      <div class="close" @click="hideSelf">X</div>
      <div class="callback-close">
        Спасибо за заявку!
        <br />
        Мы свяжемся с Вами
        <br />
        в ближайшее время!
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "",
  components: {},
  directives: {},
  mixins: [],
  props: [""],
  data() {
    return {};
  },
  computed: {},
  methods: {
    hideSelf() {
      this.$emit("close");
    }
  }
};
</script>

<style scoped lang="scss">
.blacking {
  position: fixed;
  z-index: 500;
  top: -100vh;
  left: -100vw;
  bottom: -100vw;
  right: -100vh;
  background: #000;
  opacity: 0.5;
  cursor: default;
}

.callback-request {
  position: fixed;
  z-index: 1200;
  top: calc(50% - 160px);
  left: calc(50% - 140px);
  height: 160px;
  width: 280px;
  background: #fff;
  color: #000;
  padding: 40px 20px;
  cursor: default;
  text-align: center;
  & > .close {
    position: absolute;
    font-size: 20px;
    top: 10px;
    right: 15px;
    cursor: pointer;
  }
  & > .callback-close {
    font-size: 20px;
  }
  & > input {
    width: calc(100% - 20px);
    margin: 40px 10px 20px;
    height: 42px;
    text-align: center;
  }
  & > .send {
    text-transform: uppercase;
    font-size: 18px;

    width: calc(100% - 20px);
    margin: 0 10px;
    height: 42px;
    background-color: #ffcd0c;
    &:hover {
      background: #ffe100;
    }
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
  }
}
</style>