import * as types from './types';

export const mutations = {
  [types.DEFINIR_PESSOA_FISICA](state, pessoaFisica){
    state.pessoaFisica = pessoaFisica;
  },
  [types.DEFINIR_PESSOA_JURIDICA](state, pessoaJuridica){
    state.pessoaJuridica = pessoaJuridica;
  },
};
