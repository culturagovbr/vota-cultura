import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const consultarCPF = cpf => service.getRequest('/pessoa/fisica/' + cpf);
export const consultarCNPJ = cnpj => service.getRequest('/pessoa/juridica/' + cnpj);
