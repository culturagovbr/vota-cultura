<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <div class="layout column align-center">
        <h2 class="flex my-2 primary--text">
          {{$route.meta.title}}
        </h2>
      </div>
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
      >
        <v-text-field
          id="senha"
          v-model="usuario.ds_senha"
          prepend-icon="vpn_key"
          :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
          :type="mostrarSenha ? 'text' : 'password'"
          label="Senha"
          name="senha"
          @click:append="mostrarSenha = !mostrarSenha"
          :rules="[rules.required, rules.minCaracter, rules.senhaValida]"
        />
        <v-text-field
          id="confirma_senha"
          v-model="confirma_senha"
          prepend-icon="vpn_key"
          :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
          :type="mostrarSenha ? 'text' : 'password'"
          label="Confirmar senha"
          name="confirma_senha"
          @click:append="mostrarSenha = !mostrarSenha"
          :rules="[rules.confirmaSenha(confirma_senha, usuario.ds_senha)]"
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
        Alterar senha
      </v-btn>
      <v-spacer />
    </div>
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Validate from '@/modules/shared/util/validate';

export default {
  data: () => ({
    loading: false,
    mostrarSenha: false,
    valid: true,
    confirma_senha: '',
    usuario: {
      ds_senha: '',
    },
    rules: {
      required: value => !!value || 'Este campo é obrigatório',
      minCaracter: value => value.length >= 8 || "Mínimo 8 caracteres",
      senhaValida: value =>
        Validate.isSenhaValida(value) ||
        "Mínimo uma letra maiúscula, uma minúscula e um número",
      confirmaSenha: (confirma_senha, ds_senha) =>
        confirma_senha === ds_senha || "A senha não confere"
    },
  }),
  methods: {
    ...mapActions({
      alterarSenha: 'conta/alterarSenha',
      mensagemErro: "app/setMensagemErro"
    }),
    login() {
      if (!this.$refs.form.validate()) {
        return;
      }
      this.loading = true;
      this.alterarSenha(this.$route.params.ds_codigo_ativacao, this.usuario).then(() => {
        this.$router.push('/');
      }).catch((error) => {
        this.loading = false;
        this.mensagemErro(error.response.data.message);
      });
    },
  },
};
</script>
