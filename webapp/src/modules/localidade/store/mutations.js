import * as types from './types';

export const state = {
  estados: [],
  municipios: [],
};

export const mutations = {
  [types.OBTER_ESTADOS](state, dados) {
    state.estados = dados.data;
  },
  [types.OBTER_MUNICIPIOS](state, dados) {
    state.municipios = dados.data;
  },
};
