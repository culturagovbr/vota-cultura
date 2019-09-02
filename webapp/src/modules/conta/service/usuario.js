import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */
export const login = usuario => service.postRequest('/conta/auth/login', usuario);

export const logout = usuario => service.getRequest('/conta/auth/logout', usuario);


export const ativarUsuario = ativacao => service.putRequest('/conta/ativar-usuario', ativacao, {});

export const cadastrarUsuario = usuario => service.postRequest('/conta/usuario', usuario);

export const alterarSenha = (codigoAlteracao, payload) => service.putRequest(
  '/conta/alterar-senha-recuperada',
  codigoAlteracao,
  payload,
);

export const usuarioAlterarSenha = (coUsuario, usuario) => service.putRequest(
  '/conta/usuario/alteracao/senha',
  coUsuario,
  usuario,
);

export const solicitarPrimeiroAcesso = payload => service.postRequest(
  '/conta/primeiro-acesso',
  payload,
);

export const recuperarSenha = payload => service.postRequest(
  '/conta/recuperar-senha',
  payload,
);

export const obterUsuarios = () => service.getRequest('/conta/administrador/usuario');
