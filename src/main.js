// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store/index.js'
import VueMyUtils from './utils.js'
import VeeValidate from 'vee-validate'

Vue.config.productionTip = false;
/* eslint-disable no-new */

Vue.use(VueMyUtils);
Vue.use(VeeValidate);

new Vue({
  el: '#app',
  store,
  router,
  template: '<App/>',
  components: {App}
});



