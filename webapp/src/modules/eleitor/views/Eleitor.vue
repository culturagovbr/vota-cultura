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
                      label="*CPF"
                      v-model="eleitor.nu_cpf"
                      append-icon="account_circle"
                      :rules="[rules.required, rules.cpfMin]"
                      mask="###.###.###-##"
                      required
                    />
                  </v-flex>
                  <v-flex sm6>
                    <v-text-field
                      label="*Nome completo"
                      v-model="eleitor.nu_cpf"
                      append-icon="perm_identity"
                      :rules="[rules.required]"
                      required
                    />
                  </v-flex>
                  <v-flex sm2>
                    <v-text-field
                      label="*RG"
                      v-model="eleitor.nu_rg"
                      append-icon="account_circle"
                      :rules="[rules.required]"
                      mask="##.###.###-#"
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
                      required
                    />
                  </v-flex>
                </v-layout>

                <v-layout
                  wrap
                  align-center
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
                            v-model="dateFormatted"
                            label="*Data de Nascimento"
                            :rules="[rules.required]"
                            append-icon="event"
                            required
                            v-on="on"
                          />
                        </template>
                        <v-date-picker
                          v-model="eleitor.dt_nascimento"
                          locale="pt-BR"
                          scrollable
                        >
                          <v-spacer/>
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
                      :items="[{ st_estrangeiro: 1 , nome: 'Brasileiro'},
                      { st_estrangeiro: 2 , nome: 'Outros'}]"
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
                      :items="['DF','GO']"
                      label="*Unidade da Federação"
                      append-icon="place"
                      :rules="[rules.required]"
                      required
                    />
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex sm3>
                    <div
                      class="title text-xs-center text-md-center text-lg-center text-sm-center"
                    >
                      Anexo CPF
                    </div>
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex sm3>
                    <file v-model="anexoCpf"/>
                  </v-flex>
                </v-layout>

                <v-btn
                  @click="reset"
                >
                  Cancelar
                </v-btn>

                <v-btn
                  :disabled="!valid"
                  color="primary"
                  to="/inscricao/revisao-eleitor"
                >
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
  import {mapActions} from 'vuex';
  import File from '@/core/components/upload/File';

  export default {
    name: 'Eleitor',
    components: {File},
    data: () => ({
      anexoCpf: '',
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
        co_endereco: '',
        ds_email: '',
        ds_email_confirmacao: '',
        endereco: {
          ds_complemento: '',
          nu_cep: '',
          ds_logradouro: '',
          co_municipio: '',
        }
      },
      email: '',
      emailConfirmation: '',
      rules: {
        required: v => !!v || 'Campo não preenchido',
        phoneMin: v => (v && v.length >= 9) || 'Mínimo de 9 caracteres',
        cpfMin: v => (v && v.length === 11) || 'Mínimo de 11 caracteres',
        email: (v) => {
          // eslint-disable-next-line
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(v) || 'E-mail invalido';
        },
        emailMatch: (email, emailConfirmation) => email == emailConfirmation || 'Os emails não correspondem',
      },
    }),
    watch: {
      date() {
        this.dateFormatted = this.formatDate(this.date);
      },
      email(v) {
        console.log(v);
      },
    },
    methods: {
      ...mapActions({
         cadastrarEleitor: "eleitor/cadastrarEleitor",
      }),
      validate() {
        if (this.$refs.form.validate()) {
          this.cadastrar();
        }
      },
      reset() {
        this.$refs.form.reset();
      },
      cadastrar() {
        this.cadastrarEleitor(this.eleitor)
          .then((data) => {
          })
          .catch(error => {
            this.mensagemErro(error.response.data.message);
          })
          .finally(() => {
            this.loading = false;
          });
      },
    },
  };
</script>
