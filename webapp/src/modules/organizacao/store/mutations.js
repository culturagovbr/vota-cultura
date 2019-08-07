import * as types from './types';

export const state = {
  organizacao: {},
  segmentos: [],
  criterios: [],
};

export const mutations = {
  [types.DEFINIR_USUARIO](state, dados) {
    state.organizacao = dados;
  },
  [types.OBTER_SEGMENTOS](state, dados) {
    state.segmentos = dados.data;
  },
  [types.OBTER_CRITERIOS](state, dados) {
    state.criterios = dados.data;
  },
  [types.DEFINIR_ORGANIZACAO](state, dados) {
    state.organizacao = dados.data;
  },
};
