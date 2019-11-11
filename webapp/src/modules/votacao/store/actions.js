import * as service from '../service/votacao';
import * as types from './types';

export const obterListaIndicadosVotacao = async ({ commit, dispatch }, regiao) => service.obterListaIndicadosVotacao(regiao).then((response) => {
  const { data } = response.data;
  const { possuiVoto } = response.data;

  commit(types.LISTAR_INDICADOS_VOTACAO, data);
  commit(types.USUARIO_POSSUI_VOTO, possuiVoto);
}).catch((error) => {
  dispatch(
      'app/setMensagemErro',
      error.response.data.message,
      { root: true },
  );
  throw new TypeError(error);
});

export const votar = async ({ commit, dispatch }, regiao) => service.votar(regiao).then((response) => {
 return response;
}).catch((error) => {
  dispatch(
      'app/setMensagemErro',
      error.response.data.message,
      { root: true },
  );
  throw new TypeError(error);
});