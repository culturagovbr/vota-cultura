<template>
  <div class="app-root">
    <router-view />
    <!-- theme setting -->
    <v-btn
      small
      fab
      dark
      falt
      fixed
      top="top"
      right="right"
      class="setting-fab"
      color="red"
      @click="openThemeSettings"
    >
      <v-icon>settings</v-icon>
    </v-btn>
    <!-- setting drawer -->
    <v-navigation-drawer
      v-model="rightDrawer"
      class="setting-drawer"
      temporary
      right
      hide-overlay
      fixed
    >
      <theme-settings />
    </v-navigation-drawer>

    <!-- global snackbar -->
    <v-snackbar
      bottom
      right
      :color="snackbar.color"
      :value="snackbar.show"
    >
      {{ snackbar.text }}
      <v-btn
        dark
        flat
        icon
        @click.native="snackbar.show = false"
      >
        <v-icon>close</v-icon>
      </v-btn>
    </v-snackbar>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import ThemeSettings from '@/core/components/ThemeSettings';
import { eventHub } from './event';


export default {
  components: {
    ThemeSettings,
  },
  data() {
    return {
      rightDrawer: false,
    };
  },
  computed: {
    ...mapGetters({
      snackbar: 'app/snackbar',
    }),
  },
  created() {
    const self = this;
    eventHub.$on('eventoErro', (payload) => {
      self.setMensagemErro({ text: payload });
    });
    eventHub.$on('eventoSucesso', (payload) => {
      self.setMensagemSucesso({ text: payload });
    });
  },
  methods: {
    ...mapActions({
      setMensagemErro: 'app/setMensagemErro',
      setMensagemSucesso: 'app/setMensagemSucesso',
    }),
    openThemeSettings() {
      this.$vuetify.goTo(0);
      this.rightDrawer = !this.rightDrawer;
    },
  },
};
</script>

<style scoped>
.setting-fab {
  top: 50% !important;
  right: 0;
  border-radius: 0;
  display: none;
}
</style>
