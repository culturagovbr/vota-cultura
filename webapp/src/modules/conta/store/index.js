import * as actions from './actions';
import * as getters from './getters';
import { mutations, state } from './mutations';


export default {
  namespaced: true,
  actions,
  state,
  getters,
  mutations,
};
