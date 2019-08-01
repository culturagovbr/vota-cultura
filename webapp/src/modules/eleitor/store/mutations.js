import * as types from './types';

export const state = {
  dadosInscricaoEleitor: {},
};

export const mutations = {
  [types.DADOS_ELEITOR](state, dadosInscricaoEleitor){
    state.dadosInscricaoEleitor = dadosInscricaoEleitor;
  },
};
