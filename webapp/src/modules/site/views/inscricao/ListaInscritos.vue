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
          <conselho-lista />
        </v-tab-item>
        <v-tab-item value="organizacao">
          <v-card>
            <v-card-title>
              <v-spacer />
              <v-text-field
                v-model="pesquisar"
                append-icon="search"
                label="Pesquisar"
                single-line
                hide-details
              />
              <v-spacer />
            </v-card-title>
            <v-card-text class="pa-0">
              <v-data-table
                :headers="headers_organizacao"
                :items="organizacoesGetter"
                :pagination.sync="pagination_organizacao"
                :total-items="totalItems"
                :loading="loading"
                :search="pesquisar"
                item-key="co_usuario"
                class="elevation-1"
              >
                <template
                  slot="items"
                  slot-scope="props"
                >
                  <td />
                  <td>{{ props.item.nu_cnpj_mascarado }}</td>
                  <td>{{ props.item.no_organizacao }}</td>
                  <td>
                    <v-chip
                      dark
                      color="primary"
                    >
                      {{ props.item.segmento.ds_detalhamento }}
                    </v-chip>
                  </td>
                  <td>{{ props.item.pontuacao }}</td>
                  <td v-if="souAdministrador">
                    <v-btn
                      depressed
                      outline
                      icon
                      fab
                      dark
                      color="primary"
                      small
                      @click="visualizarItemModal('organizacao', props.item.co_organizacao)"
                    >
                      <v-icon>search</v-icon>
                    </v-btn>
                  </td>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card>

    <v-dialog
      v-model="mostrarModal"
      fullscreen
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
            @click="mostrarModal = false"
          >
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>
            Visualizar inscrição
          </v-toolbar-title>
          <v-spacer />

          <v-scale-transition
            v-if="tipoModal === 'organizacao'"
          >
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
                <organizacao-detalhes-inscricao-visualizacao v-if="tipoModal === 'organizacao'"/>
                <conselho-detalhes-inscricao-visualizacao v-if="tipoModal === 'conselho'"/>
              </v-card-text>
              <v-card-actions class="justify-center">
                <v-btn
                  @click="mostrarModal = false"
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
import OrganizacaoDetalhesInscricaoVisualizacao from '@/modules/organizacao/views/OrganizacaoDetalhesInscricaoVisualizacao.vue';
import ConselhoDetalhesInscricaoVisualizacao from '@/modules/conselho/views/ConselhoDetalhesInscricaoVisualizacao.vue';
import ConselhoLista from '@/modules/conselho/views/ConselhoLista.vue';

export default {
  name: 'ListaInscritos',
  components: {
    ConselhoDetalhesInscricaoVisualizacao,
    OrganizacaoDetalhesInscricaoVisualizacao,
    ConselhoLista,
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
    mostrarModal: false,
    loading: false,
    formularioValido: true,
    step: 1,
    pesquisar: '',
    tp_inscricao: null,
    pagination_organizacao: {
      page: 1,
      rowsPerPage: 10,
      sortBy: 'no_organizacao',
      descending: false,
    },

    totalItems: 0,

    headers_organizacao: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'CNPJ',
        value: 'nu_cnpj_mascarado',
      },
      {
        text: 'Nome da Organização ou Entidade',
        value: 'no_organizacao',
      },
      {
        text: 'Segmento',
        value: 'segmento.ds_detalhamento',
      },
      {
        text: 'Pontuação',
        value: 'pontuacao',
      },
    ],
  }),
  computed: {
    ...mapGetters({
      organizacoesGetter: 'organizacao/organizacoes',
      organizacaoGetter: 'organizacao/organizacao',
    }),
  },
  methods: {
    ...mapActions({
      obterOrganizacoes: 'organizacao/obterOrganizacoes',
      obterDadosOrganizacao: 'organizacao/obterDadosOrganizacao',
      obterDadosConselho: 'conselho/obterDadosConselho',
    }),
    visualizarItemModal(tipoInscricao, id) {
      this.mostrarModal = true;
      this.tipoModal = tipoInscricao;
      if (tipoInscricao === 'organizacao') {
        this.obterDadosOrganizacao(id);
        return false;
      }

      if (tipoInscricao === 'conselho') {
        this.obterDadosConselho(id);
        return false;
      }

      return true;
    },
  },
  mounted() {
    const self = this;

    self.loading = true;
    self.obterOrganizacoes().finally(() => {
      self.loading = false;
    });
    if (!!this.souAdministrador) {
      this.headers_organizacao.push({
        text: 'Ações',
        sortable: false,
      });
    }
  },
};
</script>
