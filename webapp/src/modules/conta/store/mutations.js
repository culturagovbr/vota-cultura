import * as types from './types';

export const mutations = {
  [types.DEFINIR_USUARIO](state, dados) {
    state.usuario = dados;
  },
  [types.AUTENTICAR_USUARIO]() {},
  [types.TRATAR_USUARIO](state, token) {
    state.tokenUsuario = token;
  },
  [types.DEFINIR_DADOS_PRIMEIRO_ACESSO]() {},
  [types.ATIVAR_USUARIO]() {},
  [types.CADASTRAR_USUARIO](state, dados) {
    state.usuario = dados;
  },
  [types.RECUPERAR_SENHA]() {},
  [types.ALTERAR_SENHA_INICIAL]() {},
  [types.ALTERAR_SENHA]() {},
  [types.LOGOUT](state) {
    state.usuario = Object.assign({});
    state.tokenUsuario = '';
  },
  [types.SOLICITAR_PRIMEIRO_ACESSO]() {},
};
