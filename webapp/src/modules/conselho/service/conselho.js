import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const enviarDadosConselho = conselho => service.postRequest('/conselho', conselho);
export const obterDadosConselho = coConselho => service.getRequest(`/conselho/${coConselho}`);
export const obterConselhos = () => service.getRequest('/conselho');
export const obterConselhosHabilitacao = () => service.getRequest('/conselho/lista_habilitacao');
export const avaliarHabilitacao = conselho => service.postRequest('/conselho', conselho);
