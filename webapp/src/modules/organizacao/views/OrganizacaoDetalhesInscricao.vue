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
            <v-spacer />
            <v-scale-transition>
              <v-badge
                overlap
                color="orange"
              >
                <template v-slot:badge>
                  <v-icon
                    dark
                    small
                  >
                    star
                  </v-icon>
                </template>
                <v-chip>
                  Pontuação:
                  <b>{{ organizacao.pontuacao }}</b>
                </v-chip>
              </v-badge>
            </v-scale-transition>
          </v-toolbar>
          <v-card-text>
            <v-container>
              <organizacao-detalhes-inscricao-visualizacao />
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
import OrganizacaoDetalhesInscricaoVisualizacao from './OrganizacaoDetalhesInscricaoVisualizacao';

export default {
  name: 'OrganizacaoDetalhesInscricao',
  components: {
    OrganizacaoDetalhesInscricaoVisualizacao,
  },
  data: () => ({
    usuarioLogado: {},
    organizacao: {},
  }),
  computed: {
    ...mapGetters({
      usuario: 'conta/usuario',
      organizacaoGetter: 'organizacao/organizacao',
    }),
  },
  watch: {
    usuario(valor) {
      this.usuarioLogado = valor;
    },
    usuarioLogado(usuario) {
      if (usuario.co_organizacao) {
        this.obterDadosOrganizacao(usuario.co_organizacao);
      }
    },
    organizacaoGetter(value) {
      this.organizacao = value;
    },
  },
  methods: {
    ...mapActions({
      obterDadosOrganizacao: 'organizacao/obterDadosOrganizacao',
    }),
  },
  mounted() {
    this.usuarioLogado = this.usuario;
  },

};
</script>
