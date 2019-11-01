<template>
  <v-container>
    <v-card class="elevation-1 pa-3 login-card">
      <v-card-text>
        <div class="layout column align-center">
          <h2 class="flex my-2 primary--text">
            {{ $route.meta.title }}
          </h2>
        </div>
        <mapa v-model="regiao" />
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Mapa from './Mapa';

export default {
  name: 'Votacao',
  components: { Mapa },
  data: () => ({
    regiao: '',
  }),
  watch: {
    regiao(valor) {
      if (!!valor) {
        this.$router.push(`/votacao/${valor}`);
      }
    },
  },
  mounted() {
  },
  computed: {
    ...mapGetters({
    }),
  },
  methods: {
    ...mapActions({
    }),
  },
};
</script>