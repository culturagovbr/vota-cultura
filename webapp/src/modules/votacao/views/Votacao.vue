<template>
  <v-container>
    <v-card class="elevation-1 pa-3 login-card">
      <v-card-text>
        <div class="layout column align-center">
          <h2 class="flex my-2 primary--text">
            {{ $route.meta.title }}
          </h2>
          <h3 class="primary--text">
            Candidatos dos conselhos de cultura
          </h3>
        </div>
        <h3 class="my-2">
          Selecione a região do mapa:
        </h3>
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
        window.location.href = `/votacao/${valor}`;
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