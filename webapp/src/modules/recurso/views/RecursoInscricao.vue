<template>
  <v-container>
    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>Cadastro de recurso</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-form
          ref="form_recurso"
          v-model="valid"
          lazy-validation
        >
          <v-layout class="mt-1">
            <v-flex
              xs12
              sm6
            >
              <v-radio-group
                v-model="recursoInscricao.co_fase"
                row
                :rules="[rules.required]"
              >
                <v-radio
                  label="Conselho de cultura"
                  value="4"
                />
                <v-radio
                  label="Organização ou entidade cultural"
                  value="5"
                />
              </v-radio-group>
            </v-flex>
          </v-layout>
          <v-layout
            wrap
            align-center
            class="mt-1"
          >
            <v-flex
              xs12
              sm6
            >
              <v-text-field
                v-model="recursoInscricao.nu_cnpj"
                label="*CNPJ"
                append-icon="people"
                placeholder="99.999.999/9999-99"
                :error-messages="nomeConselhoError"
                mask="##.###.###/####-##"
                :rules="[rules.required, rules.cnpjMin]"
                required
              />
            </v-flex>
            <v-flex
              xs12
              sm6
            >
              <v-text-field
                v-model="nomeConselho"
                label="Razão social"
                append-icon="people_outline"
                :disabled="true"
                :rules="[rules.cnpjInvalido]"
                required
                style="margin-left: 20px"
              />
            </v-flex>
          </v-layout>
          <v-layout
            wrap
            align-center
            class="mt-1"
          >
            <v-flex
              xs12
              sm6
            >
              <v-text-field
                v-model="recursoInscricao.nu_cpf"
                label="*CPF do representante"
                append-icon="person"
                placeholder="999.999.999-99"
                mask="###.###.###-##"
                :error-messages="nomeRepresentanteError"
                :rules="[rules.required, rules.cpfMin]"
                required
              />
            </v-flex>
            <v-flex
              xs12
              sm6
            >
              <v-text-field
                v-model="nomeRepresentante"
                :disabled="true"
                label="*Nome do representante"
                append-icon="perm_identity"
                :error-messages="nomeRepresentanteError"
                :rules="[rules.cpfInvalido]"
                style="margin-left: 20px"
                required
              />
            </v-flex>
          </v-layout>

          <v-layout
            wrap
            align-center
            class="mt-1"
          >
            <v-flex
              xs12
              sm6
            >
              <v-text-field
                v-model="recursoInscricao.ds_email"
                data-vv-name="email"
                label="*E-mail do representante"
                append-icon="mail"
                placeholder="email@exemplo.com"
                counter
                maxlength="100"
                :rules="[rules.required, rules.email]"
                required
                hint="Atenção: este e-mail deverá ser acessado para acompanhamento do recurso"
                persistent-hint
              />
            </v-flex>
            <v-flex
              xs12
              sm6
            >
              <v-text-field
                v-model="recursoInscricao.nu_telefone"
                label="*Celular do representante"
                append-icon="phone"
                placeholder="(99) 99999-9999"
                mask="(##) #####-####"
                :rules="[rules.required, rules.phoneMin]"
                required
                style="margin-left: 20px"
              />
            </v-flex>
          </v-layout>
          <v-layout
            wrap
            align-center
          >
            <v-flex
              xs12
              sm12
            >
              <div class="ma-4 text-justify subheading grey--text">
                Ilmo Sr. Secretário da Diversidade Cultural,
                com base no <b>item 6</b> deste edital de CHAMADA PÚBLICA PARA COMPOSIÇÃO DO
                CONSELHO NACIONAL DE POLÍTICA CULTURAL (CNPC) no triênio 2019/2022,
                venho interpor recurso em face do resultado na etapa de inscrição pelos motivos
                abaixo descritos:
              </div>
            </v-flex>
          </v-layout>
          <v-layout
            wrap
            align-center
          >
            <v-flex
              xs12
              sm12
              class="ma-3"
            >
              <v-textarea
                v-model="recursoInscricao.ds_recurso"
                name="input-7-1"
                box
                solo
                label="Descrição do recurso"
                auto-grow
                :placeholder="'Digite seu recurso aqui.'"
                :counter="3000"
                :rules="[rules.required, rules.tamanhoMaximoCaracteres]"
              />
            </v-flex>
          </v-layout>
        </v-form>
      </v-card-text>
      <v-layout
        wrap
        align-center
      >
        <v-flex offset-xs5>
          <v-btn to="/">
            Cancelar
          </v-btn>
          <v-btn
            :disabled="!valid"
            color="primary"
            @click="abrirDialogo"
          >
            Enviar
          </v-btn>
        </v-flex>
      </v-layout>
    </v-card>

    <v-layout justify-center>
      <v-dialog
        v-model="dialog"
        max-width="290"
      >
        <v-card>
          <v-card-title class="headline">
            Deseja realmente enviar?
          </v-card-title>

          <v-card-text>
            Os dados enviados não poderão ser alterados posteriormente.
          </v-card-text>

          <v-card-actions>
            <v-spacer />

            <v-btn
              color="red darken-1"
              text
              flat
              @click="fecharDialogo"
            >
              Não
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              flat
              @click="salvar"
            >
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '../../shared/util/validate';

