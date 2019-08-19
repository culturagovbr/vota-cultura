import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */
export const login = usuario => service.postRequest('/conta/auth/login', usuario);

export const logout = usuario => service.getRequest('/conta/auth/logout', usuario);

export const recuperarSenha = usuario => service.postRequest('/conta/recuperacao/senha', usuario);

export const ativarUsuario = ativacao => service.putRequest('/conta/ativar-usuario', ativacao, {});

export const cadastrarUsuario = usuario => service.postRequest('/conta/usuario', usuario);

export const alterarSenha = (codigoAlteracao, usuario) => service.putRequest(
  '/conta/recuperacao/senha',
  codigoAlteracao,
  usuario,
);

export const usuarioAlterarSenha = (coUsuario, usuario) => service.putRequest(
  '/conta/usuario/alteracao/senha',
  coUsuario,
  usuario,
);

export const solicitarPrimeiroAcesso = payload => service.postRequest(
  '/conta/usuario/primeiro-acesso',
  payload,
);
