import colors from 'vuetify/es5/util/colors';

const state = {
  mode: 'light',
  themeColor: process.env.VUE_APP_THEME_DEFAULT,
  snackbar: {
    show: false,
    text: '',
    color: 'success',
    timeout: 6000,
  },
};

const getters = {
  getThemeColor: state => colors[state.themeColor].base,
  snackbar: state => state.snackbar,
  mode: state => state.mode,
};

const actions = {
  setSnackbar({ commit }, params) {
    commit('setSnackBar', params);

    setTimeout(() => {
      commit('setSnackBar', {
        show: false,
      });
    }, state.snackbar.timeout, state);
  },
  setMensagemErro({ commit, state }, message) {
    commit('setSnackBar', {
      show: true,
      color: 'error',
      text: message,
    });

    setTimeout(() => {
      commit('setSnackBar', {
        show: false,
      });
    }, state.snackbar.timeout, state);
  },
  setMensagemSucesso({ commit }, message) {
    commit('setSnackBar', {
      show: true,
      color: 'success',
      text: message,
    });
  },
  setMensagemInfo({ commit }, message) {
    commit('setSnackBar', {
      show: true,
      color: 'info',
      text: message,
    });
  },
};

const mutations = {
  setThemeColor(state, payload) {
    state.themeColor = payload;
  },
  setSnackBar(state, payload) {
    state.snackbar = Object.assign({}, state.snackbar, payload);
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
