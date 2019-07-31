import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const cadastrarEleitor = eleitor => service.postRequest('/eleitor', eleitor);
