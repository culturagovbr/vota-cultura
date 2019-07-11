<template>
  <v-card class="elevation-1 pa-3 login-card" :color="type">
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">
          <v-icon v-if="!loading">{{icon}}</v-icon>{{message}}
        </h3>
      </div>
    </v-card-title>
    <v-card-text>
      <card-carregando v-if="loading"></card-carregando>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';
import CardCarregando from '@/modules/shared/components/CardCarregando'

export default {
  data: () => ({
    loading: true,
    type: 'white',
    icon: '',
    message : ''
  }),
  components: {
    CardCarregando,
  },
  created () {
    this.ativarUsuario(this.$route.params.ds_codigo_ativacao).then(() => {
      this.type = 'success';
      this.icon = 'thumb_up';
      this.loading = false;
      this.message = 'Usuário ativado com sucesso';
    }).catch( error => {
      this.type = 'error';
      this.icon = 'thumb_down';
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
