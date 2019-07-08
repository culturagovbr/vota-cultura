import * as service from './base/index';
/* eslint-disable import/prefer-default-export */
export const login = usuario => service.postRequest('/auth/user', usuario);
