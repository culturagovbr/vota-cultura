<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <card-carregando v-if="loading" />
      <div
        v-if="!loading"
        class="text-xs-center"
      >
        <v-icon
          size="80px"
          color="primary"
        >
          {{ icon }}
        </v-icon>
        <h3 class="title font-weight-light mb-2">
          {{ message }}
        </h3>
      </div>
    </v-card-text>
    <v-btn
      block
      color="primary"
      :to="{ name: 'conta-autenticar' }"
    >
      Login
    </v-btn>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';
import CardCarregando from '@/modules/shared/components/CardCarregando';

export default {
  components: {
    CardCarregando,
  },
  data: () => ({
    loading: true,
    type: 'white',
    icon: '',
    message: '',
  }),
  created() {
    this.ativarUsuario(this.$route.params.ds_codigo_ativacao).then(() => {
      this.icon = 'check_circle';
      this.loading = false;
      this.message = 'Usuário ativado com sucesso';
    }).catch((error) => {
      this.icon = 'error';
      this.loading = false;
      this.message = error.response.data.message;
    });
  },
  methods: {
    ...mapActions({
      ativarUsuario: 'conta/ativarUsuario',
    }),
  },
};
</script>
