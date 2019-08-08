import * as organizacaoService from '../service/organizacao';
import * as types from './types';

// eslint-disable-next-line no-empty-pattern
export const enviarDadosOrganizacao = async ({ commit }, organizacao) => {
  // commit(types.DEFINIR_ORGANIZACAO, {});
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

