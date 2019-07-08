import * as usuarioService from '@/service/usuario';
import * as types from './types';

/* eslint-disable import/prefer-default-export */
export const autenticarUsuario = async ({ commit }, params) => {
  usuarioService.login(params)
    .then((response) => {
      const { data } = response;
      commit(types.SET_USUARIO, data);
      commit(
        'app/setMensagemSucesso',
        'Login efetuado com sucesso!',
        { root: true },
      );
    }).catch((error) => {
      throw new TypeError(error, 'autenticarUsuario', 10);
    });
};
