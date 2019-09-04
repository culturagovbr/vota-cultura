import { remove, includes } from 'lodash';
import * as usuarioService from '../service/usuario';
import * as types from './types';
import { obterInformacoesJWT } from '../../shared/service/helpers/jwt';

/* eslint-disable import/prefer-default-export */
export const autenticarUsuario = async ({ commit, dispatch }, usuario) => {
  commit(types.AUTENTICAR_USUARIO);
  usuarioService.login(usuario)
    .then((response) => {
      const { data } = response;
      if (data && data.access_token) {
        localStorage.setItem('token_usuario', data.access_token);
      }

      dispatch(
        'app/setMensagemSucesso',
        'Login efetuado com sucesso!',
        { root: true },
      );
      dispatch('conta/tratarUsuarioLogado', null, { root: true });

      return data;
    }).catch((error) => {
      dispatch(
        'app/setMensagemErro',
        error.response.data.error,
        { root: true },
      );
      throw new TypeError(error, 'autenticarUsuario', 10);
    });
};

export const tratarUsuarioLogado = ({ commit, state }) => {
  commit(types.TRATAR_USUARIO, localStorage.getItem('token_usuario'));
  const informacoesToken = obterInformacoesJWT(localStorage.getItem('token_usuario'));
  if (informacoesToken.user && Object.keys(state.usuario).length < 1) {
    const { perfil } = informacoesToken.user;
    if (Object.keys(perfil).length > 0) {
      commit(types.DEFINIR_PERFIL, perfil);
      delete informacoesToken.user.perfil;
    }
    commit(types.DEFINIR_USUARIO, informacoesToken.user);
  }
};

export const ativarUsuario = async ({ commit }, ativacao) => {
  commit(types.ATIVAR_USUARIO, ativacao);
  usuarioService.ativarUsuario(ativacao);
};

export const cadastrarUsuario = async ({ commit }, usuario) => {
  commit(types.CADASTRAR_USUARIO, usuario);
  usuarioService.cadastrarUsuario(usuario);
};

export const recuperarSenha = async ({ commit }, payload) => {
  commit(types.RECUPERAR_SENHA, payload);
  return usuarioService.recuperarSenha(payload);
};

export const usuarioAlterarSenha = async ({ commit }, { coUsuario, usuario }) => {
  commit(types.ALTERAR_SENHA, { coUsuario, usuario });
  usuarioService.usuarioAlterarSenha(
    coUsuario,
    usuario,
  );
};

export const logout = async ({ commit }) => {
  commit(types.LOGOUT, {});
  usuarioService.logout({}).then(() => {
    localStorage.removeItem('token_usuario');
  });
};

export const alterarSenha = async (state, { codigoAlteracao, usuario }) => {
  usuarioService.alterarSenha(codigoAlteracao, usuario);
};

export const solicitarPrimeiroAcesso = async ({ commit }, payload) => {
  commit(types.SOLICITAR_PRIMEIRO_ACESSO, payload);
  usuarioService.solicitarPrimeiroAcesso(payload);
};

export const buscarUsuariosPerfis = async ({ commit }) => {
  usuarioService.obterUsuarios().then((response) => {
    const {data} = response.data;
    commit(types.LISTAR_USUARIOS, data);
  });
};

export const buscarPerfis = async ({ commit }) => {
  commit(types.BUSCAR_PERFIS);
  return usuarioService.obterPerfis().then((response) => {
    const {data} = response.data;
    commit(types.DEFINIR_PERFIS, data);
    return response;
  });
};

export const buscarPerfisAlteracao = async ({ commit, dispatch }) => {

  return dispatch('buscarPerfis').then((response) => {
    const {data} = response.data;
    const elementosRemover = [
        'conselho',
        'organizacao',
        'eleitor',
    ];

    const novoResultado = remove(data, perfil => !includes(elementosRemover, perfil.no_perfil));
    commit(types.DEFINIR_PERFIS_ALTERACAO, novoResultado);
    return response;
  });
};