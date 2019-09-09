import * as types from './types';

export const mutations = {
  [types.DEFINIR_RECURSO](state, dados) {
    state.recurso = dados;
  },
  [types.OBTER_DADOS_RECURSO]() {},
  [types.LISTAR_RECURSOS](state, recursos) {
    state.recursos = recursos;
  },
};
