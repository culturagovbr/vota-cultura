import * as types from './types';

export const state = {
  organizacao: {},
  segmentos: [],
};

export const mutations = {
  [types.DEFINIR_USUARIO](state, dados) {
    state.organizacao = dados;
  },
  [types.OBTER_SEGMENTOS](state, dados) {
    state.segmentos = dados.data;
  },
};
