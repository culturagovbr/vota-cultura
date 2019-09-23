import * as organizacaoService from '../service/organizacao';
import * as types from './types';

// eslint-disable-next-line no-empty-pattern
export const enviarDadosOrganizacao = async ({ commit }, organizacao) => {
  commit(types.DEFINIR_ORGANIZACAO, {});
  return organizacaoService.enviarDadosOrganizacao(organizacao);
};

export const obterSegmentos = async ({ commit }) => {
  organizacaoService.obterSegmentos().then((response) => {
    commit(types.OBTER_SEGMENTOS, response.data);
  });
};

export const obterCriterios = async ({ commit }) => {
  organizacaoService.obterCriterios().then((response) => {
    commit(types.OBTER_CRITERIOS, response.data);
  });
};

export const confirmarOrganizacao = async ({ commit }, organizacao) => {
  commit(types.DEFINIR_ORGANIZACAO, organizacao);
};

export const obterDadosOrganizacao = async ({ commit, dispatch }, coOrganizacao) => {
  commit(types.OBTER_DADOS_ORGANIZACAO, coOrganizacao);
  organizacaoService.obterDadosOrganizacao(coOrganizacao)
    .then((response) => {
      const { data } = response.data;
      if (!data) {
        const error = 'Não foi possível obter os dados do organizacao.';
        throw error;
      }
      commit(types.DEFINIR_ORGANIZACAO, data);
      return data;
    })
    .catch((error) => {
      dispatch(
        'app/setMensagemErro',
        error.response.data.error,
        { root: true },
      );
      throw new TypeError(error, 'obterDadosOrganizacao', 10);
    });
};

export const obterOrganizacoes = async ({ commit }) => {
  organizacaoService.obterOrganizacoes().then((response) => {
    commit(types.DEFINIR_ORGANIZACOES, response.data);
  });
};

export const enviarDocumentacaoComprobatoria = async ({ commit }, payload) => {
  return organizacaoService.enviarDocumentacaoComprobatoria(payload).then((response) => {
    return response;
  });
};

export const obterDocumentacaoComprobatoria = async ({ commit }, coOrganizacao) => {
  return organizacaoService.obterDocumentacaoComprobatoria(coOrganizacao).then((response) => {
    const { data } = response.data;
    commit(types.OBTER_DOCUMENTACAO_COMPROBATORIA, data)
    return response;
  });
};
