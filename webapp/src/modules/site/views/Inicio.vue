
<template>
  <div>
    <section>
      <v-img
        :src="require('@/assets/banner.png')"
        alt="Logo do Sistema"
        height="800"
      />
    </section>

    <section>
      <v-layout
        column
        wrap
        class="my-5"
        align-center
      >
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
                <v-card class="elevation-15 transparent" style="width:300px;min-height: 340px">
                  <v-card-text class="text-xs-center">
                    <v-icon
                      x-large
                      class="text--lighten-2"
                    >
                      list
                    </v-icon>
                  </v-card-text>
                  <v-card-title
                    primary-title
                    class="layout justify-center"
                  >
                    <div class="headline text-xs-center">
                      Lista final de inscritos
                    </div>
                  </v-card-title>
                  <v-card-text>
                    Consulte aqui a lista final de inscritos
                  </v-card-text>
                  <div class="text-xs-center pb-4">
                    <v-btn
                      style="margin-top: 79px"
                      color="green darken-4"
                      to="/inscricao/lista-parcial"
                      dark
                    >
                      <v-icon>
                        call_made
                      </v-icon>
                    </v-btn>
                  </div>
                </v-card>
              </v-flex>
              <v-flex
                xs12
                md4
              >
                <v-card class="elevation-15 transparent" style="width:300px;min-height: 340px">
                  <v-card-text class="text-xs-center">
                    <v-icon
                      x-large
                      class="text--lighten-2"
                    >
                      list
                    </v-icon>
                  </v-card-text>
                  <v-card-title
                    primary-title
                    class="layout justify-center"
                  >
                    <div class="headline text-xs-center">
                      Conselho de cultura
                    </div>
                  </v-card-title>
                  <v-card-text>
                    <div class="title text-xs-center">
                      Lista parcial de habilitação
                    </div>
                    <div style="margin-top: 49px" class="subheading text-xs-center">
                      Consulte aqui
                    </div>
                  </v-card-text>
                  <div class="text-xs-center pb-4">
                    <v-btn
                      style="margin-top: 10px"
                      color="green darken-4"
                      to="/inscricao/lista-parcial-habilitados"
                      dark
                    >
                      <v-icon>
                        call_made
                      </v-icon>
                    </v-btn>
                  </div>
                </v-card>
              </v-flex>


              <v-flex
                xs12
                md4
              >
                <v-card class="elevation-15 transparent" style="width:300px;min-height: 340px">
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
                      Inscrição
                      <br />
                      Eleitor
                    </div>
                  </v-card-title>
                  <v-card-text>
                    Cidadão brasileiro com idade mínima de 18 anos na data da inscrição
                  </v-card-text>
                  <div class="text-xs-center pb-4">
                    <v-btn
                      color="green darken-4"
                      to="/eleitor/inscricao"
                      dark
                      style="margin-top: 32px"
                    >
                      <v-icon>
                        call_made
                      </v-icon>
                    </v-btn>
                  </div>
                </v-card>
              </v-flex>

              <v-flex
                xs12
                md4
                v-if="isConselho"
              >
                <v-card class="elevation-15 transparent" style="width:300px;min-height: 340px">
                  <v-card-text class="text-xs-center">
                    <v-icon
                      x-large
                      class="text--lighten-2"
                    >
                      list
                    </v-icon>
                  </v-card-text>
                  <v-card-title
                    primary-title
                    class="layout justify-center"
                  >
                    <div class="headline text-xs-center">
                      Conselho de cultura
                    </div>
                  </v-card-title>
                  <v-card-text class="text-xs-center">
                    Recurso de Habilitação <br /><br />

                    Cadastre aqui o recurso referente à etapa<br /> de habilitação dos conselhos de cultura
                  </v-card-text>
                  <div class="text-xs-center pb-4">
                    <v-btn
                      style="margin-top: 79px"
                      color="green darken-4"
                      to="/conselho/habilitacao-recurso"
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
        :src="require('@/assets/banner_2.jpg')"
        height="500"
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
              <v-btn
                class="yellow darken-4 mt-5 white--text"
                dark
                large
                target="_blank"
                href="http://cnpc.cultura.gov.br/editalcnpc2019-2022/"
              >
                Acesse o Edital
              </v-btn>
            </v-flex>
            <v-flex>
              <v-btn
                class="yellow darken-4 mt-5 white--text"
                dark
                large
                target="_blank"
                href="CARTILHA_CNPC.pdf"
              >
                Acesse a Cartilha
              </v-btn>
            </v-flex>
          </v-layout>
        </v-layout>
      </v-parallax>
    </section>
    <section>
      <v-parallax
        dark
        :src="require('@/assets/blue-gradient-background-debbie-lynn-grace.jpg')"
      >
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
            <iframe
              width="560"
              height="315"
              src="https://www.youtube-nocookie.com/embed/2ZII7C3clD0"
              frameborder="0"
              allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            />
          </v-flex>
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
            sm5
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
                O Conselho Nacional de Política Cultural (CNPC) é um órgão colegiado integrante da
                estrutura do Ministério da Cidadania.
                Esse órgão tem como finalidade propor a formulação de políticas públicas,
                promovendo a articulação e o debate dos diferentes níveis de governo e a sociedade
                civil organizada, para o desenvolvimento e fomento das atividades culturais no
                território nacional.
              </v-card-text>
            </v-card>
          </v-flex>
          <v-flex
            xs12
            sm5
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
                Esclarecimentos e informações complementares necessários à aplicação dos
                termos deste Edital poderão ser obtidos junto à Central de Relacionamento:
              </v-card-text>
              <v-list class="transparent">
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon class="text--lighten-2">
                      phone
                    </v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>121 - Ouvidoria Geral do Ministério da Cidadania</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon class="text--lighten-2">
                      link
                    </v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>
                      <a
                        href="http://mds.gov.br/ministerio-da-cidadania/ouvidoria-do-ministerio/central-de-relacionamento"
                        target="_blank"
                      >Fale Conosco/Central de Relacionamento</a>
                    </v-list-tile-title>
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
import { mapGetters } from 'vuex';

export default {
  data: () => ({
      isConselho : false
  }),
  computed: {
    ...mapGetters({
      ativarInscricaoConselho: 'fase/ativarInscricaoConselho',
      ativarInscricaoOrganizacao: 'fase/ativarInscricaoOrganizacao',
      ativarInscricaoEleitor: 'fase/ativarInscricaoEleitor',
      usuario: 'conta/usuario',
    }),
  },
    mounted() {
        if (this.usuario.co_conselho) {
            this.isConselho = true;
        }
    }
};
</script>
