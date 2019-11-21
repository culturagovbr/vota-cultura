import * as service from '../../shared/service/base/index';
/* eslint-disable import/prefer-default-export */

export const obterFases = () => service.getRequest('/fase');
export const concluirOrganizacaoIndicacao = fase => service.patchRequest('/fase', fase);

