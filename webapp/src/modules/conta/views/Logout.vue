<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <card-carregando
        v-if="loading"
        text="Aguarde, encerrando a sessão"
      />
      <div
        v-else
        class="text-xs-center"
      >
        <div style="padding: 20px">
          <h4 color="primary">
            Sessão finalizada com sucesso!
          </h4>
          <v-btn
            class="mt-2"
            outline
            block
            color="primary"
            to="/conta/autenticar"
          >
            Fazer login novamente
          </v-btn>
          <v-btn
            class="mt-2"
            block
            color="primary"
            to="/inicio"
          >
            Início
          </v-btn>
        </div>
      </div>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
import CardCarregando from '@/modules/shared/components/CardCarregando';

export default {
  components: { CardCarregando },
  data: () => ({
    appTitle: process.env.VUE_APP_TITLE,
    loading: true,
  }),
  created() {
    this.acionarLogout();
  },
  methods: {
    ...mapActions({
      logout: 'conta/logout',
    }),
    acionarLogout() {
      this.loading = true;
      setTimeout(() => {
        this.loading = false;
        this.logout();
      }, 2000);
    },
  },
};
</script>
