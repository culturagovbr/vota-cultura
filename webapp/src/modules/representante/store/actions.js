import * as representanteService from '../service/representante';
import * as types from './types';

export const confirmarRepresentante = async ({ commit }, representante) => {
  commit(types.DEFINIR_REPRESENTANTE, representante);
};

export const enviarDadosRepresentante = async ({ commit }, representante) => {
  commit(types.DEFINIR_REPRESENTANTE, {});
  return representanteService.enviarDadosRepresentante(representante);
};

export const obterDadosRepresentante = async ({ commit, dispatch }, coRepresentante) => {
  commit(types.OBTER_DADOS_REPRESENTANTE, coRepresentante);
  representanteService.obterDadosRepresentante(coRepresentante)
    .then((response) => {
      const { data } = response.data;
      if (!data) {
        const error = 'Não foi possível obter os dados do representante.';
        throw error;
      }
      commit(types.DEFINIR_REPRESENTANTE, data);
      return data;
    })
    .catch((error) => {
      dispatch(
        'app/setMensagemErro',
        error.response.data.error,
        { root: true },
      );
      throw new TypeError(error, 'obterDadosRepresentante', 10);
    });
};

export const obterRepresentantes = async ({ commit }) => {
  representanteService.obterRepresentantes().then((response) => {
    const { data } = response.data;
    commit(types.LISTAR_REPRESENTANTES, data);
  });
};

export const obterRepresentantesHabilitacao = async ({ commit }) => {
  representanteService.obterRepresentantesHabilitacao().then((response) => {
    const { data } = response.data;
    commit(types.LISTAR_REPRESENTANTES_HABILITACAO, data);
  });
};
