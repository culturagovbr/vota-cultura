import * as types from './types';

export const state = {
  estadosGetter: {},
};

export const mutations = {
  [types.OBTER_ESTADOS](state, dados) {
    state.estadosGetter = dados.data;
  },
};
