<template>
  <v-container fluid>
    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>Inscrição - Organização ou Entidade Cultural</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-stepper v-model="e1">
          <v-stepper-header>
            <v-stepper-step
              editable
              :complete="e1 > 1"
              step="1"
            >
              Organização ou Entidade Cultural
            </v-stepper-step>

            <v-divider/>

            <v-stepper-step
              editable
              :complete="e1 > 2"
              step="2"
            >
              Responsável
            </v-stepper-step>

            <v-divider/>

            <v-stepper-step
              editable
              :complete="e1 > 3"
              step="3"
            >
              Segmento
            </v-stepper-step>

            <v-divider/>

            <v-stepper-step
              editable
              :complete="e1 > 4"
              step="4"
            >
              Declaração de enquadramento
            </v-stepper-step>

            <v-divider/>

            <v-stepper-step
              editable
              :complete="e1 > 5"
              step="5"
            >
              Anexo
            </v-stepper-step>
          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content step="1">
              <v-form
                ref="form_dados_entidade"
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
                        sm5
                      >
                        <v-text-field
                          label="*CNPJ"
                          append-icon="people"
                          placeholder="99.999.999/9999-99"
                          mask="##.###.###/####-##"
                          :rules="[rules.required, rules.cnpjMin]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm5
                      >
                        <v-text-field
                          label="*Nome da Organização/Entidade"
                          append-icon="perm_identity"
                          :rules="[rules.required]"
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
                          v-model="emailOrganization"
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
                          v-model="emailOrganizationConfirmation"
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email, rules.emailMatch(emailOrganization, emailOrganizationConfirmation)]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          label="Sítio eletrônico da Organização/Entidade"
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
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn
                color="primary"
              >
                Próximo
              </v-btn>
              <v-btn flat>
                Cancelar
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="2">
              <v-form
                ref=""
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
                          label="*Nome do Responsável"
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
                          label="*Celular do Responsável"
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
                          label="*E-mail do Responsável"
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
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email]"
                          required
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn
                color="primary"
              >
                Próximo
              </v-btn>
              <v-btn flat>
                Cancelar
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
              <v-form
                ref=""
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
                        sm6
                      >
                        <v-radio-group label="*Informe o segmento no qual pretende concorrer">
                          <v-radio
                            label="Técnico-artístico"
                            value="radio-1"
                          />
                          <v-radio
                            label="Patrimônio cultural"
                            value="radio-2"
                          />
                          <v-radio
                            label="Culturas populares"
                            value="radio-3"
                          />
                          <v-radio
                            label="Culturas dos povos indígenas"
                            value="radio-4"
                          />
                          <v-radio
                            label="Expressões culturais afro-brasileiras"
                            value="radio-5"
                          />
                        </v-radio-group>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn color="primary">
                Próximo
              </v-btn>

              <v-btn>
                Cancelar
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="4">
              <v-form
                ref=""
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
                        sm6
                      >
                        <v-select
                          :items="['']"
                          label="*Abrangência Nacional"
                          :rules="[rules.required]"
                          required
                          placeholder="Selecione"
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-select
                          :items="['']"
                          label="*Abrangência Estadual"
                          :rules="[rules.required]"
                          required
                          placeholder="Selecione"
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
                        <v-select
                          :items="['']"
                          label="*Tempo de Funcionamento"
                          :rules="[rules.required]"
                          required
                          placeholder="Selecione"
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-select
                          :items="['']"
                          label="*Nº de Associados ou Filiados"
                          :rules="[rules.required]"
                          required
                          placeholder="Selecione"
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
                        <v-select
                          :items="['']"
                          label="*Nº Atividades/projetos realizados no campo cultural a partir de 2016"
                          :rules="[rules.required]"
                          required
                          placeholder="Selecione"
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-select
                          :items="['']"
                          label="Nº Participação em instâncias de formulação de política cultural"
                          placeholder="Selecione"
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
                        <v-select
                          :items="['']"
                          label="*Abrangência de projetos realizados no campo cultural a partir de 2016"
                          :rules="[rules.required]"
                          required
                          placeholder="Selecione"
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-select
                          :items="['']"
                          label="Projetos na área de pesquisa ou produção do conhecimento no campo da cultura a partir de 2016"
                          placeholder="Selecione"
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn color="primary">
                Próximo
              </v-btn>
              <v-btn flat>
                Cancelar
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="5">
              <v-form
                ref=""
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
                          :items="['CPF', 'CNPJ']"
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
              <v-btn color="primary" to="/organizacao/revisao-organizacao">
                Próximo
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
      valid: false,
      date: '',
      e1: 1,
      emailOrganization: '',
      emailOrganizationConfirmation: '',
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
          const pattern = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
          if (v) return pattern.test(v) || 'Sítio invalido';
          return true;
        },
        emailMatch: (email, emailConfirmation) => email === emailConfirmation || 'Os emails não correspondem',
      },
    }),
    watch: {
      date() {
        this.dateFormatted = this.formatDate(this.date);
      },
    },
    methods: {
      validate() {
        if (this.$refs.form.validate()) {
          console.log('talkei');
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
