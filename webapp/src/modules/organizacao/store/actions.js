import * as organizacaoService from '../service/organizacao';

// eslint-disable-next-line no-empty-pattern
export const cadastrarOrganizacao = async ({}, organizacao) => organizacaoService.cadastrarOrganizacao(organizacao);
