import './styles/main.sass';
import Vue from 'vue';
import App from './App.vue';
import Constants from './common/constants';

// Tell Vue to use the plugin
Vue.prototype.CONSTANTS = Constants;
Vue.config.productionTip = false;

new Vue({
  render: h => h(App)
}).$mount("#app");