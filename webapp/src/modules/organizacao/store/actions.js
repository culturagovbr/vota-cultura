import * as organizacaoService from '../service/organizacao';
import * as types from './types';
import {criterios} from "./getters";

// eslint-disable-next-line no-empty-pattern
export const cadastrarOrganizacao = async ({}, organizacao) => organizacaoService.cadastrarOrganizacao(organizacao);

export const obterSegmentos = async ({ commit }) => {
  organizacaoService.obterSegmentos().then((response) => {
    commit(types.OBTER_SEGMENTOS, response.data);
  });
};

export const obterCriterios = async ({ commit }) => {
  organizacaoService.obterCriterios().then((response) => {
    commit(types.OBTER_CRITERIOS, response.data);
  });
};

export const confirmarOrganizacao= async ({ commit }, criterios) => {
  commit(types.DEFINIR_ORGANIZACAO, criterios);
};