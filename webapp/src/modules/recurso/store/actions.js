import * as types from './types';
import * as recursoService from '../service/recurso';

export const confirmarRecurso = async ({ commit }, recurso) => {
  commit(types.DEFINIR_RECURSO, recurso);
};

export const enviarDadosRecurso = async ({ commit }, recurso) => {
  commit(types.DEFINIR_RECURSO, {});
  return recursoService.enviarDadosRecurso(recurso);
};

export const enviarDadosRecursoInscricao = async ({ commit, dispatch }, recurso) =>  {
  commit(types.ENVIAR_DADOS_RECURSO);
  return recursoService.enviarDadosRecursoInscricao(recurso).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      { text: error.response.data.message },
      { root: true },
    );
    throw new TypeError(error, 'enviarDadosRecursoInscricao', 10);
  });
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
        { text: error.response.data.error },
        { root: true },
      );
      throw new TypeError(error, 'obterDadosRecurso', 10);
    });
};

export const obterRecursos = async ({ commit }) => {
  recursoService.obterRecursosIncritos().then((response) => {
    const { data } = response.data;
    commit(types.LISTAR_RECURSOS, data);
  });
};

export const avaliarRecursoInscricao = async ({ commit, dispatch }, recurso) => recursoService.avaliarRecursoInscricao(recurso).then((response) => {
  const { data } = response.data;
  commit(types.ATUALIZAR_RECURSO_INSCRICAO_LISTA, data);

  dispatch(
    'app/setMensagemSucesso',
    { text: 'Recurso avaliado com sucesso!' },
    { root: true },
  );
  return response;
}).catch((error) => {
  dispatch(
    'app/setMensagemErro',
    { text: error.response.data.message },
    { root: true },
  );
  throw new TypeError(error);
});
