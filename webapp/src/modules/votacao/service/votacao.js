import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const obterListaIndicadosVotacao = regiao => service.getRequest(`/conselho/indicacao/regiao/${regiao}`);
export const votar = indicadoId => service.postRequest('/conselho/votacao', indicadoId);
export const obterListaParcialRanking = () => service.getRequest('/conselho/votacao');
export const publicarResultadoDaVotacao = resultado => service.postRequest('/conselho/votacao/desempate', resultado);
export const obterListaFinalRanking = () => service.getRequest('/conselho/votacao/desempate/lista-final');
