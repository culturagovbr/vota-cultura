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
          v-model="model.username"
          append-icon="person"
          name="login"
          label="CPF"
          type="text"
          autocomplete="username"
        />
        <v-text-field
          id="password"
          v-model="model.password"
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
      username: '012.345.678.90',
      password: 'password',
    },
  }),

  methods: {
    ...mapActions({
      autenticarUsuario: 'usuario/autenticarUsuario',
    }),
    login() {
      this.loading = true;
      // handle login

      this.autenticarUsuario(this.model).finally(() => {
        this.loading = false;
      });
      // setTimeout(() => {
      //   this.$router.push('/dashboard');
      // }, 1000);
    },
  },
};
</script>
<style scoped lang="css"></style>
