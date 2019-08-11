import * as types from './types';

export const state = {
  eleitor: {},
};

export const mutations = {
  [types.DEFINIR_ELEITOR](state, eleitor){
    state.eleitor = eleitor;
  },
};
