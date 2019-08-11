import * as localidadeService from '../../localidade/service/localidade';
import * as types from './types';

// eslint-disable-next-line import/prefer-default-export
export const obterCronogramas = async ({ commit }) => {
  localidadeService.obterCronogramas().then((response) => {
    commit(types.OBTER_CRONOGRAMAS, response.data);
  });
};
