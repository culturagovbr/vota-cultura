import Vue from 'vue';
import Vuex from 'vuex';

import app from '@/core/store/app/';
import conta from '@/modules/conta/store/';
import conselho from '@/modules/conselho/store/';
import eleitor from '@/modules/eleitor/store/';
import organizacao from '@/modules/organizacao/store/';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    app,
    conta,
    conselho,
    eleitor,
    organizacao,
  },
  getters: {
    route: state => state.route,
  },
  strict: process.env.NODE_ENV !== 'production',
});
