import * as usuarioService from '../service/usuario';

/* eslint-disable import/prefer-default-export */
export const autenticarUsuario = async ({ dispatch }, usuario) => usuarioService.login(usuario)
  .then((response) => {
    const { data } = response;
    if (data && data.access_token) {
      localStorage.setItem('user_token', data.access_token);
    }

    dispatch(
      'app/setMensagemSucesso',
      'Login efetuado com sucesso!',
      { root: true },
    );
    return data;
  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.error,
      { root: true },
    );
    throw new TypeError(error, 'autenticarUsuario', 10);
  });

// eslint-disable-next-line no-empty-pattern
export const ativarUsuario = async ({}, ativacao) => usuarioService.ativarUsuario(ativacao);

// eslint-disable-next-line no-empty-pattern
export const cadastrarUsuario = async ({}, usuario) => usuarioService.cadastrarUsuario(usuario);

export const recuperarSenha = async ({}, payload) => usuarioService.recuperarSenha(payload);

export const alterarSenha = async (state, { codigoAlteracao, usuario }) => usuarioService.alterarSenha(codigoAlteracao, usuario);

export const usuarioAlterarSenha = async ({}, { coUsuario, usuario }) => usuarioService.usuarioAlterarSenha(coUsuario, usuario);

export const logout = async () => usuarioService.logout({}).then(() => {
  localStorage.removeItem('user_token');
});

export const solicitarPrimeiroAcesso = async (state, payload) => usuarioService.solicitarPrimeiroAcesso(payload);
