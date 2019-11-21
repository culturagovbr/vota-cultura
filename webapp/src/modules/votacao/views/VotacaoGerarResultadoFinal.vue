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
              v-for="(regiao, index) in Object.keys(this.indicadosPorRegiao)"
              :key="index"
              :href="'#tab-' + index"
            >
              {{ toKebabCase(regiao) }}
            </v-tab>

            <v-tabs-items>
              <v-tab-item
                v-for="regiao, indexRegiao) in Object.keys(this.indicadosPorRegiao)"
                :key="indexRegiao"
                :value="'tab-' + indexRegiao"
              >
                <v-card flat>
                  <v-container
                    v-if="!empates[regiao]"
                    style="max-width: 800px;"
                  >
                    <v-layout>
                      <v-timeline dense>
                        <v-timeline-item
                          v-for="posicao in 4"
                          class="white--text"
                          color="green"
                          large
                        >
                          <template v-slot:icon>
                            <span>{{ posicao }}º</span>
                          </template>
                          <v-card class="elevation-2">
                            <v-card-title class="headline">
                              {{ rankingIndicados[regiao][posicao][0].no_indicado }}

                              <v-spacer />

                              <v-chip
                                dark
                                color="primary"
                                text-color="white"
                              >
                                {{ posicao < 3 ? 'Titular': 'Suplente' }}
                                <v-icon right>
                                  account_circle
                                </v-icon>
                              </v-chip>
                            </v-card-title>
                            <v-card-text style="width: 680px;">
                              {{ rankingIndicados[regiao][posicao][0].numero_votos }} votos
                            </v-card-text>
                          </v-card>
                        </v-timeline-item>
                      </v-timeline>
                    </v-layout>
                  </v-container>
                  <v-container
                    v-else
                    style="max-width: 800px;"
                  >
                    <v-layout>
                      <!--<pre>-->
                      <!--{{ indicadosParaDesempate }}-->
                      <!--</pre>-->
                      <v-timeline dense>
                        <v-timeline-item
                          v-for="(indicado, index) in indicadosParaDesempate[regiao]"
                          class="white--text"
                          :color="index < 4 ? 'green': 'red'"
                          large
                        >
                          <template v-slot:icon>
                            <span
                              v-if="index < 4"
                            >
                              {{ index+1 }}º
                            </span>
                          </template>
                          <v-card class="elevation-2">
                            <v-card-title class="headline">
                              {{ indicado.no_indicado }}
                            </v-card-title>
                            <v-card-text style="width: 680px;">
                              {{ indicado.numero_votos }} Votos
                            </v-card-text>
                            <v-card-actions
                              v-if="indicado.pode_mover"
                              class="justify-center"
                            >
                              <v-btn
                                v-if="index !== 0 && indicadosParaDesempate[regiao][index-1].ranking_empatado == indicado.ranking_empatado"
                                small
                                flat
                                @click="alterarColocacao(regiao, index, 'subir')"
                              >
                                <v-icon>
                                  keyboard_arrow_up
                                </v-icon>
                              </v-btn>

                              <v-btn
                                v-if="indicadosParaDesempate[regiao].length-1 !== index && indicadosParaDesempate[regiao][index+1].ranking_empatado == indicado.ranking_empatado"
                                small
                                flat
                                @click="alterarColocacao(regiao, index, 'descer')"
                              >
                                <v-icon>
                                  keyboard_arrow_down
                                </v-icon>
                              </v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-timeline-item>
                      </v-timeline>
                    </v-layout>
                  </v-container>
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
  name: 'VotacaoGerarResultadoFinal',
  data: () => ({
    aba: 'tab-0',
    rankingIndicados: {},
    indicadosPorRegiao: [],
    indicadosParaDesempate: {},
    empates: {},
    candidato: {},
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
  }),
  watch: {
    listaParcialRankingGetter(indicados) {
      // remover do backend o trem de limitar pelo 4 lugar
      this.indicadosPorRegiao = _.groupBy(
        indicados, indicado => _.snakeCase(indicado.no_regiao),
      );

      Object.keys(this.indicadosPorRegiao).forEach((regiao) => {
        this.rankingIndicados[regiao] = _.groupBy(
          this.indicadosPorRegiao[regiao], indicado => indicado.ranking_empatado,
        );
      });

      Object.keys(this.rankingIndicados).forEach((regiao) => {
        Object.keys(this.rankingIndicados[regiao]).forEach((colocacao) => {
          if (this.rankingIndicados[regiao][colocacao].length > 1) {
            this.empates[regiao] = true;
          }
        });
      });

      Object.keys(this.rankingIndicados).forEach((regiao) => {
        if (this.empates[regiao]) {
          Object.keys(this.rankingIndicados[regiao]).forEach((colocacao) => {
            if (this.rankingIndicados[regiao][colocacao].length > 1) {
              this.rankingIndicados[regiao][colocacao].forEach((indicado) => {
                indicado.pode_mover = true;
                (this.indicadosParaDesempate[regiao] || (this.indicadosParaDesempate[regiao] = [])).push(indicado);
              });
            } else {
              (this.indicadosParaDesempate[regiao] || (this.indicadosParaDesempate[regiao] = []))
                .push(this.rankingIndicados[regiao][colocacao][0]);
            }
          });
        }
      });
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
    alterarColocacao(regiao, key, direcao) {
      let offset = direcao === 'descer' ? 1 : -1;
      let swappedItem = this.indicadosParaDesempate[regiao][key + offset];
      this.indicadosParaDesempate[regiao][key + offset] = this.indicadosParaDesempate[regiao][key];
      this.indicadosParaDesempate[regiao][key] = swappedItem;
      const copiaIndicados = this.indicadosParaDesempate;
      this.indicadosParaDesempate = {};
      this.indicadosParaDesempate = copiaIndicados;
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
