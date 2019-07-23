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
                          row
                          :rules="[rules.required]"
                        >
                          <v-radio
                            label="Estadual"
                            value="radio-1"
                          />
                          <v-radio
                            label="Capital"
                            value="radio-2"
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
                          v-model="emailCouncil"
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
                          v-model="emailCouncilConfirmation"
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email, rules.emailMatch(emailCouncil, emailCouncilConfirmation)]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
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
                          :items="['DF','GO']"
                          label="*Unidade da Federação da Sede"
                          append-icon="place"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm5
                      >
                        <v-text-field
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
                          v-model="emailRepresentative"
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
                          v-model="emailRepresentativeConfirmation"
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email, rules.emailMatch(emailRepresentative, emailRepresentativeConfirmation)]"
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
                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-select
                          :items="['Selecione', 'CNPJ']"
                          label="Tipo do Documento"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm7
                        style="
                                                        border-style: solid;
                                                        border-color: gray;
                                                        border-width: 1px;
                                                        border-radius: 4px;
                                                        padding-top: 1px;"
                      >
                        <input type="file">
                      </v-flex>
                      <v-flex
                        xs12
                        sm2
                      >
                        <v-btn
                          color="blue-grey"
                          class="white--text"
                        >
                          Incluir
                          <v-icon
                            right
                            dark
                          >
                            cloud_upload
                          </v-icon>
                        </v-btn>
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
                        <v-data-table
                          :items="[{tipo: 'cpf', arquivo:'cpf_digitaliza.pdf'}]"
                          class="elevation-1"
                          :headers="headers"
                          hide-actions
                        >
                          <template v-slot:items="props">
                            <td class="text-md-center">
                              {{ props.item.tipo }}
                            </td>
                            <td class="text-md-center">
                              {{ props.item.arquivo }}
                            </td>
                            <td class="text-md-center">
                              <v-icon
                                small
                                @click="console.log('apagado')"
                              >
                                delete
                              </v-icon>
                            </td>
                          </template>
                        </v-data-table>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn
                :disabled="false"
                color="primary"
                @click="validate('form_anexo')"
              >
                Enviar
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

export default {
  data: () => ({
    e1: 1,
    valid_conselho: false,
    valid_representante: false,
    valid_anexo: true,
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

  methods: {
    validate(formRef) {
      if (this.$refs[formRef].validate()) {
        this.e1 = this.e1 + 1;
      }
    },
    reset() {
      // this.$refs.form_conselho.reset()
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
