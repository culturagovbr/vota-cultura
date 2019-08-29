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
            <v-container>
              <eleitor-detalhes-inscricao-visualizacao />
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
import EleitorDetalhesInscricaoVisualizacao from './EleitorDetalhesInscricaoVisualizacao';

export default {
  name: 'EleitorDetalhesInscricao',
  components: {
    EleitorDetalhesInscricaoVisualizacao,
  },
  data: () => ({
    usuarioLogado: {},
  }),
  computed: {
    ...mapGetters({
      usuario: 'conta/usuario',
    }),
  },
  watch: {
    usuario(valor) {
      this.usuarioLogado = valor;
    },
    usuarioLogado(usuario) {
      if (usuario.co_eleitor) {
        this.obterDadosEleitor(usuario.co_eleitor);
      }
    },
  },
  methods: {
    ...mapActions({
      obterDadosEleitor: 'eleitor/obterDadosEleitor',
    }),
  },
  mounted() {
    this.usuarioLogado = this.usuario;
  },

};
</script>
