<template>
  <v-toolbar
    color="green darken-3"
    dark
    app
    clipped-left
  >
    <div class="toolbar-logo theme--dark green darken-4">
      <img
        :src="require('@/core/assets/logo.svg')"
        alt="Logo do Sistema"
        class="ml-3 mt-2"
      >
      <v-toolbar-title class="ml-0 pl-3 mt-2 hidden-sm-and-down">
        <span>{{ appTitle }}</span>
      </v-toolbar-title>
      <v-btn
        class="button-drawer"
        color="green darken-4"
        icon
        @click="handleDrawerToggle"
      >
        <v-icon v-text="drawer ? 'chevron_right' : 'chevron_left'" />
      </v-btn>
    </div>
    <v-spacer />
    <v-toolbar-items>
      <v-btn
        icon
        @click="handleFullScreen()"
      >
        <v-icon>fullscreen</v-icon>
      </v-btn>
    </v-toolbar-items>
    <dialog-confirmacao />
    <dialog-progresso />
  </v-toolbar>
</template>
<script>
import Util from '../util';
import DialogConfirmacao from '../../modules/shared/components/DialogConfirmacao';
import DialogProgresso from '../../modules/shared/components/DialogProgresso';

export default {
  name: 'AppToolbar',
  components: {
    DialogProgresso,
    DialogConfirmacao,
  },
  data() {
    return {
      appTitle: process.env.VUE_APP_TITLE,
      drawer: false,
      items: [
        {
          icon: 'lock',
          name: 'conta-usuario-alterar-senha',
          title: 'Alterar Senha',
        },
        {
          icon: 'fullscreen_exit',
          href: '#',
          title: 'Logout',
          click: this.handleLogout,
        },
      ],
    };
  },
  computed: {
  },
  methods: {
    handleDrawerToggle() {
      this.drawer = !this.drawer;
      this.$emit('side-icon-click');
    },
    handleFullScreen() {
      Util.toggleFullScreen();
    },
    handleLogout() {
      this.$emit('handle-logout-click');
      this.$router.push('/conta/sair');
    },
  },
};
</script>

