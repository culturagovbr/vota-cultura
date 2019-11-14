import Vue from 'vue';
import Vuex from 'vuex';

import app from '@/core/store/app/';
import conta from '@/modules/conta/store/';
import conselho from '@/modules/conselho/store/';
import eleitor from '@/modules/eleitor/store/';
import organizacao from '@/modules/organizacao/store/';
import localidade from '@/modules/localidade/store/';
import fase from '@/modules/fase/store/';
import pessoa from '@/modules/pessoa/store/';
import recurso from '@/modules/recurso/store/';
import shared from '@/modules/shared/store/';
import votacao from '@/modules/votacao/store/';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    app,
    conta,
    conselho,
    eleitor,
    organizacao,
    localidade,
    fase,
    pessoa,
    recurso,
    shared,
    votacao,
  },
  strict: process.env.NODE_ENV !== 'production',
});
