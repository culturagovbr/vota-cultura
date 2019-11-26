<template>
  <v-container>
    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>Inscrição - Eleitor</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-layout md9>
          <v-flex
            md9
            xm12
            sm12
            lg12
          >
            <v-form
              ref="form"
              v-model="valid"
              lazy-validation
            >
              <v-container>
                <v-layout
                  wrap
                  align-center
                >
                  <v-flex sm4>
                    <v-text-field
                      v-model="eleitor.nu_cpf"
                      label="*CPF"
                      append-icon="account_circle"
                      :rules="[rules.required, rules.cpfMin]"
                      :error-messages="nomeEleitorError"
                      mask="###.###.###-##"
                      required
                    />
                  </v-flex>
                  <v-flex sm6>
                    <v-text-field
                      v-model="eleitor.no_nome"
                      :disabled="true"
                      label="*Nome completo"
                      append-icon="perm_identity"
                      :error-messages="nomeEleitorError"
                      :rules="[rules.cpfInvalido]"
                      required
                    />
                  </v-flex>
                  <v-flex sm2>
                    <v-text-field
                      v-model="eleitor.nu_rg"
                      label="*RG"
                      counter
                      maxlength="11"
                      append-icon="account_circle"
                      :rules="[rules.required]"
                      mask="###########"
                      required
                    />
                  </v-flex>
                </v-layout>

                <v-layout
                  wrap
                  align-center
                >
                  <v-flex sm6>
                    <v-text-field
                      v-model="eleitor.ds_email"
                      label="*E-mail"
                      append-icon="mail"
                      placeholder="email@exemplo.com"
                      :rules="[rules.required, rules.email]"
                      counter
                      maxlength="250"
                      required
                    />
                  </v-flex>
                  <v-flex sm6>
                    <v-text-field
                      v-model="eleitor.ds_email_confirmacao"
                      label="*Confirmar e-mail"
                      append-icon="mail"
                      placeholder="email@exemplo.com"
                      :rules="[rules.required, rules.email, rules.emailMatch(email, emailConfirmation)]"
                      counter
                      maxlength="250"
                      required
                    />
                  </v-flex>
                </v-layout>

                <v-layout
                  wrap
                  align-center
                  class="mb-4"
                >
                  <v-flex sm4>
                    <template activator="{ on }">
                      <v-menu
                        ref="menu"
                        v-model="menu"
                        lazy
                        transition="scale-transition"
                        :close-on-content-click="false"
                        offset-y
                        full-width
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="eleitor.dt_nascimento"
                            label="*Data de Nascimento"
                            :rules="[rules.required, rules.dataAniversario]"
                            append-icon="event"
                            placeholder="ex: 01/12/2019"
                            return-masked-value
                            mask="##/##/####"
                            required
                            v-on="on"
                          />
                        </template>
                        <v-date-picker
                          v-model="date"
                          locale="pt-BR"
                          scrollable
                        >
                          <v-spacer />
                          <v-btn
                            flat
                            color="primary"
                            @click="menu = false"
                          >
                            Cancel
                          </v-btn>
                          <v-btn
                            flat
                            color="primary"
                            @click="$refs.menu.save(date)"
                          >
                            OK
                          </v-btn>
                        </v-date-picker>
                      </v-menu>
                    </template>
                  </v-flex>
                  <v-flex sm4>
                    <v-select
                      v-model="eleitor.st_estrangeiro"
                      :items="[{ st_estrangeiro: '0' , nome: 'Brasileiro'},
                               { st_estrangeiro: '1' , nome: 'Estrangeiro'}]"
                      item-value="st_estrangeiro"
                      item-text="nome"
                      label="*Nacionalidade"
                      append-icon="place"
                      :rules="[rules.required]"
                      required
                      box
                    />
                  </v-flex>
                  <v-flex sm4>
                    <v-select
                      v-model="eleitor.co_ibge"
                      :items="listaUF"
                      label="*Unidade da federação em que reside"
                      append-icon="place"
                      item-value="co_ibge"
                      item-text="no_uf"
                      :rules="[rules.required]"
                      required
                      box
                    />
                  </v-flex>
                </v-layout>

                <v-btn to="/">
                  Cancelar
                </v-btn>


                <v-btn
                  :disabled="!valid"
                  color="primary"
                  @click="validate"
                >
                  Salvar
                </v-btn>
              </v-container>
            </v-form>
          </v-flex>
        </v-layout>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { eventHub } from '@/event';
