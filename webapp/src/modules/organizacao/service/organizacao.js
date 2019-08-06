import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const cadastrarOrganizacao = organizacao => service.postRequest('/organizacao', organizacao);

export const obterSegmentos = () => service.getRequest('/organizacao/segmento');