import * as service from './base/index';

export const login = usuario => service.postRequest('/auth/user', usuario);
