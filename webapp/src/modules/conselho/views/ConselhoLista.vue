<template>
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
        :headers="headers"
        :items="conselhosGetter"
        :pagination.sync="pagination_conselho"
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
          <td>{{ props.item.cnpj_formatado }}</td>
          <td>{{ props.item.no_conselho }}</td>
          <td>
            <v-chip
              dark
              color="primary"
            >
              {{ props.item.endereco.municipio.uf.no_uf }}
            </v-chip>
          </td>
          <td>
            <v-chip>
              {{ props.item.endereco.municipio.uf.regiao.no_regiao }}
            </v-chip>
          </td>
          <td v-if="souAdministrador">
            <v-btn
              depressed
              outline
              icon
              fab
              dark
              color="primary"
              small
              @click="visualizarItemModal('conselho', props.item.co_conselho)"
            >
              <v-icon>search</v-icon>
            </v-btn>
          </td>
        </template>
      </v-data-table>
    </v-card-text>
    <!--<v-container>-->
      <!--<v-card>-->
        <!--<v-card-text>-->
          <!--<conselho-detalhes-inscricao-visualizacao v-if="tipoModal === 'conselho'"/>-->
        <!--</v-card-text>-->
        <!--<v-card-actions class="justify-center">-->
          <!--<v-btn-->
            <!--@click="mostrarModal = false"-->
          <!--&gt;-->
            <!--<v-icon left>-->
              <!--undo-->
            <!--</v-icon>-->
            <!--Fechar-->
          <!--</v-btn>-->
        <!--</v-card-actions>-->
      <!--</v-card>-->
    <!--</v-container>-->
  </v-card>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import ConselhoDetalhesInscricaoVisualizacao from '@/modules/conselho/views/ConselhoDetalhesInscricaoVisualizacao.vue';

export default {
  name: 'ConselhoLista',
  components: {
    ConselhoDetalhesInscricaoVisualizacao,
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
    pesquisar: '',
    tipoModal: '',
    mostrarModal: false,
    loading: false,
    pagination_conselho: {
      page: 1,
      rowsPerPage: 10,
      sortBy: 'no_conselho',
      descending: false,
    },
    totalItems: 0,
    headers: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'CNPJ',
        value: 'cnpj_formatado',
      },
      {
        text: 'Nome do conselho',
        value: 'no_conselho',
      },
      {
        text: 'UF',
        value: 'endereco.municipio.uf.no_uf',
      },
      {
        text: 'Região',
        value: 'endereco.municipio.uf.regiao.no_regiao',
      },
    ],
  }),
  computed: {
    ...mapGetters({
      conselhosGetter: 'conselho/conselhos',
    }),
  },
  methods: {
    ...mapActions({
      obterConselhos: 'conselho/obterConselhos',
      obterDadosConselho: 'conselho/obterDadosConselho',
    }),
    visualizarItemModal(tipoInscricao, id) {
      this.mostrarModal = true;
      this.tipoModal = tipoInscricao;

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
    self.obterConselhos().finally(() => {
      self.loading = false;
    });
    if (!!this.souAdministrador) {
      this.headers.push({
        text: 'Ações',
        sortable: false,
      });
    }
  },
};
</script>
