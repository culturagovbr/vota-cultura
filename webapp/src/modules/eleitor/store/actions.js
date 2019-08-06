import * as eleitorService from '../service/eleitor';
import * as localidadeService from '../../localidade/service/localidade';
import * as types from './types';
// import * as usuarioService from '../../conta/service/usuario';

// eslint-disable-next-line no-empty-pattern
export const enviarDadosEleitor = async ({}, eleitor) => {
  return eleitorService.enviarDadosEleitor(eleitor);
};


export const confirmarEleitor = async ({ commit }, eleitor) => {
  commit(types.DEFINIR_ELEITOR, eleitor);
};

export const consultarCPF = async ({ commit }, cpf) => {
  return eleitorService.consultarCPF(cpf);
};
