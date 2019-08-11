import * as types from './types';

export const state = {
  estados: [],
};

export const mutations = {
  [types.OBTER_CRONOGRAMAS](state, dados) {
    state.cronogramas = dados.data;
  },
};
