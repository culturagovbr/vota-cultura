import * as eleitorService from '../service/eleitor';
import * as types from './types';
// import * as usuarioService from '../../conta/service/usuario';

// eslint-disable-next-line no-empty-pattern
export const enviarDadosEleitor = async ({ commit }, eleitor) => {
  commit(types.ENVIAR_DADOS_ELEITOR);
  commit(types.DEFINIR_ELEITOR, {});
  return eleitorService.enviarDadosEleitor(eleitor);
};

export const confirmarEleitor = async ({ commit }, eleitor) => {
  commit(types.CONFIRMAR_ELEITOR);
  commit(types.DEFINIR_ELEITOR, eleitor);
};

export const obterDadosEleitor = async ({ commit, dispatch }, coEleitor) => {
  commit(types.OBTER_DADOS_ELEITOR, coEleitor);
  eleitorService.obterDadosEleitor(coEleitor)
    .then((response) => {
      const { data } = response.data;
      if (!data) {
        const error = 'Não foi possível obter os dados do eleitor.';
        throw error;
      }
      commit(types.DEFINIR_ELEITOR, data);
      return data;
    })
    .catch((error) => {
      dispatch(
        'app/setMensagemErro',
        { text: error.response.data.error },
        { root: true },
      );
      throw new TypeError(error, 'obterDadosEleitor', 10);
    });
};
