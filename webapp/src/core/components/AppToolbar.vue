<template>
  <v-toolbar
    color="green darken-3"
    dark
    app
    clipped-left
  >
    <div class="toolbar-logo theme--dark green darken-4">
      <v-toolbar-side-icon @click="handleDrawerToggle" />
      <router-link to="/inicio">
        <img
          :src="require('../../assets/logo-cnpc-novo-site.png')"
          alt="Logo do Sistema"
        >
      </router-link>
    </div>
    <v-toolbar-title class="ml-0 pl-3 mt-2 hidden-sm-and-down">
      <span class="flex headline font-weight-medium">{{ appTitle }}</span>
    </v-toolbar-title>
    <v-spacer />
    <span
      @click=""
      class="subheading font-weight-medium">
      Olá Fulano
    </span>
    <v-toolbar-items>
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
            <v-icon>account_circle</v-icon>

            <!--<img-->
              <!--src="/static/avatar/avatar_mds.png"-->
              <!--alt="Michael Wang"-->
            <!--&gt;-->
          </v-avatar>
        </v-btn>
        <v-list class="pa-0">
          <v-list-tile
            v-for="(item, index) in items"
            :key="index"
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
  </v-toolbar>
</template>
<script>

export default {
  name: 'AppToolbar',

  data() {
    return {
      appTitle: process.env.VUE_APP_TITLE,
      items: [
        {
          icon: 'lock',
          href: '',
          title: 'Alterar Senha',
          click: this.handleChangePassword,
        },
        {
          icon: 'exit_to_app',
          href: '',
          title: 'Logout',
          click: this.handleLogut,
        },
      ],
    };
  },
  methods: {
    handleDrawerToggle() {
      this.drawer = !this.drawer;
      this.$emit('side-icon-click');
    },

    handleChangePassword() {
      this.$router.push({ name: 'conta-usuario-alterar-senha' });
    },
    handleLogut() {
      this.$router.push({ name: 'conta-sair' });
    },
  },
};
</script>