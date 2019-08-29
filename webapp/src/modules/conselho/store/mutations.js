import * as types from './types';

export const mutations = {
  [types.DEFINIR_CONSELHO](state, dados) {
    state.conselho = dados;
  },
  // [types.CONFIRMAR_CONSELHO]() {},
  [types.OBTER_DADOS_CONSELHO]() {},
  // [types.ENVIAR_DADOS_CONSELHO]() {},
};