export default {
  data: () => ({
    dialog: false,
    valid: false,
    nomeConselho: '',
    nomeConselhoError: '',
    nomeRepresentante: '',
    nomeRepresentanteError: '',
    recursoInscricao: {
      co_fase: '',
      ds_email: '',
      nu_cnpj: '',
      nu_cpf: '',
      nu_telefone: '',
      ds_recurso: '',
      no_razao_social: '',
      no_representante: '',
    },
    listaRecursos: [
      {
        co_fase: 4,
        tp_fase: 'recurso_inscricoes_conselho',
        ds_detalhamento: 'Conselho',
      },
      {
        co_fase: 5,
        tp_fase: 'recurso_inscricoes_organizacao',
        ds_detalhamento: 'Organização',
      },
    ],
    rules: {
      required: value => !!value || 'Campo não preenchido',
      cnpjInvalido: value => !!value || 'CNPJ não encontrado',
      cpfInvalido: value => !!value || 'CPF não encontrado',
      phoneMin: value => (value && value.length >= 9) || 'Mínimo de 9 caracteres',
      cnpjMin: value => (value && value.length === 14) || 'Mínimo de 14 caracteres',
      cpfMin: value => (value && value.length === 11) || 'Mínimo de 11 caracteres',
      email: (value) => {
        // eslint-disable-next-line
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(value) || 'E-mail invalido';
      },
      tamanhoMaximoCaracteres: value => (!!value && value.length <= 3000) || 'Máximo 3000 caracteres',
    },
  }),
  watch: {
    'recursoInscricao.nu_cnpj': function (value) {
      const self = this;
      self.nomeConselho = '';
      this.nomeConselhoError = 'CNPJ inválido';
      if (value.length === 14 && Validate.isCnpjValido(value)) {
        this.consultarCNPJ(value).then((response) => {
          const { data } = response.data;
          self.nomeConselho = data.nmRazaoSocial;
        });
        this.nomeConselhoError = '';
      }
    },
    'recursoInscricao.nu_cpf': function (value) {
      const self = this;
      self.nomeRepresentante = '';
      this.nomeRepresentanteError = 'CPF inválido';
      if (value.length === 11 && Validate.isCpfValido(value)) {
        this.consultarCPF(value).then((response) => {
          const { data } = response.data;
          self.nomeRepresentante = data.nmPessoaFisica;
        });
        this.nomeRepresentanteError = '';
      }
    },
  },
  methods: {
    ...mapActions({
      consultarCNPJ: 'pessoa/consultarCNPJ',
      consultarCPF: 'pessoa/consultarCPF',
      definirMensagemSucesso: 'app/setMensagemSucesso',
      enviarDadosRecursoInscricao: 'recurso/enviarDadosRecursoInscricao',
    }),
    validarIrProximaEtapa(formRef) {
      if (this.$refs[formRef].validate()) {
        this.etapaFormulario = this.etapaFormulario + 1;
      }
    },
    salvar() {
      this.loading = true;
      this.recursoInscricao.no_razao_social = this.nomeConselho;
      this.recursoInscricao.no_representante = this.nomeRepresentante;

      this.enviarDadosRecursoInscricao(this.recursoInscricao)
        .then((response) => {
          this.definirMensagemSucesso(response.data.message);
          this.$router.push('/');
        }).finally(() => {
          this.loading = false;
          this.fecharDialogo();
        });
    },
    abrirDialogo() {
      if (!this.$refs.form_recurso.validate()) {
        return false;
      }
      this.dialog = true;
      return true;
    },
    fecharDialogo() {
      this.dialog = false;
    },
  },
  mounted() {
    this.mensagemErro('O prazo de recurso expirou!');
    this.$router.push('/');
  },
};
</script>
