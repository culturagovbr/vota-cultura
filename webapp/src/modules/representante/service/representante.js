import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const enviarDadosRepresentante = representante => service.postRequest('/representante', representante);
export const obterDadosRepresentante = coRepresentante => service.getRequest(`/representante/${coRepresentante}`);
export const obterRepresentantes = () => service.getRequest('/representante');
export const obterRepresentantesHabilitacao = () => service.getRequest('/representante/lista_habilitacao');
