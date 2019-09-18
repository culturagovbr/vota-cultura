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
          <td>{{ props.item.nu_cnpj_mascarado }}</td>
          <td>{{ props.item.no_orgao_gestor }}</td>
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
  </v-card>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'ConselhoLista',
  data: () => ({
    pagination_conselho: {
      page: 1,
      rowsPerPage: 10,
      sortBy: 'no_orgao_gestor',
      descending: false,
    },
    headers: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'CNPJ',
        value: 'nu_cnpj_mascarado',
      },
      {
        text: 'Nome Conselho',
        value: 'no_orgao_gestor',
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
    }),
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
