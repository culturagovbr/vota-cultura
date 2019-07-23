<template>
  <v-container>
    <v-card>
      <v-toolbar
              dark
              color="primary">
        <v-toolbar-title>Inscrição - Eleitor</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-layout md9>
          <v-flex md9 xm12 sm12 lg12>
            <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
            >
              <v-container fluid grid-list-xl>

                <h2>Dados do Eleitor</h2>

                <v-layout wrap align-center>
                  <v-flex xs12 sm4>
                    <v-text-field
                            label="*CPF"
                            append-icon="account_circle"
                            :rules="[rules.required, rules.cpfMin]"
                            mask="###.###.###-##"
                            required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6>
                    <v-text-field
                            label="*Nome completo"
                            append-icon="perm_identity"
                            :rules="[rules.required]"
                            required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm2>
                    <v-text-field
                            label="*RG"
                            append-icon="account_circle"
                            :rules="[rules.required]"
                            mask="##.###.###-#"
                            required
                    ></v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout wrap align-center>
                  <v-flex xs12 sm6>
                    <v-text-field
                            v-model="email"
                            label="*E-mail"
                            append-icon="mail"
                            placeholder="email@exemplo.com"
                            :rules="[rules.required, rules.email]"
                            required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6>
                    <v-text-field
                            v-model="emailConfirmation"
                            label="*Confirmar e-mail"
                            append-icon="mail"
                            placeholder="email@exemplo.com"
                            :rules="[rules.required, rules.email, rules.emailMatch(email, emailConfirmation)]"
                            required
                    ></v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout wrap align-center>
                  <v-flex xs12 sm4>
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
                                  v-model="dateFormatted"
                                  label="*Data de Nascimento"
                                  :rules="[rules.required]"
                                  append-icon="event"
                                  v-on="on"
                                  required
                          ></v-text-field>
                        </template>
                        <v-date-picker
                                locale="pt-BR"
                                v-model="date"
                                scrollable>
                          <v-spacer></v-spacer>
                          <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                          <v-btn flat color="primary" @click="$refs.menu.save(date)">OK
                          </v-btn>
                        </v-date-picker>
                      </v-menu>
                    </template>
                  </v-flex>
                  <v-flex xs12 sm4>
                    <v-select
                            :items="['Brasileiro','Outros']"
                            label="*Nacionalidade"
                            append-icon="place"
                            :rules="[rules.required]"
                            required
                    ></v-select>
                  </v-flex>
                  <v-flex xs12 sm4>
                    <v-select
                            :items="['DF','GO']"
                            label="*Unidade da Federação"
                            append-icon="place"
                            :rules="[rules.required]"
                            required
                    ></v-select>
                  </v-flex>
                </v-layout>

                <h2>Anexo</h2>

                <v-layout wrap align-center>
                  <v-flex xs12 sm3>
                    <v-select
                            :items="['CPF', 'CNPJ']"
                            label="Tipo do Documento"
                            required
                    ></v-select>
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
                  <v-flex xs12 sm2>
                    <v-btn color="blue-grey"
                           class="white--text">
                      Incluir
                      <v-icon right dark>cloud_upload</v-icon>
                    </v-btn>
                  </v-flex>
                </v-layout>

                <v-layout wrap align-center>
                  <v-flex xs12 sm12>
                    <v-data-table
                            :items="[{tipo: 'cpf', arquivo:'cpf_digitaliza.pdf'}]"
                            class="elevation-1"
                            :headers="headers"
                            hide-actions
                    >
                      <template v-slot:items="props">
                        <td class="text-md-center">{{ props.item.tipo }}</td>
                        <td class="text-md-center">{{ props.item.arquivo }}</td>
                        <td class="text-md-center">
                          <v-icon
                                  small
                                  @click="console.log('apagado')"
                          >delete
                          </v-icon>
                        </td>
                      </template>
                    </v-data-table>

                  </v-flex>
                </v-layout>

                <v-btn color="error"
                       @click="reset">
                  Cancelar
                </v-btn>

                <v-btn :disabled="!valid"
                       color="success"
                       @click="validate">
                  Enviar
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
  export default {
    name: 'Eleitor',
    data: () => ({
      modelarquivoteste: '',
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
        email: '',
        emailConfirmation: '',
        rules: {
          required: v => !!v || 'Campo não preenchido',
          phoneMin: v => (v && v.length >= 9) || 'Mínimo de 9 caracteres',
          cpfMin: v => (v && v.length === 11) || 'Mínimo de 11 caracteres',
          email: v => {
            // eslint-disable-next-line
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern.test(v) || 'E-mail invalido';
          },
            emailMatch: (email, emailConfirmation) => email == emailConfirmation || 'Os emails não correspondem'
        },
    }),
    watch: {
      date() {
        this.dateFormatted = this.formatDate(this.date)
      },
      email(v) {
        console.log(v);
      }
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
        return `${day}/${month}/${year}`
      },
      reset() {
        this.$refs.form.reset()
      },
    }
  };
</script>
