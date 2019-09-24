import * as types from './types';

export const mutations = {
  [types.DEFINIR_CONSELHO](state, dados) {
    state.conselho = dados;
  },
  [types.OBTER_DADOS_CONSELHO]() {},
  [types.LISTAR_CONSELHOS](state, conselhos) {
    state.conselhos = conselhos;
  },
  [types.LISTAR_CONSELHOS_HABILITACAO](state, conselhos) {
    state.conselhos = conselhos;
  },
};
