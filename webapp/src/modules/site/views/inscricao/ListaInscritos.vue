<template>
  <v-container>
    <v-card>
      <v-tabs
        v-model="tp_inscricao"
        color="white"
        centered
        icons-and-text
      >
        <v-tabs-slider />
        <v-tab href="#conselho">
          Conselho
          <v-icon>group</v-icon>
        </v-tab>
        <v-tab href="#organizacao">
          Organização ou Entidade
          <v-icon>color_lens</v-icon>
        </v-tab>
      </v-tabs>
      <v-tabs-items v-model="tp_inscricao">
        <v-tab-item value="conselho">
          <conselho-lista :sou-administrador="souAdministrador"/>
        </v-tab-item>
        <v-tab-item value="organizacao">
          <organizacao-lista :sou-administrador="souAdministrador"/>
        </v-tab-item>
      </v-tabs-items>
    </v-card>

    <v-dialog
      v-model="mostrarModalConselho"
      fullscreen
      hide-overlay
      persistent
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-toolbar
          dark
          color="primary"
        >
          <v-btn
            icon
            dark
            @click="fecharModalConselho"
          >
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>
            Visualizar inscrição
          </v-toolbar-title>
          <v-spacer />

        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-card>
              <v-card-text>
                <conselho-detalhes-inscricao-visualizacao/>
              </v-card-text>
              <v-card-actions class="justify-center">
                <v-btn
                  @click="fecharModalConselho"
                >
                  <v-icon left>
                    undo
                  </v-icon>
                  Fechar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="mostrarModalOrganizacao"
      fullscreen
      persistent
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-toolbar
          dark
          color="primary"
        >
          <v-btn
            icon
            dark
            @click="fecharModalOrganizacao"
          >
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>
            Visualizar inscrição
          </v-toolbar-title>
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
                <b>{{ organizacaoGetter.pontuacao }}</b>
              </v-chip>
            </v-badge>
          </v-scale-transition>

        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-card>
              <v-card-text>
                <organizacao-detalhes-inscricao-visualizacao/>
              </v-card-text>
              <v-card-actions class="justify-center">
                <v-btn
                  @click="fecharModalOrganizacao"
                >
                  <v-icon left>
                    undo
                  </v-icon>
                  Fechar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import OrganizacaoDetalhesInscricaoVisualizacao from '@/modules/organizacao/views/OrganizacaoDetalhesInscricaoVisualizacao';
import ConselhoDetalhesInscricaoVisualizacao from '@/modules/conselho/views/ConselhoDetalhesInscricaoVisualizacao';
import ConselhoLista from '@/modules/conselho/views/ConselhoLista';
import OrganizacaoLista from '@/modules/organizacao/views/OrganizacaoLista';

export default {
  name: 'ListaInscritos',
  components: {
    ConselhoDetalhesInscricaoVisualizacao,
    OrganizacaoDetalhesInscricaoVisualizacao,
    ConselhoLista,
    OrganizacaoLista,
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
    tipoModal: '',
    loading: false,
    step: 1,
    pesquisar: '',
    tp_inscricao: null,
  }),
  computed: {
    ...mapGetters({
      organizacaoGetter: 'organizacao/organizacao',
      mostrarModalOrganizacao: 'organizacao/modalVisualizacaoOrganizacaoAdministrador',
      mostrarModalConselho: 'conselho/modalVisualizacaoConselhoAdministrador',
    }),
  },
  methods: {
    ...mapActions({
      obterDadosOrganizacao: 'organizacao/obterDadosOrganizacao',
      obterDadosConselho: 'conselho/obterDadosConselho',
      modalVisualizacaoOrganizacaoAdministrador: 'organizacao/modalVisualizacaoOrganizacaoAdministrador',
      modalVisualizacaoConselhoAdministrador: 'conselho/modalVisualizacaoConselhoAdministrador',
    }),
    fecharModalOrganizacao() {
      this.modalVisualizacaoOrganizacaoAdministrador(false);
    },
    fecharModalConselho() {
      this.modalVisualizacaoConselhoAdministrador(false);
    },
  },
};
</script>
