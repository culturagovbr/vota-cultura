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
                <v-chip color="success" v-if="organizacao.organizacaoHabilitacao.situacao_avaliacao == 'Habilitada'">
                  {{organizacao.organizacaoHabilitacao.situacao_avaliacao}}
                </v-chip>
                <v-chip color="warning" class="black--text"  v-else>
                  {{organizacao.organizacaoHabilitacao.situacao_avaliacao}}
                </v-chip>
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
                  Pontuação inicial:
                  <b>{{ organizacao.pontuacao }}</b>
                </v-chip>
              </v-badge>
            </v-scale-transition>
          </v-toolbar>
          <v-card-text>
            <v-container>
              <organizacao-detalhes-inscricao-visualizacao />
              <div v-if="organizacao.organizacaoHabilitacao">
                <v-layout>
                  <v-flex>
                    <div class="layout">
                      <div class="flex">
                        <div
                          class="v-input v-text-field v-input--is-label-active v-input--is-dirty v-input--is-disabled theme--light"
                        >
                          <div class="v-input__control">
                            <div class="v-input__slot">
                              <div class="v-text-field__slot">
                                <label
                                  aria-hidden="true"
                                  class="v-label v-label--active v-label--is-disabled theme--light"
                                  style="left: 0px; right: auto; position: absolute;"
                                >Resultado da habilitação</label>
                                <input
                                  aria-label="RG"
                                  disabled="disabled"
                                  type="text"
                                  maxlength="12"
                                  :value="organizacao.organizacaoHabilitacao.situacao_avaliacao"
                                  :class="parseInt(organizacao.organizacaoHabilitacao.st_avaliacao, 10) === 2 ? 'color : green--text' : ''"
                                >
                              </div>
                              <div class="v-input__append-inner">
                                <div class="v-input__icon v-input__icon--append">
                                  <i
                                    aria-hidden="true"
                                    class="v-icon v-icon--disabled material-icons theme--light"
                                  >gavel</i>
                                </div>
                              </div>
                            </div>
                            <div class="v-text-field__details">
                              <div class="v-messages theme--light">
                                <div class="v-messages__wrapper" />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </v-flex>
                </v-layout>
                <v-layout>
                  <v-flex>
                    <v-text-field
                      :value="organizacao.organizacaoHabilitacao.ds_parecer"
                      label="Parecer da etapa de habilitação"
                      append-icon="subject"
                      color="red"
                      disabled
                    />
                  </v-flex>
                </v-layout>
                <v-layout>
                  <v-flex>
                    <v-text-field
                      :value="organizacao.organizacaoHabilitacao.nu_nova_pontuacao"
                      label="Pontuação após análise"
                      append-icon="star"
                      disabled
                    />
                  </v-flex>
                </v-layout>
              </div>
            </v-container>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import OrganizacaoDetalhesInscricaoVisualizacao from './OrganizacaoDetalhesInscricaoVisualizacao';

export default {
  name: 'OrganizacaoDetalhesInscricao',
  components: {
    OrganizacaoDetalhesInscricaoVisualizacao,
  },
  props: {
    souAdministrador: {
      source: {
        type: Boolean,
        default: false,
      },
    },
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
