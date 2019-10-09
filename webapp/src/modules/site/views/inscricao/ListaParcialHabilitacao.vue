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
          </v-tabs>
          <v-tabs-items v-model="tp_inscricao">
            <v-tab-item value="conselho">
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
                        <v-chip
                          dark
                          color="primary"
                        >
                          {{ props.item.conselhoHabilitacao.ds_avaliacao }}
                        </v-chip>
                      </td>
                    </template>
                  </v-data-table>
                </v-card-text>
              </v-card>
            </v-tab-item>
          </v-tabs-items>
        </v-card>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'ListaParcialHabilitacao',
  data() {
    return {
      tp_inscricao: null,
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
          text: 'CNPJ do órgão gestor do conselho',
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
        {
          text: 'Resultado final da habilitação',
          value: 'conselhoHabilitacao.ds_avaliacao',
        },
      ],
    };
  },
  computed: {
    ...mapGetters({
      conselhosGetter: 'conselho/conselhos',
      conselhosParcialmenteHabilitadosGetter: 'conselho/conselhosParcialmenteHabilitados',
    }),
  },
  methods: {
    ...mapActions({
      obterConselhos: 'conselho/obterConselhos',
      obterConselhosParcialmenteHabilitados: 'conselho/obterConselhosParcialmenteHabilitados',
    }),
  },
  mounted() {
    const self = this;

    self.loading = true;
    self.obterConselhosParcialmenteHabilitados().finally(() => {
      self.loading = false;
    });
  },
};
</script>
