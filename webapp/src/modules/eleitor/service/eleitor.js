import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const enviarDadosEleitor = eleitor => service.postRequest('/eleitor', eleitor);
