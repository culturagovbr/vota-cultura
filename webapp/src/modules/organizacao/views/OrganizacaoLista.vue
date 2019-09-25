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
          <td>{{ props.item.cnpj_formatado }}</td>
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
</template>
<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'OrganizacaoLista',
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
        value: 'cnpj_formatado',
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
    }),
  },
  methods: {
    ...mapActions({
      obterOrganizacoes: 'organizacao/obterOrganizacoes',
      obterDadosOrganizacao: 'organizacao/obterDadosOrganizacao',
    }),
    visualizarItemModal(tipoInscricao, id) {
      this.mostrarModal = true;
      this.tipoModal = tipoInscricao;

      if (tipoInscricao === 'organizacao') {
        this.obterDadosOrganizacao(id);
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
