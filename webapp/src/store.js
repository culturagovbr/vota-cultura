import Vue from 'vue';
import Vuex from 'vuex';

import app from '@/core/store/app/';
import conta from '@/modules/conta/store/';
import conselho from '@/modules/conselho/store/';
import eleitor from '@/modules/eleitor/store/';
import organizacao from '@/modules/organizacao/store/';
import localidade from '@/modules/localidade/store/';
import cronograma from '@/modules/cronograma/store/';
import pessoa from '@/modules/pessoa/store/';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    app,
    conta,
    conselho,
    eleitor,
    organizacao,
    localidade,
    cronograma,
    pessoa,
  },
  getters: {
    route: state => state.route,
  },
  strict: process.env.NODE_ENV !== 'production',
});
