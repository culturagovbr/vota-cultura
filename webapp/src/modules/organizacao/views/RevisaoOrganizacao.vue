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
              <!--<v-container>-->
              <organizacao-detalhes-inscricao-visualizacao />
              <v-checkbox
                v-model="confirmacaoDadosDeInscricao"
                :rules="[v => !!v || 'É necessário concordar para enviar!']"
                label=" Declaro ser representante da organização ou entidade cultural inscrita neste edital e designado (a) para o fornecimento das informações solicitadas e que assumo total responsabilidade pela veracidade das informações apresentadas.

Declaro estar ciente de que qualquer inexatidão nos itens informados me sujeitará às penalidades previstas no Art. 299 do código penal brasileiro, sem prejuízo de outras medidas administrativas e legais cabíveis."
              />

              <v-layout
                wrap
                align-center
              >
                <v-flex offset-xs4>
                  <v-btn
                    @click="voltar"
                  >
                    Voltar
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
import OrganizacaoDetalhesInscricaoVisualizacao from './OrganizacaoDetalhesInscricaoVisualizacao';

export default {
  name: 'RevisaoOrganizacao',
  components: {
    OrganizacaoDetalhesInscricaoVisualizacao,
  },
  data: () => ({
    confirmacaoDadosDeInscricao: false,
    dialog: false,
    listaUF: [],
    listaSegmentos: [],
    listaMunicipios: [],
    listaCriterios: [],
    organizacao: {},
  }),
  computed: {
    ...mapGetters({
      estadosGetter: 'localidade/estados',
      municipiosGetter: 'localidade/municipios',
      segmentosGetter: 'organizacao/segmentos',
      criteriosGetter: 'organizacao/criterios',
      organizacaoGetter: 'organizacao/organizacao',
    }),
  },
  watch: {
    criteriosGetter() {
      const criterios = _.groupBy(
        this.criteriosGetter, criterio => criterio.tp_criterio,
      );
      this.listaCriterios = criterios;
    },
    organizacaoGetter(value) {
      this.organizacao = value;
      this.obterMunicipios(this.organizacao.co_ibge);
    },

  },
  methods: {
    ...mapActions({
      obterEstados: 'localidade/obterEstados',
      obterMunicipios: 'localidade/obterMunicipios',
      obterCriterios: 'organizacao/obterCriterios',
      obterSegmentos: 'organizacao/obterSegmentos',
      enviarDadosOrganizacao: 'organizacao/enviarDadosOrganizacao',
    }),
    voltar() {
      this.$router.push({ name: 'Organizacao' });
    },
    salvar() {
      this.enviarDadosOrganizacao(this.organizacaoGetter).then(() => {
        eventHub.$emit(
          'eventoSucesso',
          'Enviado com sucesso! Um email será enviado com os dados da inscrição.',
        );
        this.organizacao = Object.assign({});
        this.$router.push('/');
      }).catch((response) => {
        eventHub.$emit(
          'eventoErro',
          response.response.data.message,
        );
        this.$router.push('/');
      }).finally(() => {
        this.fecharDialogo();
      });
    },
    abrirDialogo() {
      this.dialog = true;
    },
    fecharDialogo() {
      this.dialog = false;
    },
  },
  mounted() {
    this.obterSegmentos();
    this.obterCriterios();
    this.listaUF = this.estadosGetter;
    this.listaMunicipios = this.municipiosGetter;
    this.listaSegmentos = this.segmentosGetter;
    this.organizacao = this.organizacaoGetter;
  },
};
</script>
