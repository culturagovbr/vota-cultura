<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <div class="layout column align-center">
        <h2 class="flex my-2 primary--text">
          Cadastro
        </h2>
      </div>
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
        autocomplete="off"
      >
        <v-text-field
          v-model="model.no_cpf"
          prepend-icon="account_circle"
          name="login"
          label="CPF"
          mask="###.###.###-##"
          validate-on-blur
          type="text"
          :rules="[rules.required, rules.validarCPF]"
        />
        <v-text-field
          v-model="model.no_nome"
          prepend-icon="person"
          name="nome"
          label="Nome completo"
          validate-on-blur
          type="text"
          :rules="[rules.required]"
        />
        <v-text-field
          v-model="model.dt_nascimento"
          prepend-icon="date_range"
          name="nome"
          label="Data Nascimento"
          validate-on-blur
          type="text"
          :rules="[rules.required]"
        />
        <v-text-field
          v-model="model.no_email"
          prepend-icon="mail_outline"
          name="no_email"
          label="E-mail"
          validate-on-blur
          type="text"
          :rules="[rules.required]"
        />
        <v-text-field
          v-model="model.confirm_email"
          prepend-icon="mail_outline"
          name="confirmacao_email"
          label="Confirmar e-mail"
          validate-on-blur
          type="text"
          :rules="[rules.required]"
        />
        <v-text-field
          id="password"
          v-model="model.ds_senha"
          prepend-icon="vpn_key"
          :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
          :type="mostrarSenha ? 'text' : 'password'"
          label="Senha"
          name="password"
          @click:append="mostrarSenha = !mostrarSenha"
        />
        <v-text-field
          id="confirm_password"
          v-model="model.confirma_senha"
          prepend-icon="vpn_key"
          :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
          :type="mostrarSenha ? 'text' : 'password'"
          label="Confirmar senha"
          name="confirm_password"
          @click:append="mostrarSenha = !mostrarSenha"
        />
      </v-form>
      <span class="grey--text">Todos os campos são obrigatórios </span>
    </v-card-text>
    <div class="login-btn">
      <v-btn
        :disabled="!valid"
        block
        color="primary"
        :loading="loading"
        @click="login"
      >
        Cadastrar
      </v-btn>
      <v-spacer />
      <v-btn
        block
        color="default"
        :to="{ name: 'login' }"
      >
        Voltar
      </v-btn>
    </div>
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
      no_cpf: '',
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
