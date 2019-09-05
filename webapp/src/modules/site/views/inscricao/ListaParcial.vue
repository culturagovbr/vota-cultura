<template>
  <div>
    <v-card class="elevation-1 pa-4 login-card">
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
              v-model="dadosPrimeiroAcesso.tp_inscricao"
              color="white"
              centered
              icons-and-text
            >
              <v-tabs-slider />

              <v-tab href="#organizacao">
                Organização ou Entidade
                <v-icon>color_lens</v-icon>
              </v-tab>

              <v-tab href="#conselho">
                Conselho
                <v-icon>group</v-icon>
              </v-tab>
            </v-tabs>

            <v-tabs-items v-model="dadosPrimeiroAcesso.tp_inscricao">
              <v-tab-item value="organizacao">
                <v-card flat>
                  <v-card-text>
                    <v-text-field
                      v-model="dadosPrimeiroAcesso.nu_cnpj"
                      label="CNPJ da organização ou entidade"
                      prepend-icon="people"
                      mask="##.###.###/####-##"
                      :rules="[rules.CNPJValido]"
                    />
                    <v-text-field
                      v-model="dadosPrimeiroAcesso.nu_cpf"
                      prepend-icon="account_circle"
                      name="login"
                      label="CPF do representante"
                      mask="###.###.###-##"
                      validate-on-blur
                      type="text"
                      :rules="[rules.required, rules.CPFValido]"
                    />
                  </v-card-text>
                </v-card>
              </v-tab-item>
              <v-tab-item value="conselho">
                <v-card flat>
                  <v-card-text>
                    <v-text-field
                      v-model="dadosPrimeiroAcesso.nu_cnpj"
                      label="CNPJ do órgao gestor do conselho"
                      prepend-icon="people"
                      mask="##.###.###/####-##"
                      :rules="[rules.CNPJValido]"
                    />
                    <v-text-field
                      v-model="dadosPrimeiroAcesso.nu_cpf"
                      prepend-icon="account_circle"
                      name="login"
                      label="CPF do representante do conselho"
                      mask="###.###.###-##"
                      validate-on-blur
                      type="text"
                      :rules="[rules.required, rules.CPFValido]"
                    />
                  </v-card-text>
                </v-card>
              </v-tab-item>
            </v-tabs-items>
          </v-card>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';

export default {
  name: 'PrimeiroAcesso',
  data: () => ({
    loading: false,
    formularioValido: true,
    step: 1,
    dadosPrimeiroAcesso: {
      nu_cpf: '',
      nu_cnpj: '',
      tp_inscricao: null,
    },
    rules: {
      required: value => !!value || 'Este campo é obrigatório',
      CPFValido: value => Validate.isCpfValido(value) || 'CPF inválido',
      CNPJValido: value => Validate.isCnpjValido(value) || 'CNPJ inválido',
    },
  }),
  methods: {
    ...mapActions({
      solicitarPrimeiroAcesso: 'conta/solicitarPrimeiroAcesso',
      mensagemErro: 'app/setMensagemErro',
    }),
    solicitarAcesso() {
      this.loading = true;

      this.solicitarPrimeiroAcesso(this.dadosPrimeiroAcesso)
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
