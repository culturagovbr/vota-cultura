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
                      v-model="eleitor.no_eleitor"
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
                      append-icon="account_circle"
                      :rules="[rules.required]"
                      mask="#########"
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
                    />
                  </v-flex>
                  <v-flex sm4>
                    <v-select
                      v-model="eleitor.co_ibge"
                      :items="listaUF"
                      label="*Unidade da Federação"
                      append-icon="place"
                      item-value="co_ibge"
                      item-text="no_uf"
                      :rules="[rules.required]"
                      required
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
import File from '@/core/components/upload/File';
import { eventHub } from '@/event';
import Validate from '../../shared/util/validate';

export default {
  name: 'Eleitor',
  components: { File },
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
      no_eleitor: '',
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
      required: v => !!v || 'Campo não preenchido',
      cpfInvalido: v => !!v || 'CPF não encontrado',
      phoneMin: v => (v && v.length >= 9) || 'Mínimo de 9 caracteres',
      cpfMin: v => (v && v.length === 11) || 'Mínimo de 11 caracteres',
      email: (v) => {
        // eslint-disable-next-line
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(v) || 'E-mail invalido';
      },
      emailMatch: (email, emailConfirmation) => email == emailConfirmation || 'Os emails não correspondem',
      dataAniversario: (v) => {
        const bits = v.split('/');
        const hoje = new Date();
        const dataAniversario = new Date(bits[2], bits[1] - 1, bits[0]);

        const validDate = dataAniversario && (dataAniversario.getMonth() + 1) == bits[1];

        if (!validDate) {
          return 'Data inválida';
        }

        let ano = hoje.getFullYear() - dataAniversario.getFullYear();
        const mes = hoje.getMonth() - dataAniversario.getMonth();
        if (mes < 0 || (mes === 0 && hoje.getDate() < dataAniversario.getDate())) {
          ano--;
        }

        if (ano > 100 || ano < 18) {
          return 'É necessário ter entre 18 e 100 anos';
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
      self.eleitor.no_eleitor = '';
      this.nomeEleitorError = 'CPF inválido';
      if (value.length === 11 && Validate.isCpfValido(value)) {
        this.consultarCPF(value).then((response) => {
          const { data } = response.data;
          self.eleitor.no_eleitor = data.nmPessoaFisica;
        });
        this.nomeEleitorError = '';
      }
    },
  },
  mounted() {
    this.obterEstados();
  },
  computed: {
    ...mapGetters({
      estadosGetter: 'localidade/estados',
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
