<template>
  <v-container>
    <v-card class="elevation-1 pa-4 login-card">
      <v-card-title>
        <div class="layout column align-center">
          <h2 class="flex my-2 primary--text">
            {{ $route.meta.title }}
          </h2>
        </div>
      </v-card-title>
      <v-card-text>
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
                    {{ props.item.endereco.municipio.uf.no_uf }}
                  </v-chip>
                </td>
                <td>
                  <v-chip>
                    {{ props.item.endereco.municipio.uf.regiao.no_regiao }}
                  </v-chip>
                </td>
                <td>
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn
                        depressed
                        outline
                        icon
                        fab
                        dark
                        color="primary"
                        small
                        v-on="on"
                        @click="editarItemModal(props.item);"
                      >
                        <v-icon v-if="props.item.organizacaoHabilitacao === null">
                          gavel
                        </v-icon>
                        <v-icon v-else>
                          remove_red_eye
                        </v-icon>
                      </v-btn>
                    </template>
                    <span v-if="props.item.organizacaoHabilitacao === null">Avaliar</span>
                    <span v-else>Visualizar</span>
                  </v-tooltip>
                </td>
              </template>
            </v-data-table>
            <organizacao-lista-habilitacao-dialog
              v-model="mostrarModalEdicao"
              :organizacao="itemEditado"
            />
          </v-card-text>
        </v-card>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import OrganizacaoListaHabilitacaoDialog from './OrganizacaoListaHabilitacaoDialog';

export default {
  name: 'OrganizacaoLista',
  components: {
    OrganizacaoListaHabilitacaoDialog,
  },
  data: () => ({
    loading: true,
    pesquisar: '',
    itemEditado: {},
    totalItems: 0,
    mostrarModalEdicao: false,
    pagination_organizacao: {
      page: 1,
      rowsPerPage: 10,
      sortBy: 'no_organizacao',
      descending: false,
    },
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
        text: 'Nome do organizacao',
        value: 'no_organizacao',
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
  watch: {
    mostrarModalEdicao(valor) {
      if (!valor) {
        this.itemEditado = Object.assign({});
      }
    },
  },
  computed: {
    ...mapGetters({
      organizacoesGetter: 'organizacao/organizacoes',
    }),
  },
  methods: {
    ...mapActions({
      obterOrganizacoesHabilitacao: 'organizacao/obterOrganizacoesHabilitacao',
    }),
    editarItemModal(item) {
      this.itemEditado = item;
      this.mostrarModalEdicao = true;
    },
  },
  mounted() {
    const self = this;
    self.loading = true;
    self.obterOrganizacoesHabilitacao().finally(() => {
      self.loading = false;
    });
    this.headers.push({
      text: 'Ações',
      sortable: false,
    });
  },
};
</script>