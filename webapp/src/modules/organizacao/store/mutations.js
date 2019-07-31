import * as types from './types';

export const state = {
  organizacao: {},
};

export const mutations = {
  [types.DEFINIR_USUARIO](state, dados) {
    state.organizacao = dados;
  },
};
