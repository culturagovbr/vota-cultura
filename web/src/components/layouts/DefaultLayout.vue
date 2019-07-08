<template>
  <v-app
    id="inspire"
    class="app dashboard"
  >
    <app-drawer
      class="app--drawer"
      :show-drawer="showDrawer"
    />
    <app-toolbar
      class="app--toolbar"
      @side-icon-click="handleDrawerVisiable"
    />
    <v-content>
      <!-- Page Header -->
      <page-header />
      <div class="page-wrapper">
        <router-view />
      </div>
      <!-- App Footer -->
      <v-footer
        height="auto"
        class="white pa-3 app--footer"
      >
        <span class="caption">SLI {{ new Date().getFullYear() }}</span>
        <v-spacer />
        <span class="caption mr-1"> Ministério da Cidadania </span>
      </v-footer>
    </v-content>
    <!-- Go to top -->
    <app-fab />
  </v-app>
</template>

<script>
import AppDrawer from '@/components/AppDrawer';
import AppToolbar from '@/components/AppToolbar';
import AppFab from '@/components/AppFab';
import PageHeader from '@/components/PageHeader';

export default {
  components: {
    AppDrawer,
    AppToolbar,
    AppFab,
    PageHeader,
  },

  data() {
    return {
      showDrawer: true,
    };
  },
  created() {},
  methods: {
    handleDrawerVisiable() {
      this.showDrawer = !this.showDrawer;
    },
  },
};
</script>

<style scoped>
.page-wrapper {
  min-height: calc(100vh - 64px - 50px - 81px);
}
</style>
