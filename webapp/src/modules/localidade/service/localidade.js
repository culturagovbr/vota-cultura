import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const obterEstados = () => service.getRequest('/localidade/uf');

export const obterMunicipios = (coIBGE) => service.getRequest('/localidade/municipio-por-uf/' + coIBGE);
