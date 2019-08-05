import * as types from './types';

export const state = {
  estados: [],
};

export const mutations = {
  [types.OBTER_ESTADOS](state, dados) {
    state.estados = dados.data;
  },
};
