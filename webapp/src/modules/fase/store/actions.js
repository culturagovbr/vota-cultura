import * as faseService from '../service/fase';
import * as types from './types';
import moment from 'moment';

// eslint-disable-next-line import/prefer-default-export
export const obterFases = async ({ commit }) => faseService.obterFases().then((response) => {
  commit(types.OBTER_CRONOGRAMAS, response.data);
  commit(types.DEFINIR_SITUACOES, response.data);
});

export const validarDataDentroPrazoFasePorSlug = async ( { state }, slug ) => {
  const fase = state.fases.find((fase) => fase.tp_fase === slug);

    if (fase.dh_inicio) {
      const dataInicio = moment(fase.dh_inicio).toDate().getTime();
      const dataFim = moment(fase.dh_fim).toDate().getTime();
      const dataAtual = moment().toDate().getTime();

      return !(dataAtual >= dataInicio && dataAtual <= dataFim);
    }
    return true;
};