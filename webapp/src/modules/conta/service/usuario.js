import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */
export const login = usuario => service.postRequest('/conta/auth/login', usuario);

export const recuperarSenha = usuario => service.postRequest('/auth/recuperar-senha', usuario);

export const ativarUsuario = ativacao => service.putRequest('/conta/ativacao', ativacao, {});

export const cadastrarUsuario = usuario => service.postRequest('/conta/usuario', usuario);
