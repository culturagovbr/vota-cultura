<template>
  <v-container
    grid-list-xs
    fluid
  >
    <v-card class="elevation-1 pa-3 login-card">
      <v-card-text>
        <div class="layout column align-center">
          <h2 class="flex my-2 primary--text">
            {{ $route.meta.title }}
          </h2>
          <h3 class="flex primary--text">
            Conselho de cultura
          </h3>
        </div>
        <h3 class="my-5" />

        <v-card v-if="!!Object.keys(indicadosPorRegiao).length">
          <v-tabs
            v-model="aba"
            dark
            color="primary"
            centered
          >
            <v-tabs-slider
              centered
              color="yellow"
            />
            <v-tab
              v-for="(regiao, index) in Object.keys(indicadosPorRegiao)"
              :key="index"
              :href="'#tab-' + index"
            >
              {{ toKebabCase(regiao) }}
            </v-tab>

            <v-tabs-items>
              <v-tab-item
                v-for="(indicados, indexRegiao) in Object.keys(indicadosPorRegiao)"
                :key="indexRegiao"
                :value="'tab-' + indexRegiao"
              >
                <v-card flat>
                  <v-card-text>
                    <v-data-table
                      :headers="headers"
                      :items="indicadosPorRegiao[indicados]"
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
                        <td />
                        <td>{{ props.item.no_indicado }}</td>
                        <td>{{ props.item.nu_votos }}</td>
                        <td>{{ props.item.nu_ranking}}</td>
                      </template>
                    </v-data-table>
                  </v-card-text>
                </v-card>
              </v-tab-item>
            </v-tabs-items>
          </v-tabs>
        </v-card>
        <v-card v-else>
          não publicado
        </v-card>
      </v-card-text>
    </v-card>
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'VotacaoResultado',
  data: () => ({
    headers: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'Nome do indicado',
        value: 'no_indicado',
      },
      {
        text: 'Número de votos',
        value: 'nu_votos',
      },
      {
        text: 'Colocação',
        value: 'nu_ranking',
      },
    ],
    loading: false,
    show: false,
    rowsPerPageItems: [4, 8, 12],
    pagination: {
      rowsPerPage: 10,
      descending: false,
      sortBy: 'nu_ranking',
    },
    indicadosPorRegiao: [],
  }),
  watch: {
    listaFinalRankingGetter(indicados) {
      this.indicadosPorRegiao = _.groupBy(
        indicados, indicado => _.snakeCase(indicado.no_regiao),
      );
    },
  },
  computed: {
    ...mapGetters({
      listaFinalRankingGetter: 'votacao/listaFinalRanking',
    }),
  },
  methods: {
    ...mapActions({
      obterListaFinalRanking: 'votacao/obterListaFinalRanking',
      notificarSucesso: 'app/setMensagemSucesso',
    }),
    toKebabCase(string) {
      return _.kebabCase(string);
    },
  },
  mounted() {
    this.loading = true;
    this.obterListaFinalRanking().finally(() => {
      this.loading = false;
    });
  },
};
</script>
