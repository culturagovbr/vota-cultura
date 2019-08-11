<template>
  <div>
    <section>
      <v-img
        :src="require('../../assets/banner.png')"
        alt="Logo do Sistema"
        height="800"
      />

      <v-layout
        column
        align-center
        justify-center
        class="white--text"
      >
        <v-slide-y-transition>
          <v-container
            v-show="ativar_inscricao === true"
            grid-list-md
            text-xs-center
          >
            <v-layout
              row
              wrap
            >
              <v-flex xs12>
                <v-btn
                  class="yellow mt-2"
                  large
                  to="/inscricao-conselho"
                >
                  Conselho Cultural
                </v-btn>
              </v-flex>
              <v-flex xs12>
                <v-btn
                  class="yellow mt-2"
                  to="/formulario-tres"
                  large
                >
                  Organização / Entidade Cultural
                </v-btn>
              </v-flex>
              <v-flex xs12>
                <v-btn
                  class="yellow mt-2"
                  to="/formulario-dois"
                  large
                >
                  Eleitor
                </v-btn>
              </v-flex>
            </v-layout>
          </v-container>
        </v-slide-y-transition>
      </v-layout>
      <!--</v-parallax>-->
    </section>

    <section>
      <v-layout
        column
        wrap
        class="my-5"
        align-center
      >
        <v-flex
          xs12
          sm4
          class="my-3"
        >
          <div class="text-xs-center">
            <h2 class="headline">
              Inscreva-se
            </h2>
            <!--<span class="subheading">-->
            <!--Cras facilisis mi vitae nunc-->
            <!--</span>-->
          </div>
        </v-flex>
        <v-flex xs12>
          <v-container grid-list-xl>
            <v-layout
              row
              wrap
              align-center
            >
              <v-flex
                xs12
                md4
              >
                <v-card class="elevation-0 transparent">
                  <v-card-text class="text-xs-center">
                    <v-icon
                      x-large
                      class="text--lighten-2"
                    >
                      color_lens
                    </v-icon>
                  </v-card-text>
                  <v-card-title
                    primary-title
                    class="layout justify-center"
                  >
                    <div class="headline text-xs-center">
                      Organizações e Entidades Culturais
                    </div>
                  </v-card-title>
                  <v-card-text>
                    Pessoa jurídica de direito privado sem fins lucrativos, legalmente constituída,
                    de caráter associativo, com atuação nacional comprovada no campo cultural, em ao
                    menos cinco estados de duas macrorregiões brasileiras
                  </v-card-text>
                </v-card>
                <div class="text-xs-center">
                  <v-btn
                    color="green darken-4"
                    to="/organizacao/inscricao"
                    dark
                  >
                    <v-icon>
                      call_made
                    </v-icon>
                  </v-btn>
                </div>
              </v-flex>
              <v-flex
                xs12
                md4
              >
                <v-card class="elevation-0 transparent">
                  <v-card-text class="text-xs-center">
                    <v-icon
                      x-large
                      class="text--lighten-2"
                    >
                      group
                    </v-icon>
                  </v-card-text>
                  <v-card-title
                    primary-title
                    class="layout justify-center"
                  >
                    <div class="headline">
                      Conselhos de Cultura Estaduais e Distrital
                    </div>
                  </v-card-title>
                  <v-card-text>
                    Órgão colegiado de cultura vinculados à administração pública do Estado ou
                    Distrito Federal, e na impossibilidade declarada de participação de conselho no
                    âmbito do Estado, aquele vinculado à administração pública da respectiva capital
                  </v-card-text>
                </v-card>
                <div class="text-xs-center">
                  <v-btn
                    color="green darken-4"
                    to="/conselho/inscricao"
                    dark
                  >
                    <v-icon>
                      call_made
                    </v-icon>
                  </v-btn>
                </div>
              </v-flex>
              <v-flex
                xs12
                md4
              >
                <v-card class="elevation-0 transparent">
                  <v-card-text class="text-xs-center">
                    <v-icon
                      x-large
                      class="text--lighten-2"
                    >
                      thumbs_up_down
                    </v-icon>
                  </v-card-text>
                  <v-card-title
                    primary-title
                    class="layout justify-center"
                  >
                    <div class="headline text-xs-center">
                      Eleitor
                    </div>
                  </v-card-title>
                  <v-card-text>
                    Cidadão brasileiro com idade mínima de 18 anos na data da inscrição
                  </v-card-text>
                  <div class="text-xs-center">
                    <v-btn
                      color="green darken-4"
                      to="/eleitor/inscricao"
                      dark
                    >
                      <v-icon>
                        call_made
                      </v-icon>
                    </v-btn>
                  </div>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-flex>
      </v-layout>
    </section>

    <section>
      <v-parallax
        :src="require('../../assets/vota-parallax.jpg')"
        height="380"
      >
        <v-layout
          column
          align-center
          justify-center
          row
          fill-height
        >
          <v-layout
            row
            align-center
            justify-center
          >
            <v-flex>
              <div class="headline white--text mb-3 text-xs-center">
                Leia o Edital na integra
              </div>
              <em>Se informe sobre a chamada publica para composição do conselho nacional de política
                cultural</em>
            </v-flex>
          </v-layout>
          <v-layout
            row
            align-center
            justify-center
          >
            <v-flex>
              <v-btn
                class="green darken-4 mt-5 white--text"
                dark
                large
                target="_blank"
                href="EDITAL_01_12_08_2019-CNPC.pdf"
              >
                Ver Edital
              </v-btn>
            </v-flex>
            <v-flex>
              <v-btn
                class="green darken-4 mt-5 white--text"
                dark
                large
                target="_blank"
                href="CARTILHA_CNPC.pdf"
              >
                Ver Cartilha
              </v-btn>
            </v-flex>
          </v-layout>
        </v-layout>
      </v-parallax>
    </section>

    <section>
      <v-container grid-list-xl>
        <v-layout
          row
          wrap
          justify-center
          class="my-5"
        >
          <v-flex
            xs12
            sm4
          >
            <v-card class="elevation-0 transparent">
              <v-card-title
                primary-title
                class="layout justify-center"
              >
                <div class="headline">
                  O que é Conselho Nacional de Política Cultural?
                </div>
              </v-card-title>
              <v-card-text>
                O CNPC é um órgão colegiado integrante da estrutura do Ministério da Cultura.
                Esse órgão tem como finalidade propor a formulação de políticas públicas,
                promovendo a articulação e o debate dos diferentes níveis d governo e sociedade
                civil organizada, para o desenvolvimento e fomento das atividades culturais no
                território nacional.
              </v-card-text>
            </v-card>
          </v-flex>
          <v-flex
            xs12
            sm4
            offset-sm1
          >
            <v-card class="elevation-0 transparent">
              <v-card-title
                primary-title
                class="layout justify-center"
              >
                <div class="headline">
                  Fale Conosco
                </div>
              </v-card-title>
              <v-card-text>
                Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
              </v-card-text>
              <v-list class="transparent">
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon class="text--lighten-2">
                      phone
                    </v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>777-867-5309</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon class="text--lighten-2">
                      place
                    </v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>
                      SCS Q.09 Lote C Torre X 11º ANDAR
                      CEP: 70.108-200 Brasília/DF
                    </v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon class="text--lighten-2">
                      email
                    </v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>suporte@cidadania.com</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </v-list>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ativar_inscricao: false,
    };
  },
};
</script>
