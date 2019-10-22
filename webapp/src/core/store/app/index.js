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

const definirMensagem = ({ commit, state }, { text, color, callbackAfterHide }) => {
  commit('definirSnackBar', {
    show: true,
    color,
    text,
  });

  setTimeout(() => {
    commit('definirSnackBar', {
      show: false,
    });
    if (callbackAfterHide) {
      callbackAfterHide.call(this);
    }
  }, state.snackbar.timeout, state);
};

const actions = {
  setMensagemErro({ commit, state }, { text, callbackAfterHide }) {
    definirMensagem(
      { commit, state },
      {
        text,
        color: 'error',
        callbackAfterHide,
      },
    );
  },
  setMensagemSucesso({ commit, state }, { text, callbackAfterHide }) {
    definirMensagem(
      { commit, state },
      {
        text,
        color: 'success',
        callbackAfterHide,
      },
    );
  },
  setMensagemInfo({ commit, state }, { text, callbackAfterHide }) {
    definirMensagem(
      { commit, state },
      {
        text,
        color: 'info',
        callbackAfterHide,
      },
    );
  },
};

const mutations = {
  setThemeColor(state, payload) {
    state.themeColor = payload;
  },
  definirSnackBar(state, payload) {
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
