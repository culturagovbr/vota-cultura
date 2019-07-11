import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */
export const login = usuario => service.postRequest('/conta/auth/login', usuario);

export const recuperarSenha = usuario => service.postRequest('/auth/recuperar-senha', usuario);
