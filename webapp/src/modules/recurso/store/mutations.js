import * as types from './types';

export const mutations = {
  [types.DEFINIR_RECURSO](state, dados) {
    state.recurso = dados;
  },
  [types.OBTER_DADOS_RECURSO]() {},
  [types.LISTAR_RECURSOS](state, recursos) {
    state.recursos = recursos;
  },
  [types.ATUALIZAR_RECURSO_INSCRICAO_LISTA](state, recursoEditado) {
    const index = state.recursos.findIndex(
      recurso => recurso.co_recurso_inscricao === recursoEditado.co_recurso_inscricao,
    );
    Object.assign(state.recursos[index], recursoEditado);
  },
};
