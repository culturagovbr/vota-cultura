import * as types from './types';

export const state = {
  eleitor: {},
};

export const mutations = {
  [types.DEFINIR_CONSELHO](state, dados) {
    state.eleitor = dados;
  },
};
