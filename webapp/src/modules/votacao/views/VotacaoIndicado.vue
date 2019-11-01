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
                <v-img
                  :aspect-ratio="5/4"
                  :src="indicado.foto_indicado"
                >
                  <!--<v-expand-transition>-->
                  <!--<div-->
                  <!--class="d-flex transition-fast-in-fast-out primary darken-2 v-card&#45;&#45;reveal display-3 white&#45;&#45;text"-->
                  <!--style="height: 100%;"-->
                  <!--&gt;-->
                  <!--Titular-->
                  <!--</div>-->
                  <!--</v-expand-transition>-->
                </v-img>
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
                  <!--<div class="title mb-2">-->
                  <!--Goiás-->
                  <!--</div>-->
                  <v-layout>
                    <v-flex>
                      <a
                        href="https://twitter.com/share"
                        class="twitter-share-button"
                        data-url="https://www.google.com.br"
                        data-lang="pt"
                        :data-text="`Vote em ${indicado.no_indicado} para compor o Conselho Nacional de Política Cultural (CNPC) no triênio 2019/2022`"
                        data-size="medium"
                        data-dnt="true"
                      >Tweetar</a>
                    </v-flex>
                    <v-flex>
                      <a
                        :href="`https://api.whatsapp.com/send?text=Vote em ${indicado.no_indicado} para compor o Conselho Nacional de Política Cultural (CNPC) no triênio 2019/2022`"
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
                        class="fb-share-button"
                        data-href="https://www.kabum.com.br/produto/104087/processador-intel-core-i9-9900ks-coffee-lake-refresh-geracao-cache-16mb-4-0ghz-5-0ghz-max-turbo-lga-1151-bx80684i99900ks"
                        data-layout="button"
                        data-size="small"
                      >
                        <a
                          target="_blank"
                          href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fvotacultura.cidadania.gov.br%2Fvotacao%2Fcentro-oeste&amp;src=sdkpreparse"
                          class="fb-xfbml-parse-ignore"
                        >Compartilhar</a>
                      </div>

                      <!--<div-->
                      <!--class="fb-share-button"-->
                      <!--data-href="http://votacultura.cidadania.gov.br"-->
                      <!--data-layout="button"-->
                      <!--data-size="small"-->
                      <!--&gt;-->
                      <!--<a-->
                      <!--target="_blank"-->
                      <!--href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"-->
                      <!--class="fb-xfbml-parse-ignore"-->
                      <!--&gt;Compartilhar</a>-->
                      <!--</div>-->
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
      setTimeout(() => {
        (function (d, s, id) {
          let js; const
            fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.0';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));


        !(function (d, s, id) { let js; const fjs = d.getElementsByTagName(s)[0]; const p = /^http:/.test(d.location) ? 'http' : 'https'; if (!d.getElementById(id)) { js = d.createElement(s); js.id = id; js.src = `${p}://platform.twitter.com/widgets.js`; fjs.parentNode.insertBefore(js, fjs); } }(document, 'script', 'twitter-wjs'));
      }, 200);
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
  },
  mounted() {
    console.log(this.regiao);
    console.log(this.$route);
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
</style>
