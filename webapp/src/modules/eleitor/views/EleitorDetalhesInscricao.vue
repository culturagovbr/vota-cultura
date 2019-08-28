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
            <v-toolbar-title>{{ $route.meta.title }}</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-container v-if="Object.keys(eleitorGetter).length > 0">
              <eleitor-detalhes-inscricao-visualizacao/>
            </v-container>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import _ from 'lodash';
import { mapActions, mapGetters } from 'vuex';
import { eventHub } from '@/event';
import EleitorDetalhesInscricaoVisualizacao from './EleitorDetalhesInscricaoVisualizacao';

export default {
  name: 'EleitorDetalhesInscricao',
  components: {
    EleitorDetalhesInscricaoVisualizacao,
  },
  data: () => ({
    formEnviado: false,
    dialog: false,
    confirmacaoDadosDeInscricao: false,
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
    this.eleitor = this.eleitorGetter;


    // apagar
    this.obterDadosEleitor(1);
  },

};
</script>
