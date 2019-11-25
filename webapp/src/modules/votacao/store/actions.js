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

export const obterListaParcialRanking = async ({ commit, dispatch }) => service.obterListaParcialRanking().then((response) => {
  const { data } = response.data;
  commit(types.LISTA_PARCIAL_RANKING, data);
}).catch((error) => {
  dispatch(
      'app/setMensagemErro',
      error.response.data.message,
      { root: true },
  );
  throw new TypeError(error);
});

export const publicarResultadoDaVotacao = async ({ commit, dispatch }, resultado) => service.publicarResultadoDaVotacao(resultado).then((response) => {
  return response;
}).catch((error) => {
  dispatch(
      'app/setMensagemErro',
      error.response.data.message,
      { root: true },
  );
  throw new TypeError(error);
});

export const obterListaFinalRanking = async ({ commit, dispatch }) => service.obterListaFinalRanking().then((response) => {
  const { data } = response.data;
  commit(types.LISTA_FINAL_RANKING, data);
}).catch((error) => {
  dispatch(
      'app/setMensagemErro',
      error.response.data.message,
      { root: true },
  );
  throw new TypeError(error);
});