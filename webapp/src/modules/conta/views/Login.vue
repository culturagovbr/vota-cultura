<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <div class="layout column align-center">
        <h1 class="flex my-4 primary--text">
          {{ appTitle }}
        </h1>
      </div>
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
        @submit.prevent="login"
      >
        <v-text-field
          v-model="model.nu_cpf"
          append-icon="person"
          name="login"
          label="CPF"
          mask="###.###.###-##"
          validate-on-blur
          type="text"
          :rules="[rules.required, rules.validarCPF]"
          autocomplete="nu_cpf"
        />
        <v-text-field
          id="password"
          v-model="model.ds_senha"
          :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
          :type="mostrarSenha ? 'text' : 'password'"
          label="Senha"
          :rules="[rules.required]"
          name="password"
          autocomplete="current-password"
          @click:append="mostrarSenha = !mostrarSenha"
        />
        <v-layout justify-end>
          <router-link to="recuperar-senha">
            Esqueceu a senha?
          </router-link>
        </v-layout>
        <div class="login-btn">
          <v-btn
            type="submit"
            color="primary"
            block
            :disabled="!valid"
            :loading="loading"
            @click="login"
          >
            Entrar
          </v-btn>
          <v-spacer />
          <v-btn
            block
            color="default"
            to="/conta/primeiro-acesso"
          >
            Criar login de Acesso
          </v-btn>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';

export default {
  data: () => ({
    appTitle: process.env.VUE_APP_TITLE,
    loading: false,
    mostrarSenha: false,
    valid: true,
    model: {
      nu_cpf: '',
      ds_senha: '',
    },
    rules: {
      required: value => !!value || 'Este campo é obrigatório',
      validarCPF: value => Validate.isCpfValido(value) || 'CPF inválido',
    },
  }),
  methods: {
    ...mapActions({
      autenticarUsuario: 'conta/autenticarUsuario',
    }),
    login() {
      if (!this.$refs.form.validate()) {
        return;
      }
      this.loading = true;
      this.autenticarUsuario(this.model).then(() => {
        this.$router.push('/');
      }).finally(() => {
        this.loading = false;
      });
    },
  },
};
</script>
