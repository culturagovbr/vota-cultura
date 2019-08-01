<template>
  <v-container>
    <v-layout wrap>
      <v-flex
        offset-xs3
        xs6
      >
        <v-card
          max-width="900"
        >
          <v-toolbar
            dark
            color="primary"
          >
            <v-toolbar-title>Confirmação dos dados</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-container>
              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="eleitor.nu_cpf"
                    disabled
                    label="CPF"
                    append-icon="account_circle"
                    mask="###.###.###-##"
                  />
                </v-flex>
              </v-layout>
              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="eleitor.no_eleitor"
                    disabled
                    label="Nome completo"
                    append-icon="perm_identity"
                  />
                </v-flex>
              </v-layout>
              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="eleitor.nu_rg"
                    disabled
                    label="RG"
                    append-icon="account_circle"
                    mask="#########"
                  />
                </v-flex>
              </v-layout>

              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="eleitor.dt_nascimento"
                    disabled
                    label="Data de Nascimento"
                    append-icon="event"
                    mask="##/##/####"
                  />
                </v-flex>
              </v-layout>

              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="eleitor.ds_email"
                    disabled
                    label="E-mail"
                    append-icon="mail"
                    placeholder="email@exemplo.com"
                  />
                </v-flex>
              </v-layout>

              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-select
                    v-model="eleitor.st_estrangeiro"
                    :items="[{ st_estrangeiro: '0' , nome: 'Brasileiro'},
                             { st_estrangeiro: '1' , nome: 'Outros'}]"
                    item-value="st_estrangeiro"
                    item-text="nome"
                    label="Nacionalidade"
                    append-icon="place"
                    disabled
                  />
                </v-flex>
              </v-layout>
              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-select
                    v-model="eleitor.co_ibge"
                    :items="listaUF"
                    label="Unidade da Federação"
                    append-icon="place"
                    item-value="co_ibge"
                    item-text="no_uf"
                    disabled
                  />
                </v-flex>
              </v-layout>
              <v-layout
                wrap
                align-center
              >
                <v-flex offset-xs4>
                  <v-btn
                    to="/eleitor/inscricao"
                  >
                    Cancelar
                  </v-btn>
                  <v-btn
                    color="primary"
                    dark
                    @click.stop="dialog = true"
                  >
                    Enviar
                  </v-btn>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>

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
              @click="dialog = false"
            >
              Não
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              flat
              @click="dialog = false; salvar()"
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
import { mapActions, mapGetters } from 'vuex';
import { eventHub } from '@/event';

export default {
  name: 'RevisaoEleitor',
  data: () => ({
    dialog: false,
    listaUF: [],
    eleitor: {
      nu_cpf: '',
      no_eleitor: '',
      nu_rg: '',
      dt_nascimento: '',
      st_estrangeiro: '',
      co_endereco: '',
      ds_email: '',
      ds_email_confirmacao: '',
      co_ibge: '',
      anexos: {
        cpf: '',
        documento_identificacao: '',
      },
    },
  }),
  computed: {
    ...mapGetters({
      dadosInscricaoEleitor: 'eleitor/dadosInscricaoEleitor',
      estadosGetter: 'localidade/estadosGetter',
    }),
  },
  methods: {
    ...mapActions({
      enviarDadosEleitor: 'eleitor/enviarDadosEleitor',
    }),
    salvar() {
      this.enviarDadosEleitor(this.eleitor).then(() => {
        eventHub.$emit('eventoSucesso', 'Enviado com sucesso! Um email será enviado com os dados da inscrição.');
        this.$router.push('/');
      }).catch(() => {
        eventHub.$emit('eventoErro', 'Houve algum erro ao enviar a sua inscrição.');
        this.$router.push('/');
      });
    },
  },
  mounted() {
    if (!Object.entries(this.dadosInscricaoEleitor).length) {
      this.$router.push('/eleitor/inscricao');
    }
    this.listaUF = this.estadosGetter;
    this.eleitor = this.dadosInscricaoEleitor;
  },

};
</script>
