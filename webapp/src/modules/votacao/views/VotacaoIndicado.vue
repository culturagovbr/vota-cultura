<template>
  <v-container grid-list-xs>
    <v-card class="elevation-1 pa-3 login-card">
      <v-card-text>
        <div class="layout column align-center">
          <h2 class="flex my-2 primary--text">
            {{ $route.meta.title }}
          </h2>
        </div>
        <v-layout
          wrap
          justify-center
          class="my-5"
        >
          <v-flex
            v-for="indicado in listarIndicacaoConselhoGetter"
            :key="indicado.co_conselho_indicacao"
            xs3
            class="ma-1 pa-2"
          >
            <v-hover>
              <!--slot-scope="{ hover }"-->
              <v-card
                class="mx-auto"
                max-width="600"
              >
                <!--:src="indicado.foto_indicado"-->
                <v-img
                  :aspect-ratio="5/4"
                />
                <v-card-text
                  class="pt-4"
                  style="position: relative;"
                >
                  <v-btn
                    style="z-index:0"
                    absolute
                    color="primary"
                    class="white--text"
                    fab
                    medium
                    right
                    top
                  >
                    <v-icon>check</v-icon>
                  </v-btn>

                  <h3 class="font-weight-light primary--text mb-2">
                    {{ indicado.no_indicado }} - Goiás
                  </h3>
                  <v-layout>
                    <v-flex>
                      <a
                        href="https://twitter.com/share"
                        class="twitter-share-button"
                        :data-url="`http://votacultura.cidadania.gov.br/votacao/${regiao}`"
                        data-lang="pt"
                        :data-text="`Vote em ${indicado.no_indicado} para compor o Conselho Nacional de Política Cultural (CNPC) no triênio 2019/2022`"
                        data-size="medium"
                        data-dnt="true"
                      >Tweetar</a>
                    </v-flex>
                    <v-flex>
                      <a
                        :href="`https://api.whatsapp.com/send?text=Vote em ${indicado.no_indicado} para compor o Conselho Nacional de Política Cultural (CNPC) no triênio 2019/2022. http://votacultura.cidadania.gov.br/votacao/${regiao}`"
                        target="_blank"
                      >
                        <img
                          src="/img/botao-whatsapp.png"
                          width="92"
                          height="20"
                        >
                      </a>
                    </v-flex>
                    <v-flex>
                      <div
                        id="fb-share-button"
                        @click="compartilharFacebook(indicado)"
                      >
                        <svg
                          viewBox="0 0 12 12"
                          preserveAspectRatio="xMidYMid meet"
                        >
                          <path
                            class="svg-icon-path"
                            d="M9.1,0.1V2H8C7.6,2,7.3,2.1,7.1,2.3C7,2.4,6.9,2.7,6.9,3v1.4H9L8.8,6.5H6.9V12H4.7V6.5H2.9V4.4h1.8V2.8 c0-0.9,0.3-1.6,0.7-2.1C6,0.2,6.6,0,7.5,0C8.2,0,8.7,0,9.1,0.1z"
                          />
                        </svg>
                        <span>Compartilhar</span>
                      </div>
                    </v-flex>
                  </v-layout>
                </v-card-text>
                <v-divider light />
                <v-card-actions class="pa-3">
                  <v-expansion-panel
                    popout
                  >
                    <v-expansion-panel-content class="font-weight-light mb-2">
                      <template v-slot:header>
                        <div>Defesa da candidatura:</div>
                      </template>
                      <v-card>
                        <v-card-text>
                          Mussum Ipsum, cacilds vidis litro abertis. Mé faiz elementum girarzis, nisi eros vermeio. In elementis mé pra quem é amistosis quis leo. Vehicula non. Ut sed ex eros. Vivamus sit amet nibh non tellus tristique interdum. Praesent malesuada urna nisi, quis volutpat erat hendrerit non. Nam vulputate dapibus.

                          Cevadis im ampola pa arma uma pindureta. Não sou faixa preta cumpadi, sou preto inteiris, inteiris. Quem manda na minha terra sou euzis! Nullam volutpat risus nec leo commodo, ut interdum diam laoreet. Sed non consequat odio.

                          Si num tem leite então bota uma pinga aí cumpadi! Suco de cevadiss, é um leite divinis, qui tem lupuliz, matis, aguis e fermentis. Mais vale um bebadis conhecidiss, que um alcoolatra anonimis. Tá deprimidis, eu conheço uma cachacis que pode alegrar sua vidis.

                          Per aumento de cachacis, eu reclamis. Copo furadis é disculpa de bebadis, arcu quam euismod magna. Manduma pindureta quium dia nois paga. Quem num gosta di mé, boa gentis num é.
                        </v-card-text>
                      </v-card>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-card-actions>
              </v-card>
            </v-hover>
          </v-flex>
        </v-layout>
      </v-card-text>
    </v-card>
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'VotacaoIndicado',
  data: () => ({
    loading: false,
    show: false,
    rowsPerPageItems: [4, 8, 12],
    pagination: {
      rowsPerPage: 4,
    },
    regioes: [
      'sul',
      'sudeste',
      'centro-oeste',
      'norte',
      'nordeste',
    ],
  }),
  watch: {
    listarIndicacaoConselhoGetter() {
      if ((typeof twttr === 'undefined')) {
        window.twttr = (function (d, s, id) {
          let js; const fjs = d.getElementsByTagName(s)[0];
          const t = window.twttr || {};
          if (d.getElementById(id)) return t;
          js = d.createElement(s);
          js.id = id;
          js.src = 'https://platform.twitter.com/widgets.js';
          fjs.parentNode.insertBefore(js, fjs);

          t._e = [];
          t.ready = function (f) {
            t._e.push(f);
          };

          return t;
        }(document, 'script', 'twitter-wjs'));
      }
    },
  },
  computed: {
    ...mapGetters({
      listarIndicacaoConselhoGetter: 'conselho/listarIndicacaoConselho',
    }),
    regiao() {
      const parametro = this.$route.params.regiao;
      const validacaoRegiaoValida = this.regioes.some(regiao => regiao === parametro);

      if (!validacaoRegiaoValida) {
        this.$router.push('/votacao');
      }
      return this.$route.params.regiao;
    },
  },
  methods: {
    ...mapActions({
      obterListaIndicacaoConselho: 'conselho/obterListaIndicacaoConselho',
    }),
    compartilharFacebook(indicado) {
      (FB || {}).ui(
        {
          method: 'share',
          quote: `Vote em ${indicado.no_indicado} para compor o Conselho Nacional de Política Cultural (CNPC) no triênio 2019/2022. http://votacultura.cidadania.gov.br/votacao/${this.regiao}`,
          href: `http://votacultura.cidadania.gov.br/${this.regiao}`,
        },
      );
    },
  },
  mounted() {
    this.loading = true;
    this.obterListaIndicacaoConselho().finally(() => {
      this.loading = false;
    });
  },
};
</script>

<style>
  .v-card--reveal {
    align-items: center;
    bottom: 0;
    justify-content: center;
    opacity: .5;
    position: absolute;
    width: 100%;
  }


  #fb-share-button {
    background: #3b5998;
    border-radius: 3px;
    display: inline-block;
    position: static;
  }

  #fb-share-button:hover {
    cursor: pointer;
    background: #213A6F
  }

  #fb-share-button svg {
    width: 14px;
    fill: white;
    vertical-align: middle;
    border-radius: 3px;
    margin-left: 4px;
  }

  #fb-share-button span {
    vertical-align: middle;
    color: white;
    font-weight: initial;
    font-size: 12px;
    /*padding: 0 3px;*/
    margin-right: 6px;
  }
</style>
