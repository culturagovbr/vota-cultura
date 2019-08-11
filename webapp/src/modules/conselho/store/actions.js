import * as conselhoService from '../service/conselho';
import * as types from './types';


export const confirmarConselho = async ({ commit }, conselho) => {
  commit(types.DEFINIR_CONSELHO, conselho);
};

export const enviarDadosConselho = async ({ commit }, conselho) => {
  commit(types.DEFINIR_CONSELHO, {});
  return conselhoService.enviarDadosConselho(conselho);
};