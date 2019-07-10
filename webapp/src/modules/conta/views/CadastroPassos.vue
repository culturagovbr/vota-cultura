<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <v-card-title class="title font-weight-regular justify-space-between">
        <span>{{ currentTitle }}</span>
        <v-avatar
          color="primary lighten-2"
          class="subheading white--text"
          size="24"
          v-text="step"
        />
      </v-card-title>

      <v-window v-model="step">
        <v-window-item :value="1">
          <v-card-text>
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
        </v-window-item>

        <v-window-item :value="2">
          <v-card-text>
            <v-text-field
              label="Password"
              type="password"
            />
            <v-text-field
              label="Confirm Password"
              type="password"
            />
            <span class="caption grey--text text--darken-1">
              Please enter a password for your account
            </span>
          </v-card-text>
        </v-window-item>

        <v-window-item :value="3">
          <div class="pa-3 text-xs-center">
            <v-img
              class="mb-3"
              contain
              height="128"
              src="https://cdn.vuetifyjs.com/images/logos/v.svg"
            />
            <h3 class="title font-weight-light mb-2">
              Welcome to Vuetify
            </h3>
            <span class="caption grey--text">Thanks for signing up!</span>
          </div>
        </v-window-item>
      </v-window>
    </v-card-text>
    <div class="login-btn" />
    <v-divider />

    <v-card-actions>
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
      <v-btn
        :disabled="step === 1"
        flat
        @click="step--"
      >
        Back
      </v-btn>
      <v-spacer />
      <v-btn
        :disabled="step === 3"
        color="primary"
        depressed
        @click="step++"
      >
        Next
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';

export default {
  data: () => ({
    loading: false,
    mostrarSenha: false,
    step: 1,
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
  computed: {
    currentTitle() {
      switch (this.step) {
        case 1: return 'Cadastro';
        default: return 'Confirmar e-mail';
      }
    },
  },
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
