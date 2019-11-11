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
            v-for="indicado in listaIndicadosParaVotacaoGetter"
            :key="indicado.co_conselho_indicacao"
            xs3
            class="ma-1 pa-2"
          >
            <v-hover>
              <v-card
                class="mx-auto"
                max-width="600"
              >
                <v-img
                  :src="indicado.ds_localizacao"
                  :aspect-ratio="1"
                />
                <v-card-text
                  class="pt-4"
                  style="position: relative;"
                >
                  <v-btn
                    v-if="usuario.co_eleitor > 0 && !possuiVoto"
                    style="z-index:0"
                    absolute
                    color="primary"
                    class="white--text"
                    fab
                    medium
                    right
                    top
                    @click="confirmarVoto(indicado)"
                  >
                    <v-icon>thumb_up</v-icon>
                  </v-btn>
                  <v-btn
                    v-if="indicado.recebeu_meu_voto"
                    style="z-index:0"
                    absolute
                    color="success"
                    class="white--text"
                    fab
                    medium
                    right
                    top
                  >
                    <v-icon>check</v-icon>
                  </v-btn>
                  <h3 class="font-weight-light primary--text mb-2">
                    {{ indicado.no_indicado }} - {{ indicado.no_uf }}
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
                        <v-card-text v-html="indicado.ds_curriculo" />
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
    <v-layout justify-center>
      <v-dialog
        v-model="dialog"
        max-width="550"
      >
        <v-card>
          <v-card-title class="headline">
            Deseja realmente votar nesse candidato?
          </v-card-title>

          <v-card-text>
            <v-layout>
              Candidato:&nbsp;<b>{{ candidato.no_indicado }}</b>
            </v-layout>
            <br>
            Para <b>verificarmos a sua identificação</b>, informe abaixo o <b>nome da sua mãe</b> de acordo com o cadastro na Receita Federal Brasileira:
            <v-text-field
              placeholder="Digite aqui"
              solo
              hint="Não é necessário acentos."
              persistent-hint
            />

            <br>
            Atenção!
            <br>
            Ao confirmar, o voto será computado e depois não será possível votar novamente.
          </v-card-text>

          <v-card-actions>
            <v-spacer />

            <v-btn
              color="red darken-1"
              text
              flat
              @click="fecharDialogo"
            >
              Não
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              flat
              @click="salvar"
            >
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'VotacaoIndicado',
  data: () => ({
    candidato: {},
    usuario_ja_votou: false,
    dialog: false,
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
    listaIndicadosParaVotacaoGetter(valor) {
      valor.map((indicado) => {
        if (indicado.recebeu_meu_voto) {
          this.usuario_ja_votou = true;
        }
      });

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
      listaIndicadosParaVotacaoGetter: 'votacao/listaIndicadosParaVotacao',
      possuiVoto: 'votacao/possuiVoto',
      usuario: 'conta/usuario',
      perfil: 'conta/perfil',
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
      obterListaIndicadosVotacao: 'votacao/obterListaIndicadosVotacao',
      votar: 'votacao/votar',
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
    fecharDialogo() {
      this.candidato = {};
      this.dialog = false;
    },
    abrirDialogo() {
      this.dialog = true;
    },
    salvar() {
      this.votar({
        co_conselho_indicacao: this.candidato.co_conselho_indicacao,
      }).then(() => {
        this.obterListaIndicadosVotacao(this.regiao);
      });
      this.fecharDialogo();
    },
    confirmarVoto(candidato) {
      this.candidato = candidato;
      this.abrirDialogo();
    },
  },
  mounted() {
    this.loading = true;
    this.obterListaIndicadosVotacao(this.regiao).finally(() => {
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

  #input-nome-mae input{
    text-transform: uppercase
  }
</style>
