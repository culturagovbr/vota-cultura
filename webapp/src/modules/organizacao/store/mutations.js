import * as types from './types';

export const mutations = {
  [types.OBTER_SEGMENTOS](state, dados) {
    state.segmentos = dados.data;
  },
  [types.OBTER_CRITERIOS](state, dados) {
    state.criterios = dados.data;
  },
  [types.DEFINIR_ORGANIZACAO](state, dados) {
    state.organizacao = dados;
  },
  [types.OBTER_DADOS_ORGANIZACAO]() {},
  [types.DEFINIR_ORGANIZACOES](state, dados) {
    state.organizacoes = dados.data;
  },
};
