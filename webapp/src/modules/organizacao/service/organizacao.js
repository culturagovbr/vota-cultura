import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const enviarDadosOrganizacao = organizacao => service.postRequest('/organizacao', organizacao);

export const obterSegmentos = () => service.getRequest('/organizacao/segmento');

export const obterCriterios = () => service.getRequest('/organizacao/criterio');

export const obterDadosOrganizacao = coOrganizacao => service.getRequest(`/organizacao/${coOrganizacao}`);

export const obterOrganizacoes = () => service.getRequest('/organizacao');

export const enviarDocumentacaoComprobatoria = payload => service.postRequest('/organizacao/documentacao-comprobatoria', payload);

export const obterDocumentacaoComprobatoria = coOrganizacao => service.getRequest(`/organizacao/${coOrganizacao}/documentacao-comprobatoria`);
