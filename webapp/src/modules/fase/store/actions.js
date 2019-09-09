import moment from 'moment';
import * as faseService from '../service/fase';
import * as types from './types';

// eslint-disable-next-line import/prefer-default-export
export const obterFases = async ({ commit }) => faseService.obterFases().then((response) => {
  commit(types.OBTER_FASES, response.data);
  commit(types.DEFINIR_SITUACOES, response.data);
  return response;
});