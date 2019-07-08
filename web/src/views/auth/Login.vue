<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <div class="layout column align-center">
        <h1 class="flex my-4 primary--text">
          {{ appTitle }}
        </h1>
      </div>
      <v-form>
        <v-text-field
          v-model="model.no_cpf"
          append-icon="person"
          name="login"
          label="CPF"
          type="text"
          autocomplete="no_cpf"
        />
        <v-text-field
          id="password"
          v-model="model.ds_senha"
          append-icon="lock"
          name="password"
          label="Senha"
          type="password"
          autocomplete="current-password"
        />
        <v-layout justify-end>
          <a>Recuperar Senha</a>
        </v-layout>
      </v-form>
    </v-card-text>
    <div class="login-btn">
      <v-btn
        block
        color="primary"
        :loading="loading"
        @click="login"
      >
        Login
      </v-btn>
      <v-spacer />
      <v-btn
        block
        color="default"
        :to="{ name: 'cadastro' }"
      >
        Cadastrar-se
      </v-btn>
    </div>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  data: () => ({
    appTitle: process.env.VUE_APP_TITLE,
    loading: false,
    model: {
      no_cpf: '12345678901',
      ds_senha: '123456',
    },
  }),

  methods: {
    ...mapActions({
      autenticarUsuario: 'usuario/autenticarUsuario',
    }),
    login() {
      this.loading = true;
      // handle login

      this.autenticarUsuario(this.model).then((response) => {
        this.$router.push('/');
      }).finally(() => {
        this.loading = false;
      });
    },
  },
};
</script>
<style scoped lang="css"></style>
