import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const enviarDadosRecursoInscricao = recurso => service.postRequest('/recurso/inscricao', recurso);

export const obterDadosRecursoInscricao = coRecurso => service.getRequest(`/recurso/inscricao/${coRecurso}`);

export const obterRecursosIncritos = () => service.getRequest('/recurso/inscricao');
