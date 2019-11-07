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
  [types.LISTAR_INDICACOES_CONSELHO](state, dados) {
    state.listarIndicacaoConselho = dados;
  },
  [types.DELETAR_INDICACAO_CONSELHO](state, coConselhoIndicacao) {
    const index = state.listarIndicacaoConselho.findIndex(
      indicado => indicado.co_conselho_indicacao === coConselhoIndicacao,
    );
    state.listarIndicacaoConselho.splice(index, 1);
  },
  [types.CONCLUIR_INDICACAO](state) {
    state.conselho.st_indicacao = 'f';
  },
  [types.LISTAR_RECURSO_INDICACAO](state, data) {
    state.recursoIndicacao = data;
  },
  [types.OBTER_LISTA_PARCIAL_INDICADOS](state, indicados) {
    state.listaParcialIndicados = indicados;
  },
};
