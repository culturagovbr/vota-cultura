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
            <v-container v-if="Object.keys(eleitorGetter).length > 0">
              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="eleitorGetter.nu_cpf"
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
                    v-model="eleitorGetter.no_nome"
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
                    v-model="eleitorGetter.nu_rg"
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
                    v-model="eleitorGetter.dt_nascimento"
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
                    v-model="eleitorGetter.ds_email"
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
                    v-model="eleitorGetter.st_estrangeiro"
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
                    v-model="eleitorGetter.co_ibge"
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
                <v-flex>
                  <v-checkbox
                    v-model="confirmacaoDadosDeInscricao"
                    :rules="[v => !!v || 'É necessário concordar para enviar!']"
                    label="Declaro que assumo total responsabilidade pela veracidade das informações
                    apresentadas em conformidade com o Edital de Chamada Pública para composição dos
                    representantes da sociedade civil no Conselho Nacional de Política Cultural no
                    triênio 2019/2022."
                    required
                  />
                </v-flex>
              </v-layout>
              <v-layout
                wrap
                align-center
              >
                <v-flex offset-xs3>
                  <v-btn
                    @click="voltar"
                  >
                    Cancelar
                  </v-btn>
                  <v-btn
                    :disabled="!confirmacaoDadosDeInscricao"
                    color="primary"
                    @click="abrirDialogo"
                  >
                    Confirmar
                  </v-btn>
                </v-flex>
              </v-layout>
            </v-container>
            <v-container v-else>
              <v-layout>
                <v-flex>
                  <v-alert
                    type="error"
                    :value="true"
                  >
                    É necessário preencher as informações do cadastro.
                  </v-alert>
                  <div class="mb-6">
                    <v-btn @click="voltar">
                      Voltar
                    </v-btn>
                  </div>
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
              @click="fecharDialogo"
            >
              Não
            </v-btn>

            <v-btn
              :disabled="formEnviado"
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
import { mapActions, mapGetters } from 'vuex';
import _ from 'lodash';
import { eventHub } from '@/event';


export default {
  name: 'RevisaoEleitor',
  data: () => ({
    formEnviado: false,
    dialog: false,
    confirmacaoDadosDeInscricao: false,
    listaUF: [],
    eleitor: {},
  }),
  computed: {
    ...mapGetters({
      eleitorGetter: 'eleitor/eleitor',
      estadosGetter: 'localidade/estados',
    }),
  },
  watch: {
    eleitorGetter(value) {
      this.eleitor = value;
    },
  },
  methods: {
    ...mapActions({
      enviarDadosEleitor: 'eleitor/enviarDadosEleitor',
    }),
    voltar() {
      this.$router.push({ name: 'Eleitor' });
    },
    salvar() {
      this.formEnviado = true;
      const eleitor = _.cloneDeep(this.eleitor);
      eleitor.dt_nascimento = this.formatarDataCarbon(eleitor.dt_nascimento);
      this.enviarDadosEleitor(eleitor).then(() => {
        eventHub.$emit(
          'eventoSucesso',
          'Enviado com sucesso! Um email será enviado com os dados da inscrição.',
        );
        this.eleitor = Object.assign({});
        this.$router.push('/');
      }).catch((response) => {
        eventHub.$emit(
          'eventoErro',
          response.response.data.message,
        );
        this.$router.push('/');
      }).finally(() => {
        this.formEnviado = false;
        this.fecharDialogo();
      });
    },
    abrirDialogo() {
      this.dialog = true;
    },
    fecharDialogo() {
      this.dialog = false;
    },
    formatarDataCarbon(data) {
      const dia = data.split('/')[0];
      const mes = data.split('/')[1];
      const ano = data.split('/')[2];

      return `${ano}-${(`0${mes}`).slice(-2)}-${(`0${dia}`).slice(-2)}`;
    },
  },
  mounted() {
    this.listaUF = this.estadosGetter;
    this.eleitor = this.eleitorGetter;
  },

};
</script>
