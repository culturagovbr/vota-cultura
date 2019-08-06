import * as conselhoService from '../service/conselho';
import * as types from './types';

// export const enviarDadosConselho = async ({}, conselho) => conselhoService.enviarDadosConselho(conselho);


export const confirmarConselho = async ({ commit }, conselho) => {
  commit(types.DEFINIR_CONSELHO, conselho);
};

export const enviarDadosConselho = async ({}, conselho) => {
  return conselhoService.enviarDadosConselho(conselho);
};