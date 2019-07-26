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
                      append-icon="account_circle"
                      :rules="[rules.required, rules.cpfMin]"
                      mask="###.###.###-##"
                      required
                    />
                  </v-flex>
                  <v-flex sm6>
                    <v-text-field
                      label="*Nome completo"
                      append-icon="perm_identity"
                      :rules="[rules.required]"
                      required
                    />
                  </v-flex>
                  <v-flex sm2>
                    <v-text-field
                      label="*RG"
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
                      v-model="email"
                      label="*E-mail"
                      append-icon="mail"
                      placeholder="email@exemplo.com"
                      :rules="[rules.required, rules.email]"
                      required
                    />
                  </v-flex>
                  <v-flex sm6>
                    <v-text-field
                      v-model="emailConfirmation"
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
                      :items="['Brasileiro','Outros']"
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
                    <file v-model="anexoCpf" />
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
import File from '@/core/components/upload/File';

export default {
  name: 'Eleitor',
  components: { File },
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
