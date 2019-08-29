import * as conselhoService from '../service/conselho';
import * as types from './types';


export const confirmarConselho = async ({ commit }, conselho) => {
  commit(types.DEFINIR_CONSELHO, conselho);
};

export const enviarDadosConselho = async ({ commit }, conselho) => {
  commit(types.DEFINIR_CONSELHO, {});
  return conselhoService.enviarDadosConselho(conselho);
};

export const obterDadosConselho = async ({ commit, dispatch }, coConselho) => {
  commit(types.OBTER_DADOS_CONSELHO, coConselho);
  conselhoService.obterDadosConselho(coConselho)
    .then((response) => {
      const { data } = response.data;
      if (!data) {
        const error = 'Não foi possível obter os dados do conselho.';
        throw error;
      }
      commit(types.DEFINIR_CONSELHO, data);
      return data;
    })
    .catch((error) => {
      dispatch(
        'app/setMensagemErro',
        error.response.data.error,
        { root: true },
      );
      throw new TypeError(error, 'obterDadosConselho', 10);
    });
};
