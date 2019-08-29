<template>
  <v-container>
    <v-layout wrap>
      <v-flex
        offset-xs1
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
      if (usuario.co_conselho) {
        this.obterDadosConselho(usuario.co_conselho);
      }
    },
  },
  methods: {
    ...mapActions({
      obterDadosConselho: 'conselho/obterDadosConselho',
    }),
  },
  mounted() {
    this.usuarioLogado = this.usuario;
  },

};
</script>
