import * as organizacaoService from '../service/organizacao';
import * as types from './types';

// eslint-disable-next-line no-empty-pattern
export const cadastrarOrganizacao = async ({}, organizacao) => organizacaoService.cadastrarOrganizacao(organizacao);

export const obterSegmentos = async ({ commit }) => {
  organizacaoService.obterEstados().then((response) => {
    commit(types.OBTER_SEGMENTOS, response.data);
  });
};