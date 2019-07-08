import Vue from 'vue';
import './plugins/vuetify';
import App from './App.vue';
import router from './router/index';
import store from './store/index';
import './registerServiceWorker';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';

Vue.config.productionTip = false;

// Vue.config.errorHandler = function (err, vm, info) {
//   // handle error
//   // `info` is a Vue-specific error info, e.g. which lifecycle hook
//   // the error was found in. Only available in 2.2.0+
//   console.log('erorrrrr', err,  vm,  info);
// };

// Vue.prototype.$eventHub = new Vue(); // Global event bus
// export const EventBus = new Vue();

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app');
