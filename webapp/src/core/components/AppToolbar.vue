<template>
  <v-toolbar
    color="primary"
    fixed
    dark
    app
    clipped-left
    flat
  >
    <div class="toolbar-logo theme--dark primary darken-1">
      <img
        :src="require('@/core/assets/logo.svg')"
        alt="Logo do Sistema"
        class="ml-3 mt-2"
      >
      <v-toolbar-title class="ml-0 pl-3 mt-2">
        <span>{{ appTitle }}</span>
      </v-toolbar-title>
      <v-btn
        class="button-drawer"
        color="primary darken-1"
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
      <v-menu
        offset-y
        origin="center center"
        class="elelvation-1"
        :nudge-bottom="14"
        transition="scale-transition"
      >
        <v-btn
          slot="activator"
          icon
          flat
        >
          <v-badge
            color="red"
            overlap
          >
            <span slot="badge">3</span>
            <v-icon medium>
              notifications
            </v-icon>
          </v-badge>
        </v-btn>
        <notification-list />
      </v-menu>
      <v-menu
        offset-y
        origin="center center"
        :nudge-bottom="10"
        transition="scale-transition"
      >
        <v-btn
          slot="activator"
          icon
          large
          flat
        >
          <v-avatar size="30px">
            <img
              src="/static/avatar/avatar_mds.png"
              alt="Michael Wang"
            >
          </v-avatar>
        </v-btn>
        <v-list class="pa-0">
          <v-list-tile
            v-for="(item, index) in items"
            :key="index"
            :to="!item.href ? { name: item.name } : null"
            :href="item.href"
            ripple="ripple"
            :disabled="item.disabled"
            :target="item.target"
            rel="noopener"
            @click="item.click"
          >
            <v-list-tile-action v-if="item.icon">
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ item.title }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar-items>
    <dialog-confirmacao />
    <dialog-progresso />
  </v-toolbar>
</template>
<script>
import NotificationList from '@/core/components/widgets/list/NotificationList';
import Util from '../util';
import DialogConfirmacao from '../../modules/shared/components/DialogConfirmacao';
import DialogProgresso from '../../modules/shared/components/DialogProgresso';

export default {
  name: 'AppToolbar',
  components: {
    DialogProgresso,
    DialogConfirmacao,
    NotificationList,
  },
  data() {
    return {
      appTitle: process.env.VUE_APP_TITLE,
      drawer: false,
      items: [
        {
          icon: 'account_circle',
          href: '#',
          title: 'Perfil',
          click: this.handleProfile,
        },
        {
          icon: 'settings',
          href: '#',
          title: 'Settings',
          click: this.handleSetting,
        },
        {
          icon: 'fullscreen_exit',
          href: '#',
          title: 'Logout',
          click: this.handleLogut,
        },
      ],
    };
  },
  computed: {
    toolbarColor() {
      return this.$vuetify.options.extra.mainNav;
    },
  },
  methods: {
    handleDrawerToggle() {
      this.drawer = !this.drawer;
      this.$emit('side-icon-click');
    },
    handleFullScreen() {
      Util.toggleFullScreen();
    },
    handleLogut() {
      this.$emit('handle-logout-click');
      // handle logout
      this.$router.push('/conta/sair');
    },
    handleSetting() {

    },
    handleProfile() {

    },
  },
};
</script>

<style lang="stylus" scoped>


</style>
