<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <div class="layout column align-center">
        <h2 class="flex my-2 primary--text">
          {{ $route.meta.title }}
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
          :rules="[rules.required, rules.minCaracter, rules.senhaValida]"
          @click:append="mostrarSenha = !mostrarSenha"
        />
        <v-text-field
          id="confirma_senha"
          v-model="confirma_senha"
          prepend-icon="vpn_key"
          :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
          :type="mostrarSenha ? 'text' : 'password'"
          label="Confirmar senha"
          name="confirma_senha"
          :rules="[rules.confirmaSenha(confirma_senha, usuario.ds_senha)]"
          @click:append="mostrarSenha = !mostrarSenha"
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
        @click="alterar"
      >
        Alterar senha
      </v-btn>
      <v-spacer />
    </div>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
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
      minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
      senhaValida: value => Validate.isSenhaValida(value)
        || 'É necessário conter uma letra maiúscula e um número',
      confirmaSenha: (confirmaSenha, dsSenha) => confirmaSenha === dsSenha || 'A senhas não conferem',
    },
  }),
  methods: {
    ...mapActions({
      alterarSenha: 'conta/alterarSenha',
      mensagemErro: 'app/setMensagemErro',
      mensagemSucesso: 'app/setMensagemSucesso',
    }),
    alterar() {
      if (!this.$refs.form.validate()) {
        return;
      }
      this.loading = true;
      this.alterarSenha({
        codigoAlteracao: this.$route.params.ds_codigo_ativacao,
        usuario: this.usuario,
      }).then(() => {
        this.mensagemSucesso('Senha criada com sucesso');
        this.$router.push('/conta/autenticar');
      }).catch((error) => {
        this.loading = false;
        this.mensagemErro(error.response.data.message);
        this.$router.push('/');
      });
    },
  },
};
</script>
