<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <div class="layout column align-center">
        <h1 class="flex my-4 primary--text">SLI</h1>
      </div>
      <v-form>
        <v-text-field
          append-icon="person"
          name="login"
          label="Login"
          type="text"
          v-model="model.username"
        ></v-text-field>
        <v-text-field
          append-icon="lock"
          name="password"
          label="Password"
          id="password"
          type="password"
          v-model="model.password"
        ></v-text-field>
        <v-layout justify-end>
          <a>Recuperar Senha</a>
        </v-layout>
      </v-form>
    </v-card-text>
    <div class="login-btn">
      <v-btn block color="primary" @click="login" :loading="loading">Login</v-btn>
      <v-spacer></v-spacer>
      <v-btn block color="default">Cadastrar-se</v-btn>
    </div>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    loading: false,
    model: {
      username: '012.345.678.90',
      password: 'password',
    },
  }),

  methods: {
    login() {
      this.loading = true;
      // handle login
      setTimeout(() => {
        this.$router.push('/dashboard');
      }, 1000);
    },
  },
};
</script>
<style scoped lang="css"></style>
