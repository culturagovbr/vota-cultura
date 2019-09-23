import * as types from './types';

export const mutations = {
  [types.DEFINIR_REPRESENTANTE](state, dados) {
    state.representante = dados;
  },
  [types.OBTER_DADOS_REPRESENTANTE]() {},
  [types.LISTAR_REPRESENTANTES](state, representantes) {
    state.representantes = representantes;
  },
  [types.LISTAR_REPRESENTANTES_HABILITACAO](state, representantes) {
    state.representantes = representantes;
  },
};
