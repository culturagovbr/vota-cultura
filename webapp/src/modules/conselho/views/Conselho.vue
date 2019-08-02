<template>
  <v-container>
    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>Inscrição - Conselho de Cultura</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-stepper v-model="e1">
          <v-stepper-header>
            <v-stepper-step
              editable
              :complete="e1 > 1"
              step="1"
            >
              Dados do Conselho de Cultura
            </v-stepper-step>

            <v-divider />

            <v-stepper-step
              editable
              :complete="e1 > 2"
              step="2"
            >
              Dados do Representante
            </v-stepper-step>

            <v-divider />

            <v-stepper-step
              editable
              :complete="e1 > 3"
              step="3"
            >
              Anexos
            </v-stepper-step>
          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content step="1">
              <v-form
                ref="form_conselho"
                v-model="valid_conselho"
                lazy-validation
              >
                <v-card flat>
                  <v-container
                    fluid
                    grid-list-xl
                  >
                    <v-layout>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-radio-group
                          v-model="conselho.tp_governamental"
                          row
                          :rules="[rules.required]"
                        >
                          <v-radio
                            label="Estadual"
                            value="e"
                          />
                          <v-radio
                            label="Capital"
                            value="c"
                          />
                        </v-radio-group>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-text-field
                          v-model="conselho.nu_cnpj"
                          label="*CNPJ do Orgão Gestor do Conselho"
                          append-icon="people"
                          placeholder="99.999.999/9999-99"
                          mask="##.###.###/####-##"
                          :rules="[rules.required, rules.cnpjMin]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm7
                      >
                        <v-text-field
                          v-model="conselho.no_orgao_gestor"
                          label="*Nome do órgão gestor de cultura"
                          append-icon="people"
                          :rules="[rules.required, rules.cnpjMin]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm2
                      >
                        <v-text-field
                          v-model="conselho.nu_telefone"
                          label="*Telefone"
                          append-icon="phone"
                          placeholder="(99) 99999-9999"
                          mask="(##) #####-####"
                          :rules="[rules.required, rules.phoneMin]"
                          required
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.ds_email"
                          data-vv-name="email"
                          label="*E-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.ds_email_confirmacao"
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email, rules.emailMatch(conselho.ds_email, conselho.ds_email_confirmacao)]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.ds_sitio_eletronico"
                          label="Sítio eletrônico do conselho"
                          append-icon="public"
                          :rules="[rules.url]"
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-text-field
                          v-model="conselho.endereco.nu_cep"
                          label="*CEP"
                          append-icon="my_location"
                          placeholder="99999-999"
                          mask="#####-###"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-text-field
                          v-model="conselho.endereco.ds_logradouro"
                          label="*Logradouro"
                          append-icon="place"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-text-field
                          v-model="conselho.endereco.ds_complemento"
                          label="Complemento"
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-select
                          :items="listaUF"
                          label="*Unidade da Federação da sede"
                          append-icon="place"
                          item-value="co_ibge"
                          item-text="no_uf"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm5
                      >
                        <v-text-field
                          v-model="conselho.endereco.co_municipio"
                          label="*Cidade"
                          append-icon="place"
                          :rules="[rules.required]"
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>

              <v-btn
                :disabled="!valid_conselho"
                color="success"
                @click="validate('form_conselho')"
              >
                Próximo
              </v-btn>
              <v-btn flat>
                Cancelar
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="2">
              <v-form
                ref="form_representante"
                v-model="valid_representante"
                lazy-validation
              >
                <v-card flat>
                  <v-container
                    fluid
                    grid-list-xl
                  >
                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm8
                      >
                        <v-text-field
                          v-model="conselho.representante.no_pessoa"
                          label="*Nome do Representante"
                          append-icon="perm_identity"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.representante.nu_telefone"
                          label="*Celular do representante"
                          append-icon="phone"
                          placeholder="(99) 99999-9999"
                          mask="(##) #####-####"
                          :rules="[rules.required, rules.phoneMin]"
                          required
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-text-field
                          v-model="conselho.representante.nu_cpf"
                          label="*CPF"
                          append-icon="person"
                          placeholder="999.999.999.99"
                          mask="###.###.###.##"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-text-field
                          v-model="conselho.representante.nu_rg"
                          label="*RG"
                          append-icon="person"
                          placeholder="99.999.999-9"
                          mask="##.###.###-#"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-text-field
                          v-model="conselho.representante.ds_email"
                          label="*E-mail do representante"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-text-field
                          v-model="conselho.representante.ds_email_confirmation"
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email, rules.emailMatch(conselho.representante.ds_email, conselho.representante.ds_email_confirmation)]"
                          required
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn
                color="primary"
                :disabled="!valid_representante"
                @click="validate('form_representante')"
              >
                Próximo
              </v-btn>
              <v-btn flat>
                Cancelar
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
              <v-form
                ref="form_anexo"
                v-model="valid_anexo"
                lazy-validation
              >
                <v-card flat>
                  <v-container
                    fluid
                    grid-list-xl
                  >
                    <v-layout>
                      <v-flex sm3>
                        <div class="title text-xs-center text-md-center text-lg-center text-sm-center">
                          Ato normativo que constituiu o conselho*
                        </div>
                      </v-flex>
                      <v-flex sm3>
                        <div class="title text-xs-center text-md-center text-lg-center text-sm-center">
                          Ata da última reunião do conselho*
                        </div>
                      </v-flex>
                      <v-flex sm3>
                        <div class="title text-xs-center text-md-center text-lg-center text-sm-center">
                          Documento de identificação do responsável*
                        </div>
                      </v-flex>
                      <v-flex sm3>
                        <div class="title text-xs-center text-md-center text-lg-center text-sm-center">
                          Declaração de ciência e autorização do órgão gestor de cultura do estado*
                        </div>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex sm3>
                        <file v-model="conselho.anexos.ato_normativo_conselho" />
                      </v-flex>
                      <v-flex sm3>
                        <file v-model="conselho.anexos.ata_ultima_reuniao_conselho" />
                      </v-flex>
                      <v-flex sm3>
                        <file v-model="conselho.anexos.documento_identificacao_responsavel" />
                      </v-flex>
                      <v-flex sm3>
                        <file v-model="autorizacao_orgao_gestor" />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn
                :disabled="false"
                color="primary"
                to="/conselho/revisao-conselho"
              >
                Enviar
              </v-btn>
              <v-btn
                :disabled="false"
                color="primary"
                @click="apresentar"
              >
                Enviar fake
              </v-btn>
              <v-btn flat>
                Cancelar
              </v-btn>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import File from '@/core/components/upload/File';
