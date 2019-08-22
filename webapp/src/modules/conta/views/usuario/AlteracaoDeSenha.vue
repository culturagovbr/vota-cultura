<template>
  <v-container
    grid-list-xl
    fluid
  >
    <v-layout
      row
      wrap
    >
      <v-flex lg6>
        <v-card class="mb-4">
          <v-toolbar
            color="primary"
            dark
            flat
            dense
            cad
          >
            <v-toolbar-title class="subheading">
              {{ $route.meta.title }}
            </v-toolbar-title>
            <v-spacer />
          </v-toolbar>
          <v-divider />
          <v-card-text>
            <v-form
              ref="form"
              v-model="valid"
              lazy-validation
            >
              <v-layout
                row
                wrap
              >
                <v-flex
                  lg12
                  sm12
                >
                  <v-text-field
                    id="senha_atual"
                    v-model="usuario.ds_senha_atual"
                    prepend-icon="vpn_key"
                    :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
                    :type="mostrarSenha ? 'text' : 'password'"
                    label="Senha Atual"
                    :rules="[rules.required, rules.minCaracter, rules.senhaValida]"
                    @click:append="mostrarSenha = !mostrarSenha"
                  />
                </v-flex>
              </v-layout>
              <v-layout
                row
                wrap
              >
                <v-flex
                  lg12
                  sm12
                >
                  <v-text-field
                    id="senha"
                    v-model="usuario.ds_senha"
                    prepend-icon="vpn_key"
                    :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
                    :type="mostrarSenha ? 'text' : 'password'"
                    label="Senha"
                    :rules="[rules.required, rules.minCaracter, rules.senhaValida]"
                    @click:append="mostrarSenha = !mostrarSenha"
                  />
                </v-flex>
              </v-layout>
              <v-layout
                row
                wrap
              >
                <v-flex
                  lg12
                  sm12
                >
                  <v-text-field
                    id="confirma_senha"
                    v-model="confirma_senha"
                    prepend-icon="vpn_key"
                    :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
                    :type="mostrarSenha ? 'text' : 'password'"
                    label="Confirmar senha"
                    :rules="[rules.required, rules.confirmaSenha(confirma_senha, usuario.ds_senha)]"
                    @click:append="mostrarSenha = !mostrarSenha"
                  />
                </v-flex>
              </v-layout>
              <v-spacer />
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn
              type="submit"
              :disabled="!valid"
              color="primary"
              :loading="loading"
              @click="alterar"
            >
              Salvar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';
import { obterInformacoesJWT } from '@/modules/shared/service/helpers/jwt';

export default {
  name: 'AlteracaoDeSenha',
  data: () => ({
    loading: false,
    mostrarSenha: false,
    valid: true,
    confirma_senha: '',
    usuario: {
      ds_senha_atual: '',
      ds_senha: '',
    },
    rules: {
      required: value => !!value || 'Este campo é obrigatório',
      minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
      senhaValida: value => Validate.isSenhaValida(value)
        || 'Mínimo uma letra maiúscula, uma minúscula e um número',
      confirmaSenha: (confirmaSenha, dsSenha) => confirmaSenha === dsSenha || 'A senha não confere',
    },
  }),
  methods: {
    ...mapActions({
      alterarSenha: 'conta/usuarioAlterarSenha',
      mensagemErro: 'app/setMensagemErro',
      mensagemSucesso: 'app/setMensagemSucesso',
    }),
    alterar() {
      if (!this.$refs.form.validate()) {
        return;
      }
      this.loading = true;

      const usuarioLogado = obterInformacoesJWT(localStorage.getItem('user_token')).user;

      this.alterarSenha(
        {
          coUsuario: usuarioLogado.co_usuario,
          usuario: this.usuario,
        },
      )
        .then(() => {
          this.mensagemSucesso('Senha alterada com sucesso');
          this.$router.push('/conta/sair');
        })
        .catch((error) => {
          this.loading = false;
          this.mensagemErro(error.response.data.message);
        });
    },
  },
};
</script>
