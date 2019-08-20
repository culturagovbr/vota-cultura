<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-window v-model="step">
      <v-window-item :value="1">
        <v-card-title>
          <div class="layout column align-center">
            <h2 class="flex my-2 primary--text">
              {{ $route.meta.title }}
            </h2>
          </div>
        </v-card-title>
        <v-card-text>
          <v-form
            ref="form"
            v-model="formularioValido"
            lazy-validation
          >
            <v-card>
              <v-tabs
                v-model="dadosRecuperacao.tp_inscricao"
                color="white"
                centered
                icons-and-text
              >
                <v-tabs-slider />

                <v-tab href="#organizacao">
                  Organização e Entidade
                  <v-icon>color_lens</v-icon>
                </v-tab>

                <v-tab href="#conselho">
                  Conselho
                  <v-icon>group</v-icon>
                </v-tab>

                <v-tab href="#eleitor">
                  Eleitor
                  <v-icon>thumbs_up_down</v-icon>
                </v-tab>
              </v-tabs>

              <v-tabs-items v-model="dadosRecuperacao.tp_inscricao">
                <v-tab-item value="organizacao">
                  <v-card flat>
                    <v-card-text>
                      <v-text-field
                        v-model="dadosRecuperacao.nu_cnpj"
                        label="CNPJ"
                        prepend-icon="people"
                        mask="##.###.###/####-##"
                        :rules="[rules.required, rules.CNPJValido]"
                        required
                      />
                      <v-text-field
                        v-model="dadosRecuperacao.nu_cpf"
                        prepend-icon="account_circle"
                        name="login"
                        label="CPF"
                        mask="###.###.###-##"
                        validate-on-blur
                        type="text"
                        :rules="[rules.required, rules.CPFValido]"
                        required
                      />
                    </v-card-text>
                  </v-card>
                </v-tab-item>
                <v-tab-item value="conselho">
                  <v-card flat>
                    <v-card-text>
                      <v-text-field
                        v-model="dadosRecuperacao.nu_cnpj"
                        label="CNPJ"
                        prepend-icon="people"
                        mask="##.###.###/####-##"
                        :rules="[rules.required, rules.CNPJValido]"
                        required
                      />
                      <v-text-field
                        v-model="dadosRecuperacao.nu_cpf"
                        prepend-icon="account_circle"
                        name="login"
                        label="CPF"
                        mask="###.###.###-##"
                        validate-on-blur
                        type="text"
                        :rules="[rules.required, rules.CPFValido]"
                        required
                      />
                    </v-card-text>
                  </v-card>
                </v-tab-item>
                <v-tab-item value="eleitor">
                  <v-card flat>
                    <v-card-text>
                      <v-text-field
                        v-model="dadosRecuperacao.nu_cpf"
                        prepend-icon="account_circle"
                        name="login"
                        label="CPF"
                        mask="###.###.###-##"
                        validate-on-blur
                        type="text"
                        :rules="[rules.required, rules.CPFValido]"
                        required
                      />
                    </v-card-text>
                  </v-card>
                </v-tab-item>
              </v-tabs-items>
            </v-card>
          </v-form>
        </v-card-text>
        <div class="login-btn">
          <v-btn
            type="submit"
            :disabled="!formularioValido"
            block
            color="primary"
            :loading="loading"
            @click="recuperar"
          >
            Recuperar
          </v-btn>
          <v-spacer />
          <v-btn
            block
            color="default"
            to="/"
          >
            Voltar
          </v-btn>
        </div>
      </v-window-item>
      <v-window-item :value="2">
        <v-card-text>
          <div class="text-xs-center">
            <v-icon
              size="80px"
              color="primary"
            >
              check_circle
            </v-icon>
            <h3
              class="title font-weight-light mb-2"
            >
              Solicitação para alterar senha realizada com sucesso
            </h3>
            <span
              class="caption grey--text"
            >Um link para criação de uma nova senha foi enviado para o e-mail do responsável pelo cadastro.</span>
          </div>
        </v-card-text>
        <v-btn
          block
          color="primary"
          to="/"
        >
          Login
        </v-btn>
      </v-window-item>
    </v-window>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';

export default {
  data: () => ({
    dadosRecuperacao: {
      nu_cpf: '',
      nu_cnpj: '',
      tp_inscricao: null,
    },
    loading: false,
    mostrarSenha: false,
    formularioValido: true,
    step: 1,
    rules: {
      required: value => !!value || 'Este campo é obrigatório',
      CPFValido: value => Validate.isCpfValido(value) || 'CPF inválido',
      CNPJValido: value => Validate.isCnpjValido(value) || 'CNPJ inválido',
    },
  }),
  mounted() {
  },
  methods: {
    ...mapActions({
      recuperarSenha: 'conta/recuperarSenha',
      mensagemErro: 'app/setMensagemErro',
    }),
    recuperar() {
      if (!this.$refs.form.validate()) {
        return;
      }
      this.loading = true;

      this.recuperarSenha(this.dadosRecuperacao)
        .then(() => {
          this.step = 2;
        })
        .catch((error) => {
          this.loading = false;
          this.mensagemErro(error.response.data.message);
        });
    },
  },
};
</script>
