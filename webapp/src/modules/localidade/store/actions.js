import * as eleitorService from '../service/localidade';
import * as localidadeService from '../../localidade/service/localidade';
import * as types from './types';

// eslint-disable-next-line no-empty-pattern
// export const cadastrarEleitor = async ({}, eleitor) => localidadeService.cadastrarEleitor(eleitor);

export const obterEstados = async ({ commit }) => {
  localidadeService.obterEstados().then((response) => {
    commit(types.OBTER_ESTADOS, response.data);
  });
};
