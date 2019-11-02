import * as conselhoService from '../service/conselho';
import * as types from './types';
import { revisarHabilitacaoIndicacao } from '../service/conselho';


export const confirmarConselho = async ({ commit }, conselho) => {
  commit(types.DEFINIR_CONSELHO, conselho);
};

export const enviarDadosConselho = async ({ commit }, conselho) => {
  commit(types.DEFINIR_CONSELHO, {});
  return conselhoService.enviarDadosConselho(conselho);
};

export const enviarDadosRecursoConselhoHabilitacao = async ({ commit }, dadosRecurso) => conselhoService.enviarDadosRecursoConselhoHabilitacao(dadosRecurso);

export const obterDadosConselho = async ({ commit, dispatch }, coConselho) => {
  commit(types.OBTER_DADOS_CONSELHO, coConselho);
  return conselhoService.obterDadosConselho(coConselho)
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

export const obterDadosRecurso = async ({ commit, dispatch }, coConselho) => conselhoService.obterDadosRecurso(coConselho)
  .then((response) => {
    const { data } = response.data;
    if (!data) {
      const error = 'Não foi possível obter os dados do recurso.';
      throw error;
    }
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

export const obterConselhos = async ({ commit }) => {
  conselhoService.obterConselhos().then((response) => {
    const { data } = response.data;
    commit(types.LISTAR_CONSELHOS, data);
  });
};

export const obterConselhosHabilitacao = async ({ commit }) => {
  conselhoService.obterConselhosHabilitacao().then((response) => {
    const { data } = response.data;
    commit(types.LISTAR_CONSELHOS_HABILITACAO, data);
  });
};

export const avaliarHabilitacao = async ({ dispatch }, conselhoHabilitacao) => conselhoService.avaliarHabilitacao(conselhoHabilitacao).then(response => response).catch((error) => {
  dispatch(
    'app/setMensagemErro',
    error.response.data.message,
    { root: true },
  );
  throw new TypeError(error);
});

export const modalVisualizacaoConselhoAdministrador = async ({ commit }, dado) => {
  commit(types.MOSTRAR_MODAL_VISUALIZACAO, dado);
  if (!dado) {
    commit(types.DEFINIR_CONSELHO, {});
  }
};
export const obterConselhosParcialmenteHabilitados = async ({ commit }) => {
  conselhoService.obterConselhosParcialmenteHabilitados().then((response) => {
    const { data } = response.data;
    commit(types.LISTAR_CONSELHOS_PARCIALMENTE_HABILITADOS, data);
  });
};

export const enviarIndicacaoConselho = async ({ dispatch }, payload) => conselhoService.enviarIndicacaoConselho(payload).then((response) => {
  dispatch(
    'conselho/obterListaIndicacaoConselho',
    {},
    { root: true },
  );
  return response;
}).catch((error) => {
  dispatch(
    'app/setMensagemErro',
    error.response.data.message,
    { root: true },
  );
  throw new TypeError(error);
});

export const enviarIndicacaoConselhoArquivo = async ({ dispatch }, payload) => conselhoService.enviarIndicacaoConselhoArquivo(payload)
  .then(response => response)
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message,
      { root: true },
    );
    throw new TypeError(error);
  });

export const obterListaIndicacaoConselho = async ({ commit, dispatch }, payload) => conselhoService.obterListaIndicacaoConselho(payload).then((response) => {
  const { data } = response.data;
  commit(types.LISTAR_INDICACOES_CONSELHO, data);
}).catch((error) => {
  dispatch(
    'app/setMensagemErro',
    error.response.data.message,
    { root: true },
  );
  throw new TypeError(error);
});

export const deletarIndicacaoConselho = async ({ commit, dispatch }, coConselhoIndicacao) => conselhoService.deletarIndicacaoConselho(coConselhoIndicacao).then((response) => {
  commit(types.DELETAR_INDICACAO_CONSELHO, coConselhoIndicacao);
  dispatch(
    'app/setMensagemSucesso',
    'Indicado excluído com sucesso.',
    { root: true },
  );
  return response;
}).catch((error) => {
  dispatch(
    'app/setMensagemErro',
    error.response.data.message,
    { root: true },
  );
  throw new TypeError(error);
});

export const concluirIndicacao = async ({ commit, dispatch }, conselhoId) => conselhoService.atualizarConselho({
  co_conselho: conselhoId,
  st_indicacao: 'f',
}).then((response) => {
  commit(types.CONCLUIR_INDICACAO);
  dispatch(
    'app/setMensagemSucesso',
    'Indicação concluída com sucesso.',
    { root: true },
  );
  return response;
}).catch((error) => {
  dispatch(
    'app/setMensagemErro',
    error.response.data.message,
    { root: true },
  );
  throw new TypeError(error);
});

export const avaliarHabilitacaoIndicacao = async ({}, avaliacao) => {
  if ((avaliacao || {}).co_conselho_indicacao_habilitacao) {
    return conselhoService.revisarHabilitacaoIndicacao(
      avaliacao,
      avaliacao.co_conselho_indicacao_habilitacao,
    );
  }
  return conselhoService.avaliarHabilitacaoIndicacao(
    avaliacao,
  );
};

export const obterListaParcialIndicados = async ({ commit, dispatch }) => conselhoService.obterListaParcialIndicados().then((response) => {
  const { data } = response.data;
  commit(types.OBTER_LISTA_PARCIAL_INDICADOS, data);
}).catch((error) => {
  dispatch(
      'app/setMensagemErro',
      error.response.data.message,
      { root: true },
  );
  throw new TypeError(error);
});