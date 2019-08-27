import * as types from './types';
import moment from 'moment'

// eslint-disable-next-line import/prefer-default-export
export const mutations = {
  [types.OBTER_CRONOGRAMAS](state, dados) {
    state.cronogramas = dados.data;
  },
  [types.DEFINIR_SITUACOES](state, dados) {
    if (dados.data.length > 0) {
      dados.data.forEach((element) => {
        if (element.dh_inicio) {
          const dataInicio = moment(element.dh_inicio).toDate().getTime()
          const dataAtual = moment().toDate().getTime();
          if (element.tp_cronograma === 'abertura_inscricoes_conselho'
              && dataAtual >= dataInicio) {
            state.ativarInscricaoConselho = true;
          }
          if (element.tp_cronograma === 'abertura_inscricoes_organizacao'
              && dataAtual >= dataInicio) {
            state.ativarInscricaoOrganizacao = true;
          }
          if (element.tp_cronograma === 'abertura_inscricoes_eleitor'
              && dataAtual >= dataInicio) {
            state.ativarInscricaoEleitor = true;
          }
        }
      });
    }
  },
};
