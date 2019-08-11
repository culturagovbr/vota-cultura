import * as types from './types';

// eslint-disable-next-line import/prefer-default-export
export const mutations = {
  [types.OBTER_CRONOGRAMAS](state, dados) {
    state.cronogramas = dados.data;
  },
  [types.DEFINIR_SITUACOES](state, dados) {
    if (dados.data.length > 0) {
      const dataAtual = new Date();
      dados.data.forEach((element) => {
        if (element.dh_inicio) {
          const dataInicio = new Date(element.dh_inicio);
          // let dataFim  = new Date(element.dh_fim);
          if (element.tp_cronograma === 'abertura_inscricoes_conselho'
              && dataAtual.getTime() >= dataInicio.getTime()) {
            state.ativarInscricaoConselho = true;
          }
          if (element.tp_cronograma === 'abertura_inscricoes_organizacao'
              && dataAtual.getTime() >= dataInicio.getTime()) {
            state.ativarInscricaoOrganizacao = true;
          }
          if (element.tp_cronograma === 'abertura_inscricoes_eleitor'
              && dataAtual.getTime() >= dataInicio.getTime()) {
            state.ativarInscricaoEleitor = true;
          }
        }
      });
    }
  },
};
