import * as cronogramaService from '../service/cronograma';
import * as types from './types';

// eslint-disable-next-line import/prefer-default-export
export const obterCronogramas = async ({ commit }) => cronogramaService.obterCronogramas().then((response) => {
  commit(types.OBTER_CRONOGRAMAS, response.data);
  commit(types.DEFINIR_SITUACOES, response.data);
});
