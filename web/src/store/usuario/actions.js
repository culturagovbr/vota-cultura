import * as usuarioService from '@/service/usuario';
import * as types from './types';

/* eslint-disable import/prefer-default-export */
export const autenticarUsuario = async ({ commit, dispatch }, params) => usuarioService.login(params)
  .then((response) => {
    const { data } = response;
    if (data && data.access_token) {
      localStorage.setItem('user_token', data.access_token);
    }

    // commit(types.SET_USUARIO, data);
    dispatch(
      'app/setMensagemSucesso',
      'Login efetuado com sucesso!',
      { root: true },
    );
    return data;
  }).catch((error) => {
    throw new TypeError(error, 'autenticarUsuario', 10);
  });
