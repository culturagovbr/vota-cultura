<template>
  <v-container>
    <v-layout wrap>
      <v-flex
        offset-xs1
      >
        <card-carregando v-if="isLoading" />
        <v-card
          v-if="!isLoading"
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
              <div v-if="dadosHabilitacao">
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
                                  :value="!parseInt(dadosHabilitacao.st_avaliacao, 10) ? 'Inabilitado' : 'Habilitado'"
                                  :class="!parseInt(dadosHabilitacao.st_avaliacao, 10) ? 'color : red--text' : 'color : green--text'"
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
                      :value="dadosHabilitacao.ds_parecer"
                      label="Parecer da etapa de habilitação"
                      append-icon="subject"
                      disabled
                      color="red"
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
import _ from 'lodash';
import { mapActions, mapGetters } from 'vuex';
import ConselhoDetalhesInscricaoVisualizacao from './ConselhoDetalhesInscricaoVisualizacao';
import CardCarregando from '@/modules/shared/components/CardCarregando';

export default {
  name: 'ConselhoDetalhesInscricao',
  components: {
    ConselhoDetalhesInscricaoVisualizacao,
    CardCarregando,
  },
  data: () => ({
    usuarioLogado: {},
    dadosHabilitacao: {},
    isLoading: true,
  }),
  computed: {
    ...mapGetters({
      usuario: 'conta/usuario',
      conselhoGetter: 'conselho/conselho',
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
    conselhoGetter(valor) {
      this.dadosHabilitacao = valor.conselhoHabilitacao;
      this.isLoading = false;
    },
  },
  methods: {
    ...mapActions({
      obterDadosConselho: 'conselho/obterDadosConselho',
    }),
  },
  mounted() {
    this.usuarioLogado = this.usuario;
    if ((this.conselhoGetter || {}).conselhoHabilitacao) {
      this.dadosHabilitacao = this.conselhoGetter.conselhoHabilitacao;
    }
  },
};
</script>
