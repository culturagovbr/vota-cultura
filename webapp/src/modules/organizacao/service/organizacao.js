import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

const buildData = (params) => {
  const bodyFormData = new FormData();

  Object.keys(params).forEach((key) => {
    bodyFormData.append(key, params[key]);
  });
  return bodyFormData;
};

export const enviarDadosOrganizacao = organizacao => service.postRequest('/organizacao', organizacao);
export const obterSegmentos = () => service.getRequest('/organizacao/segmento');
export const obterCriterios = () => service.getRequest('/organizacao/criterio');
export const obterDadosOrganizacao = coOrganizacao => service.getRequest(`/organizacao/${coOrganizacao}`);
export const obterOrganizacoes = () => service.getRequest('/organizacao');
export const enviarDocumentacaoComprobatoria = payload => service.postRequest('/organizacao/documentacao-comprobatoria', buildData(payload));
export const obterDocumentacaoComprobatoria = coOrganizacao => service.getRequest(`/organizacao/${coOrganizacao}/documentacao-comprobatoria`);
export const obterOrganizacoesHabilitacao = () => service.getRequest('/organizacao/habilitacao');
export const avaliarHabilitacao = organizacao => service.postRequest('/organizacao/habilitacao', organizacao);

