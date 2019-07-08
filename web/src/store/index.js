import Vue from 'vue';
import Vuex from 'vuex';

import app from './app/index';
import usuario from './usuario/index';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    app,
    usuario,
  },
  getters: {
    route: state => state.route,
  },
  strict: process.env.NODE_ENV !== 'production',
});
