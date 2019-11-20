import * as organizacaoService from '../service/organizacao';
import * as types from './types';

// eslint-disable-next-line no-empty-pattern
export const enviarDadosOrganizacao = async ({ commit }, organizacao) => {
  commit(types.DEFINIR_ORGANIZACAO, {});
  return organizacaoService.enviarDadosOrganizacao(organizacao);
};

export const obterSegmentos = async ({ commit }) => {
  organizacaoService.obterSegmentos().then((response) => {
    commit(types.OBTER_SEGMENTOS, response.data);
  });
};

export const obterCriterios = async ({ commit }) => {
  organizacaoService.obterCriterios().then((response) => {
    commit(types.OBTER_CRITERIOS, response.data);
  });
};

export const confirmarOrganizacao = async ({ commit }, organizacao) => {
  commit(types.DEFINIR_ORGANIZACAO, organizacao);
};

export const obterDadosOrganizacao = async ({ commit, dispatch }, coOrganizacao) => {
  commit(types.OBTER_DADOS_ORGANIZACAO, coOrganizacao);
  return organizacaoService.obterDadosOrganizacao(coOrganizacao)
    .then((response) => {
      const { data } = response.data;
      if (!data) {
        const error = 'Não foi possível obter os dados do organizacao.';
        throw error;
      }
      commit(types.DEFINIR_ORGANIZACAO, data);
      return data;
    })
    .catch((error) => {
      dispatch(
        'app/setMensagemErro',
        error.response.data.error,
        { root: true },
      );
      throw new TypeError(error, 'obterDadosOrganizacao', 10);
    });
};

export const obterOrganizacoesRecurso = async ({ commit }) => {
  organizacaoService.obterOrganizacoes().then((response) => {
    commit(types.DEFINIR_ORGANIZACOES_RECURSO, response.data);
  });
};


export const obterOrganizacoes = async ({ commit }) => {
  organizacaoService.obterOrganizacoes().then((response) => {
    commit(types.DEFINIR_ORGANIZACOES, response.data);
  });
};

export const obterOrganizacoesHabilitadasEClassificadas = async ({ commit, dispatch }) => {
    return organizacaoService.obterOrganizacoes()
        .then((response) => {
          const { data } = response.data;
          if (!data) {
            const error = 'Não foi possível obter os dados do organizacao.';
            throw error;
          }
          commit(types.OBTER_ORGANIZACOES_HABILITADAS_E_CLASSIFICADAS, data);
          return data;
        })
        .catch((error) => {
          dispatch(
              'app/setMensagemErro',
              error,
              { root: true },
          );
          throw new TypeError(error, 'obterOrganizacoes', 10);
        });
};

export const enviarDadosOrganizacaoHabilitacaoRecurso = async ({ commit }, dadosRecurso) => organizacaoService.enviarDadosOrganizacaoHabilitacaoRecurso(dadosRecurso);

export const salvarOrganizacaoIndicacao = async ({ commit }, organizacaoIndicacao) => organizacaoService.salvarOrganizacaoIndicacao(organizacaoIndicacao);

export const obterDadosOrganizacaoIndicacao = async ({ commit }) =>  organizacaoService.obterDadosOrganizacaoIndicacao().then(response => {
  const { data } = response.data;
  commit(types.OBTER_INDICACAO_ORGANIZACAO, data);
});



export const alterarDadosOrganizacaoHabilitacaoRecurso = async ({ commit }, dadosRecurso) => organizacaoService.alterarDadosOrganizacaoHabilitacaoRecurso(dadosRecurso);

export const enviarDocumentacaoComprobatoria = async ({ commit }, payload) => {
  let respondendo = String();
  let errando = String();
  for (let indice = 0; indice < payload.anexos.length; indice++) {
    const anexo = payload.anexos[indice];
    let enviarEmail = false;
    if (payload.anexos.length === indice + 1) {
      enviarEmail = true;
    }

    anexo.enviarEmail = enviarEmail;

    await organizacaoService.enviarDocumentacaoComprobatoria(anexo).catch((error) => {
      errando = error.response.data.message;
    }).then((response) => {
      respondendo = response;
    });
    if (errando) {
      throw errando;
    }
  }
  return respondendo;
};

export const obterDocumentacaoComprobatoria = async ({ commit }, coOrganizacao) => organizacaoService.obterDocumentacaoComprobatoria(coOrganizacao).then((response) => {
  const { data } = response.data;
  commit(types.OBTER_DOCUMENTACAO_COMPROBATORIA, data);
  return response;
});

export const obterOrganizacoesHabilitacao = async ({ commit }) => {
  organizacaoService.obterOrganizacoesHabilitacao().then((response) => {
    const { data } = response.data;
    commit(types.LISTAR_ORGANIZACOES_HABILITACAO, data);
  });
};

export const avaliarHabilitacao = async ({ dispatch }, organizacaoHabilitacao) => organizacaoService.avaliarHabilitacao(organizacaoHabilitacao).then(response => response).catch((error) => {
  dispatch(
    'app/setMensagemErro',
    error.response.data.message,
    { root: true },
  );
  throw new TypeError(error);
});

export const modalVisualizacaoOrganizacaoAdministrador = async ({ commit }, dado) => {
  commit(types.MOSTRAR_MODAL_VISUALIZACAO, dado);
  if (!dado) {
    commit(types.DEFINIR_ORGANIZACAO, {});
  }
};

export const revisarHabilitacao = async ({ commit }, { coOrganizacaoHabilitacao, organizacaoHabilitacao }) =>  {
  return organizacaoService.revisarHabilitacao(coOrganizacaoHabilitacao, organizacaoHabilitacao).then((response) => {
    commit(types.REVISAR_HABILITACAO);
    return response;
  });
};
