import * as types from './types';

export const state = {
  conselho: {},
};

export const mutations = {
  [types.DEFINIR_CONSELHO](state, dados) {
    state.conselho = dados;
  },
};
