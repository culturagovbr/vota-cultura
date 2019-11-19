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
            Resultado parcial das votações
          </h3>
        </div>
        <h3 class="my-5" />

        <v-card>
          <v-tabs
            dark
            color="primary"
            centered
            v-model="aba"
          >
            <v-tabs-slider
              centered
              color="yellow"
            />
            <v-tab
              v-for="(regiao, index) in Object.keys(this.indicadosPorRegiao)"
              :key="index"
              :href="'#tab-' + index"
            >
              {{ toKebabCase(regiao) }}
            </v-tab>

            <v-tabs-items>
              <v-tab-item
                v-for="(indicados, indexRegiao) in Object.keys(this.indicadosPorRegiao)"
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
                        <td></td>
                        <td>{{ props.item.no_indicado }}</td>
                        <td>{{ props.item.numero_votos }}</td>
                        <td>{{ props.item.ranking_empatado }}</td>
                      </template>
                    </v-data-table>

                  </v-card-text>
                </v-card>
              </v-tab-item>
            </v-tabs-items>
          </v-tabs>
        </v-card>
      </v-card-text>
    </v-card>
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'VotacaoListaParcial',
  data: () => ({
    aba: 'tab-0',
    indicadosPorRegiao: [],
    candidato: {},
    nomeMae: '',
    usuario_ja_votou: false,
    dialog: false,
    loading: false,
    show: false,
    pesquisar: '',
    pagination: {
      rowsPerPage: 10,
      sortBy: 'ranking_empatado',
      descending: false,
    },
    totalItems: 0,
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
        value: 'numero_votos',
      },
      {
        text: 'Colocação',
        value: 'ranking_empatado',
      },
    ],
    regioes: [
      'sul',
      'sudeste',
      'centro-oeste',
      'norte',
      'nordeste',
    ],
  }),
  watch: {
    listaParcialRankingGetter(indicados) {
      this.indicadosPorRegiao = _.groupBy(
        indicados, indicado => _.snakeCase(indicado.no_regiao),
      );
    },
    aba() {
      this.pagination.page = 1;
    },
  },
  computed: {
    ...mapGetters({
      listaParcialRankingGetter: 'votacao/listaParcialRanking',
    }),
  },
  methods: {
    ...mapActions({
      obterListaParcialRanking: 'votacao/obterListaParcialRanking',
      notificarSucesso: 'app/setMensagemSucesso',
    }),
    toKebabCase(string) {
      return _.kebabCase(string);
    },
  },
  mounted() {
    this.loading = true;
    this.obterListaParcialRanking().finally(() => {
      this.loading = false;
    });
  },
};
</script>
