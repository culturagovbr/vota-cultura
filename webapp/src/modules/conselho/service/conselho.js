import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const enviarDadosConselho = conselho => service.postRequest('/conselho', conselho);
export const enviarDadosRecursoConselhoHabilitacao = conselho => service.postRequest('/conselho/habilitacao-recurso', service.buildData(conselho));
export const obterDadosConselho = coConselho => service.getRequest(`/conselho/${coConselho}`);
export const obterConselhos = () => service.getRequest('/conselho');
export const obterConselhosHabilitacao = () => service.getRequest('/conselho/habilitacao');
export const avaliarHabilitacao = conselho => service.postRequest('/conselho/habilitacao', conselho);
export const obterConselhosParcialmenteHabilitados = () => service.getRequest('/conselho/habilitacao/lista-parcial');
export const enviarIndicacaoConselho = payload => service.postRequest('/conselho/indicacao', service.buildData(payload));
export const enviarIndicacaoConselhoRecurso = payload => service.postRequest('/conselho/indicacao/recurso', service.buildData(payload));
export const enviarIndicacaoConselhoArquivo = payload => service.postRequest('/conselho/indicacao/arquivo', service.buildData(payload));
export const obterListaIndicacaoConselho = () => service.getRequest('/conselho/indicacao');
export const deletarIndicacaoConselho = coConselhoIndicacao => service.deleteRequest('/conselho/indicacao', coConselhoIndicacao);
export const atualizarConselho = conselho => service.patchRequest(
  '/conselho',
  conselho.co_conselho,
  conselho,
);
export const avaliarHabilitacaoIndicacao = payload => service.postRequest('/conselho/indicacao/habilitacao', payload);
export const revisarHabilitacaoIndicacao = (payload, coConselhoIndicacaoHabilitacao) => service.putRequest('/conselho/indicacao/habilitacao',
  coConselhoIndicacaoHabilitacao,
  payload);

export const obterListaParcialIndicados = () => service.getRequest('/conselho/indicacao/lista-parcial');
export const obterRecursoIndicacao = () => service.getRequest('/conselho/indicacao/recurso');