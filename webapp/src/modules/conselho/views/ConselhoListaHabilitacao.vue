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
                        <v-icon v-if="props.item.conselhoHabilitacao === null">gavel</v-icon>
                        <v-icon v-else>remove_red_eye</v-icon>
                      </v-btn>
                    </template>
                    <span v-if="props.item.conselhoHabilitacao === null">Avaliar</span>
                    <span v-else>Visualizar</span>
                  </v-tooltip>
                </td>
              </template>
            </v-data-table>
            <conselho-lista-habilitacao-dialog
              v-model="mostrarModalEdicao"
              :conselho="itemEditado"
            />
          </v-card-text>
        </v-card>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ConselhoListaHabilitacaoDialog from './ConselhoListaHabilitacaoDialog';

export default {
  name: 'ConselhoLista',
  components: {
    ConselhoListaHabilitacaoDialog,
  },
  data: () => ({
    loading: true,
    pesquisar: '',
    itemEditado: {},
    totalItems: 0,
    mostrarModalEdicao: false,
    pagination_conselho: {
      page: 1,
      rowsPerPage: 10,
      sortBy: 'no_conselho',
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
  watch:{
    mostrarModalEdicao(valor){
      if(!valor){
        this.itemEditado = Object.assign({});
      }
    }
  },
  computed: {
    ...mapGetters({
      conselhosGetter: 'conselho/conselhos',
    }),
  },
  methods: {
    ...mapActions({
      obterConselhosHabilitacao: 'conselho/obterConselhosHabilitacao',
    }),
    editarItemModal(item) {
      this.itemEditado = item;
      this.mostrarModalEdicao = true;
    },
  },
  mounted() {
    const self = this;
    self.loading = true;
    self.obterConselhosHabilitacao().finally(() => {
      self.loading = false;
    });
    this.headers.push({
      text: 'Ações',
      sortable: false,
    });
  },
};
</script>
