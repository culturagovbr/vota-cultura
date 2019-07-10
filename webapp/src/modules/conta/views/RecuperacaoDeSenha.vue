<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <div class="layout column align-center">
        <h2 class="flex my-2 primary--text">
          Recuperar senha
        </h2>
      </div>
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
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
      </v-form>
    </v-card-text>
    <div class="login-btn">
      <v-btn
        type="submit"
        :disabled="!valid"
        block
        color="primary"
        :loading="loading"
        @click="login"
      >
        Recuperar
      </v-btn>
      <v-spacer />
      <v-layout
        row
        class="py-3"
      >
        <v-flex
          sm6
          style="text-align: left"
        >
          <router-link
            class="subheading"
            to="login"
            color="primary"
          >
            Voltar
          </router-link>
        </v-flex>
        <v-flex
          sm6
          style="text-align: right"
        >
          <router-link
            class="subheading"
            to="cadastro"
            color="primary"
          >
            Cadastrar-se
          </router-link>
        </v-flex>
      </v-layout>
    </div>
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
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
  computed: {
    ...mapGetters({
      usuario: 'usuario/getUsuario',
    }),
  },
  methods: {
    ...mapActions({
      recuperarSenha: 'usuario/recuperarSenha',
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
