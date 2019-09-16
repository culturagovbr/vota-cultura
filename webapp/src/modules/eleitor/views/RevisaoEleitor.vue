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
              <eleitor-detalhes-inscricao-visualizacao />
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
import _ from 'lodash';
import { mapActions, mapGetters } from 'vuex';
import { eventHub } from '@/event';
import EleitorDetalhesInscricaoVisualizacao from './EleitorDetalhesInscricaoVisualizacao';

export default {
  name: 'RevisaoEleitor',
  components: {
    EleitorDetalhesInscricaoVisualizacao,
  },
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
      obterDadosEleitor: 'eleitor/obterDadosEleitor',
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
      const [dia, mes, ano] = data.split('/');

      return `${ano}-${(`0${mes}`).slice(-2)}-${(`0${dia}`).slice(-2)}`;
    },
  },
  mounted() {
    this.listaUF = this.estadosGetter;
    this.eleitor = this.eleitorGetter;
  },
};
</script>
