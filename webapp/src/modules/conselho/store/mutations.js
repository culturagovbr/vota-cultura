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
  [types.LISTAR_CONSELHOS_PARCIALMENTE_HABILITADOS](state, conselhos) {
    state.conselhos = conselhos;
  },
  [types.MOSTRAR_MODAL_VISUALIZACAO](state, dados) {
    state.modalVisualizacaoConselhoAdministrador = dados;
  },
};
