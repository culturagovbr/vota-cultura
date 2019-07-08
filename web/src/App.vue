<template>
  <div class="app-root">
    <router-view></router-view>
    <!-- theme setting -->
    <v-btn small fab dark falt fixed top="top" right="right" class="setting-fab" color="red" @click="openThemeSettings">
      <v-icon>settings</v-icon>
    </v-btn>
    <!-- setting drawer -->
    <v-navigation-drawer class="setting-drawer" temporary right v-model="rightDrawer" hide-overlay fixed>
      <theme-settings></theme-settings>
    </v-navigation-drawer>

    <!-- global snackbar -->
    <v-snackbar :timeout="snackbar.timeout" bottom right :color="snackbar.color" :value="snackbar.show">
      {{ snackbar.text }}
      <v-btn dark flat @click.native="snackbar.show = false" icon>
        <v-icon>close</v-icon>
      </v-btn>
    </v-snackbar>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import ThemeSettings from '@/components/ThemeSettings';
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
  created() {
    const self = this;
    eventHub.$on('eventoErro', (payload) => {
      self.notificarErro(payload);
    });
  },
  computed: {
    ...mapGetters({
      snackbar: 'app/snackbar',
    }),
  },
  methods: {
    ...mapActions({
      notificarErro: 'app/setMensagemErro',
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
}
</style>