import Validate from '../../shared/util/validate';

export default {
  name: 'Eleitor',
  data: () => ({
    nomeEleitorError: '',
    valid: false,
    date: '',
    dateFormatted: '',
    menu: false,
    headers: [
      {
        text: 'Tipo',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Arquivo',
        align: 'center',
        sortable: false,
      },
      {
        sortable: false,
      },
    ],
    eleitor: {
      nu_cpf: '',
      no_nome: '',
      nu_rg: '',
      dt_nascimento: '',
      st_estrangeiro: '',
      ds_email: '',
      ds_email_confirmacao: '',
      co_ibge: '',
    },
    listaUF: [],
    email: '',
    emailConfirmation: '',
    rules: {
      required: value => !!value || 'Campo não preenchido',
      cpfInvalido: value => !!value || 'CPF não encontrado',
      phoneMin: value => (value && value.length >= 9) || 'Mínimo de 9 caracteres',
      cpfMin: value => (value && value.length === 11) || 'Mínimo de 11 caracteres',
      email: (value) => {
        // eslint-disable-next-line
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(value) || 'E-mail invalido';
      },
      emailMatch: (email, emailConfirmation) => email === emailConfirmation || 'Os emails não correspondem',
      dataAniversario: (value) => {
        if (value.length === 0 || !value.trim()) {
          return false;
        }
        // eslint-disable-next-line
        var padraoDataValida = /^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])      [\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/;

        if (!value.match(padraoDataValida)) {
          return 'Data inválida';
        }

        let [dia, mes, ano] = value.split('/');

        const hoje = new Date();
        const dataAniversario = new Date(ano, mes - 1, dia);

        ano = hoje.getFullYear() - dataAniversario.getFullYear();
        mes = hoje.getMonth() - dataAniversario.getMonth();
        if (mes < 0 || (mes === 0 && hoje.getDate() < dataAniversario.getDate())) {
          ano--;
        }

        if (ano > 100 || ano < 18) {
          return 'É necessário ser maior de 18 anos';
        }
        return true;
      },
    },
  }),
  watch: {
    date() {
      this.eleitor.dt_nascimento = this.formatDate(this.date);
    },
    estadosGetter() {
      this.listaUF = this.estadosGetter;
    },
    'eleitor.nu_cpf': function (value) {
      const self = this;
      self.eleitor.no_nome = '';
      this.nomeEleitorError = 'CPF inválido';
      if (value.length === 11 && Validate.isCpfValido(value)) {
        this.consultarCPF(value).then((response) => {
          const { data } = response.data;
          self.eleitor.no_nome = data.nmPessoaFisica;
        });
        this.nomeEleitorError = '';
      }
    },
  },
  mounted() {
    eventHub.$emit('eventoErro', 'Período de inscrição encerrado!');
    this.$router.push('/');

    if (Object.keys(this.eleitorGetter).length > 0) {
      this.eleitor = this.eleitorGetter;
    }
    this.obterEstados();
  },
  computed: {
    ...mapGetters({
      estadosGetter: 'localidade/estados',
      eleitorGetter: 'eleitor/eleitor',
    }),
  },
  methods: {
    ...mapActions({
      confirmarEleitor: 'eleitor/confirmarEleitor',
      obterEstados: 'localidade/obterEstados',
      consultarCPF: 'pessoa/consultarCPF',
    }),
    validate() {
      if (this.$refs.form.validate()) {
        this.confirmarEleitor(this.eleitor).then(() => {
          this.$router.push('/eleitor/revisao-eleitor');
        });
      }
    },
    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.split('-');
      return `${day}/${month}/${year}`;
    },
    reset() {
      this.$refs.form.reset();
    },
  },
};
</script>
