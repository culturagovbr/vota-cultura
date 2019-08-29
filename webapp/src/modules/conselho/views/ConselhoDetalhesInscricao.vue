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
            <v-container v-if="Object.keys(conselhoGetter).length > 0">
              <conselho-detalhes-inscricao-visualizacao />
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
import ConselhoDetalhesInscricaoVisualizacao from './ConselhoDetalhesInscricaoVisualizacao';

export default {
  name: 'ConselhoDetalhesInscricao',
  components: {
    ConselhoDetalhesInscricaoVisualizacao,
  },
  data: () => ({
    conselho: {},
    usuarioLogado: {},
  }),
  computed: {
    ...mapGetters({
      conselhoGetter: 'conselho/conselho',
      usuario: 'conta/usuario',
    }),
  },
  watch: {
    conselhoGetter(value) {
      this.conselho = value;
    },
    usuario(valor) {
      this.usuarioLogado = valor;
    },
    usuarioLogado(usuario) {
      if (usuario.co_conselho) {
        this.obterDadosConselho(usuario.co_conselho);
      }
    },
  },
  methods: {
    ...mapActions({
      obterDadosConselho: 'conselho/obterDadosConselho',
    }),
    formatarDataCarbon(data) {
      const [dia, mes, ano] = data.split('/');

      return `${ano}-${(`0${mes}`).slice(-2)}-${(`0${dia}`).slice(-2)}`;
    },
  },
  mounted() {
    this.conselho = this.conselhoGetter;
    this.usuarioLogado = this.usuario;
  },

};
</script>
