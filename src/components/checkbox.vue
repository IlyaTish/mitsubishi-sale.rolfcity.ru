<template>
  <div class="checkbox-container" @click="change">
    <div class="checkbox-itself" :class="{ checked: is_true }"></div>
    <slot></slot>
  </div>
</template>

<script>
export default {
  components: {},
  name: "CheckBox",
  props: ["value"],
  data() {
    return {};
  },
  computed: {
    is_true() {
      if (!Array.isArray(this.value)) {
        return this.value;
      }
      return this.value.includes(this.$attrs.value);
    }
  },
  methods: {
    change() {
      if (!Array.isArray(this.value)) {
        this.$emit("input", !this.value);
      } else {
        let index = this.value.indexOf(this.$attrs.value);
        if (index >= 0) {
          this.$emit(
            "input",
            this.value.filter(item => item != this.$attrs.value)
          );
        } else {
          let ret = this.value.map(e => e);
          ret.push(this.$attrs.value);
          this.$emit("input", ret);
        }
      }
    }
  }
};
</script>

<style scoped lang="scss">
.checkbox-container {
  width: 15px;
  height: 15px;
  cursor: pointer;
  margin: 0 6px 0 0;
  display: flex;
  white-space: nowrap;
  align-items: center;
}

.checkbox-itself {
  display: block;
  float: left;
  flex-shrink: 0;
  height: 16px;
  width: 16px;
  position: relative;
  bottom: 2px;

  &.checked {
    background: url("../images/agreement.png") no-repeat center;
    background-size: contain;
  }

  &:not(.checked) {
    background: url("../images/disagreement.png") no-repeat center;
    background-size: contain;
  }
}

.checkbox-itself + * {
  margin-left: 10px;
}
</style>
