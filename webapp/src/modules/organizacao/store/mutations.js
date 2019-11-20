import * as types from './types';

export const mutations = {
  [types.DEFINIR_ORGANIZACOES_RECURSO](state, dados) {
    state.organizacoesRecurso = dados.data.filter(recurso => {
      return recurso.habilitacaoRecurso ? recurso : null
    });
  },
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
  [types.OBTER_DOCUMENTACAO_COMPROBATORIA](state, dados) {
    state.documentacaoComprobatoria = dados;
  },
  [types.LISTAR_ORGANIZACOES_HABILITACAO](state, organizacoes) {
    state.organizacoes = organizacoes;
  },
  [types.MOSTRAR_MODAL_VISUALIZACAO](state, dados) {
    state.modalVisualizacaoOrganizacaoAdministrador = dados;
  },
  [types.OBTER_INDICACAO_ORGANIZACAO](state, dados) {
    console.log(dados);
    state.organizacaoIndicacao = dados;
  },
  [types.OBTER_ORGANIZACOES_HABILITADAS_E_CLASSIFICADAS](state, dados) {
    state.organizacoesHabilitadasEClassificadas = dados.filter(organizacao => {
      if(Object.keys(((organizacao || {}).habilitacaoRecurso || {})).length > 0) {
          if (parseInt(organizacao.habilitacaoRecurso.st_parecer) === 2) {
              return organizacao;
          }
      }

      if(parseInt(organizacao.organizacaoHabilitacao.st_avaliacao) === 2) {
        return organizacao;
      }
    });
  },

};
