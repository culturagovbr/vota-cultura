import Vue from 'vue';
import Vuex from 'vuex';

import app from '@/core/store/app/';
import conta from '@/modules/conta/store/';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    app,
    conta,
  },
  getters: {
    route: state => state.route,
  },
  strict: process.env.NODE_ENV !== 'production',
});