import { mapActions, mapGetters } from 'vuex';


export default {
  components: { File },
  data: () => ({
    e1: 1,
    listaUF: [],
    valid_conselho: false,
    valid_representante: false,
    valid_anexo: true,
    conselho: {
      no_orgao_gestor: '',
      ds_email: '',
      ds_email_confirmacao: '',
      nu_telefone: '',
      nu_cnpj: '',
      tp_governamental: '',
      endereco: {
        ds_complemento: '',
        nu_cep: '',
        ds_logradouro: '',
        co_municipio: '',
      },
      representante: {
        ds_email: '',
        no_pessoa: '',
        nu_rg: '',
        nu_cpf: '',
        nu_telefone: '',
        ds_email_confirmation: '',
      },
      ds_sitio_eletronico: '',
      anexos: {
        ato_normativo_conselho: '',
        ata_ultima_reuniao_conselho: '',
        documento_identificacao_responsavel: '',
        autorizacao_orgao_gestor: '',
      },
    },
    steps: [
      {
        title: 'Dados do Conselho de Cultura',
        id: 1,

      },
      {
        title: 'Dados do Representante',
        id: 2,
      },
      {
        title: 'Anexos',
        id: 3,
      },
    ],
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
    emailCouncil: '',
    emailCouncilConfirmation: '',
    emailRepresentative: '',
    emailRepresentativeConfirmation: '',
    rules: {
      required: v => !!v || 'Campo não preenchido',
      phoneMin: v => (v && v.length >= 9) || 'Mínimo de 9 caracteres',
      cnpjMin: v => (v && v.length === 14) || 'Mínimo de 14 caracteres',
      email: (v) => {
        // eslint-disable-next-line
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(v) || 'E-mail invalido';
      },
      url: (v) => {
        // eslint-disable-next-line
          const pattern = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/;
        return pattern.test(v) || 'Sítio eletrônico invalido';
      },
      emailMatch: (email, emailConfirmation) => email == emailConfirmation || 'Os emails não correspondem',
    },
  }),
  watch: {
    estadosGetter() {
      this.listaUF = this.estadosGetter;
    },
  },
  computed: {
    ...mapGetters({
      estadosGetter: 'localidade/estadosGetter',
    }),
  },
  methods: {
    ...mapActions({
      obterEstados: 'localidade/obterEstados',
    }),
    validate(formRef) {
      if (this.$refs[formRef].validate()) {
        this.e1 = this.e1 + 1;
      }
    },
    reset() {
      // this.$refs.form_conselho.reset()
    },
    apresentar() {
      console.log(this.conselho);
    },
    nextStep(n) {
      if (n === this.steps.length) {
        this.e1 = 1;
      } else {
        this.e1 = n + 1;
      }
    },
  },
};
</script>
