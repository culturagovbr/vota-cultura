import * as types from './types';

export const state = {
  usuario: {},
};

export const mutations = {
  [types.DEFINIR_USUARIO](state, dados) {
    state.usuario = dados;
  },
  [types.DEFINIR_DADOS_PRIMEIRO_ACESSO]() {
  },
};
