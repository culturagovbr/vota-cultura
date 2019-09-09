import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const enviarDadosRecurso = recurso => service.postRequest('/recurso', recurso);

export const obterDadosRecurso = coRecurso => service.getRequest(`/recurso/${coRecurso}`);

export const obterRecursos = () => service.getRequest('/recurso');
