import * as recursoService from '../service/recurso';
import * as types from './types';

export const confirmarRecurso = async ({ commit }, recurso) => {
  commit(types.DEFINIR_RECURSO, recurso);
};

export const enviarDadosRecurso = async ({ commit }, recurso) => {
  commit(types.DEFINIR_RECURSO, {});
  return recursoService.enviarDadosRecurso(recurso);
};

export const enviarDadosRecursoInscricao = async ({ commit }, recurso) => {
  console.log(recurso);
  // return recursoService.enviarDadosRecurso(recurso);
};

export const obterDadosRecurso = async ({ commit, dispatch }, coRecurso) => {
  commit(types.OBTER_DADOS_RECURSO, coRecurso);
  recursoService.obterDadosRecurso(coRecurso)
    .then((response) => {
      const { data } = response.data;
      if (!data) {
        const error = 'Não foi possível obter os dados do recurso.';
        throw error;
      }
      commit(types.DEFINIR_RECURSO, data);
      return data;
    })
    .catch((error) => {
      dispatch(
        'app/setMensagemErro',
        error.response.data.error,
        { root: true },
      );
      throw new TypeError(error, 'obterDadosRecurso', 10);
    });
};

export const obterRecursos = async ({ commit }) => {
  recursoService.obterRecursos().then((response) => {
    const { data } = response.data;
    commit(types.LISTAR_RECURSOS, data);
  });
};
