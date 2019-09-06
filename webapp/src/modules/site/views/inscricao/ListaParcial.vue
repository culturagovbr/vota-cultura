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
        <v-form
          ref="form"
          v-model="formularioValido"
          lazy-validation
        >
          <v-card>
            <v-tabs
              color="white"
              v-model="tp_inscricao"
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
                      :pagination.sync="pagination"
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
                        <td></td>
                        <td>{{ props.item.nu_cnpj }}</td>
                        <td>{{ props.item.no_orgao_gestor }}</td>
                        <td>
                          <v-chip dark color="primary">
                            {{ props.item.endereco.municipio.uf.no_uf }}
                          </v-chip>
                        </td>
                        <td>
                          <v-chip>
                            {{ props.item.endereco.municipio.uf.regiao.no_regiao }}
                          </v-chip>
                        </td>
                      </template>
                    </v-data-table>
                  </v-card-text>
                </v-card>
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
                      :pagination.sync="pagination"
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
                        <td></td>
                        <td>{{ props.item.nu_cnpj }}</td>
                        <td>{{ props.item.no_organizacao }}</td>
                        <td>
                          <v-chip dark color="primary">
                            {{ props.item.segmento.ds_detalhamento }}
                          </v-chip>
                        </td>
                      </template>
                    </v-data-table>
                  </v-card-text>
                </v-card>
              </v-tab-item>
            </v-tabs-items>
          </v-card>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'ListaParcialInscritos',
  data: () => ({
    loading: false,
    formularioValido: true,
    step: 1,
    pesquisar: '',
    tp_inscricao: null,
    pagination: {
      page: 1,
      rowsPerPage: 10,
    },
    totalItems: 0,
    headers: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'CNPJ',
        value: 'nu_cnpj',
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
        value: 'endereco.municipio.uf.regiao',
      },
    ],
    headers_organizacao: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'CNPJ',
        value: 'nu_cnpj',
      },
      {
        text: 'Nome da Organização ou Entidade',
        value: 'no_organizacao',
      },
      {
        text: 'Segmento',
        value: 'segmento.ds_detalhamento',
      },
    ],
  }),
  computed: {
    ...mapGetters({
      conselhosGetter: 'conselho/conselhos',
      organizacoesGetter: 'organizacao/organizacoes',
    }),
  },
  methods: {
    ...mapActions({
      obterConselhos: 'conselho/obterConselhos',
      obterOrganizacoes: 'organizacao/obterOrganizacoes',
    }),
  },
  mounted() {
    const self = this;
    self.loading = true;
    self.obterConselhos().finally(() => {
      self.loading = false;
    });
    self.obterOrganizacoes().finally(() => {
      self.loading = false;
    });
  },
};
</script>
