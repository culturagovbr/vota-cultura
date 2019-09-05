import moment from 'moment';
import * as types from './types';

// eslint-disable-next-line import/prefer-default-export
export const mutations = {
  [types.OBTER_CRONOGRAMAS](state, dados) {
    state.fases = dados.data;
  },
  [types.DEFINIR_SITUACOES](state, dados) {
    if (dados.data.length > 0) {
      dados.data.forEach((element) => {
        if (element.dh_inicio) {
          const dataInicio = moment(element.dh_inicio).toDate().getTime();
          const dataFim = moment(element.dh_fim).toDate().getTime();
          const dataAtual = moment().toDate().getTime();
          switch (element.tp_fase) {
            case 'abertura_inscricoes_conselho':
              state.ativarInscricaoConselho = (dataAtual >= dataInicio && dataAtual <= dataFim);
              break;
            case 'abertura_inscricoes_organizacao':
              state.ativarInscricaoOrganizacao = (dataAtual >= dataInicio && dataAtual <= dataFim);
              break;
            case 'abertura_inscricoes_eleitor':
              state.ativarInscricaoEleitor = (dataAtual >= dataInicio && dataAtual <= dataFim);
              break;
            default:
              break;
          }
        }
      });
    }
  },
};
