import * as types from './types';

export const mutations = {
  [types.DEFINIR_ELEITOR](state, eleitor) {
    state.eleitor = eleitor;
  },
  [types.CONFIRMAR_ELEITOR]() {},
  [types.OBTER_DADOS_ELEITOR]() {},
  [types.ENVIAR_DADOS_ELEITOR]() {},
};
