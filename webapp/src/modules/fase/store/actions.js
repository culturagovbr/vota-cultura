import moment from 'moment';
import * as faseService from '../service/fase';
import * as types from './types';

// eslint-disable-next-line import/prefer-default-export
export const obterFases = async ({ commit }) => faseService.obterFases().then((response) => {
  commit(types.OBTER_FASES, response.data);
  commit(types.DEFINIR_SITUACOES, response.data);
});

export const validarDataDentroPrazoFasePorSlug = async ({ state }, slug) => {
  const faseEncontrada = state.fases.find(fase => fase.tp_fase === slug);

  if (faseEncontrada.dh_inicio) {
    const dataInicio = moment(faseEncontrada.dh_inicio).toDate().getTime();
    const dataFim = moment(faseEncontrada.dh_fim).toDate().getTime();
    const dataAtual = moment().toDate().getTime();

    return !(dataAtual >= dataInicio && dataAtual <= dataFim);
  }
  return true;
};
