import * as types from './types';

export const mutations = {
  [types.LISTAR_INDICADOS_VOTACAO](state, indicados) {
    state.listaIndicadosParaVotacao = indicados;
  },
  [types.USUARIO_POSSUI_VOTO](state, possuiVoto) {
    state.possuiVoto = possuiVoto;
  },
  [types.LISTA_PARCIAL_RANKING](state, indicados) {
    state.listaParcialRanking = indicados;
  },
};
