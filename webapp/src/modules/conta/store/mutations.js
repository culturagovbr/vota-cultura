import * as types from './types';

export const mutations = {
  [types.DEFINIR_USUARIO](state, dados) {
    state.usuario = dados;
  },
  [types.DEFINIR_PERFIL](state, perfil) {
    state.perfil = perfil;
  },
  [types.AUTENTICAR_USUARIO]() {},
  [types.TRATAR_USUARIO](state, token) {
    state.tokenUsuario = token;
  },
  [types.DEFINIR_DADOS_PRIMEIRO_ACESSO]() {},
  [types.ATIVAR_USUARIO]() {},
  [types.RECUPERAR_SENHA]() {},
  [types.ALTERAR_SENHA_INICIAL]() {},
  [types.ALTERAR_SENHA]() {},
  [types.LOGOUT](state) {
    localStorage.removeItem('token_usuario');
    state.usuario = Object.assign({});
    state.tokenUsuario = String();
  },
  [types.SOLICITAR_PRIMEIRO_ACESSO]() {},
  [types.LISTAR_USUARIOS](state, usuarios) {
    state.usuarios = usuarios;
  },
  [types.BUSCAR_PERFIS]() {},
  [types.DEFINIR_PERFIS](state, perfis) {
    state.perfis = perfis;
  },
  [types.DEFINIR_PERFIS_ALTERACAO](state, perfis) {
    state.perfis = perfis;
  },
  [types.ATRIBUIR_USUARIO_CADASTRADO_LISTA](state, usuario) {
    state.usuarios.push(usuario);
  },
  [types.ATUALIZAR_USUARIO_LISTA](state, usuarioEditado) {
    const index = state.usuarios.findIndex(usuario => usuario.co_usuario === usuarioEditado.co_usuario);
    Object.assign(state.usuarios[index], usuarioEditado);
  },
};
