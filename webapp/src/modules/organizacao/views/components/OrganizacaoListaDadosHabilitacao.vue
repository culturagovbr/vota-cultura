<template>
  <div>
    <v-layout wrap align-center>
      <v-flex xs12 sm12 class="ma-3">
        <v-layout>
          <v-flex sm6>
            <div class="ma-2 text-justify subheading grey--text">
              <b>Nome da organização/entidade cultural:</b>
              {{ formulario.no_organizacao }}
            </div>
          </v-flex>
          <v-flex sm6>
            <div class="ma-2 text-justify subheading grey--text">
              <b>CNPJ:</b>
              {{ formulario.cnpj_formatado }}
            </div>
          </v-flex>
        </v-layout>
        <v-layout>
          <v-flex sm6>
            <div class="ma-2 text-justify subheading grey--text">
              <b>Pontuação inicial:</b>
              {{ formulario.pontuacao }}
            </div>
          </v-flex>
          <v-flex sm6>
            <div class="ma-2 text-justify subheading grey--text">
              <b>Segmento cultural:</b>
              {{ (formulario.segmento || {}).ds_detalhamento }}
            </div>
          </v-flex>
        </v-layout>

        <v-layout
          v-if="!!formulario.organizacaoHabilitacao && !!formulario.organizacaoHabilitacao.situacao_avaliacao"
        >
          <v-flex sm6>
            <div class="ma-2 text-justify subheading grey--text">
              <b>Pontuação após análise:</b>
              {{ !!formulario.organizacaoHabilitacao.nu_nova_pontuacao.toString() ? formulario.organizacaoHabilitacao.nu_nova_pontuacao:formulario.pontuacao }}
            </div>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>

    <v-layout wrap align-center />

    <div class="ma-4 text-justify">
      <v-toolbar color="white darken-3 title">Documentação</v-toolbar>
      <v-card class="elevation-1">
        <v-container fluid grid-list-xl>
          <v-layout
            v-if="!!(formulario.representante || {}).arquivos && !!((formulario.representante || {}).arquivos || {}).length > 0"
          >
            <v-flex class="pa-3">
              <v-list two-line>
                <template>
                  <v-list-tile
                    avatar
                    @click="downloadArquivo(arquivosAvaliacao.documento_identificacao_representante.co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`a.    Cópia de documento de identificação do representante legal responsável pela inscrição da organização ou entidade cultural (conforme item 2.5.2 deste edital) e CPF.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
                <template>
                  <v-list-tile
                    avatar
                    @click="downloadArquivo((arquivosAvaliacao.comprovante_cnpj || {}).co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`b.    Cópia do Cadastro Nacional da Pessoa Jurídica (CNPJ) que comprove a existência da entidade há pelo menos três anos.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
                <template>
                  <v-list-tile
                    avatar
                    @click="downloadArquivo((arquivosAvaliacao.constituicao_diretoria || {}).co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`c.     Cópia do documento de constituição da atual diretoria e da presidência, ou cargo equivalente, da organização ou entidade cultural.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
                <template>
                  <v-list-tile
                    avatar
                    @click="downloadArquivo((arquivosAvaliacao.documento_identificacao_presidente || {}).co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`d.    Cópia do documento de identificação (conforme item 2.5.2 deste edital) e CPF do presidente, diretor executivo ou cargo equivalente.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
                <template>
                  <v-list-tile
                    avatar
                    @click="downloadArquivo((arquivosAvaliacao.contrato_social || {}).co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`e.    Cópia do atual estatuto social ou contrato social, conforme o caso, devidamente registrado no órgão competente, de modo a comprovar o caráter cultural da entidade e seu ano de criação.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
                <template>
                  <v-list-tile
                    avatar
                    @click="downloadArquivo((arquivosAvaliacao.relatorio_anual_atividades || {}).co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`f.      Relatório anual das atividades culturais no último triênio (2016, 2017 e 2018), com ações realizadas em cada um dos três anos, contendo, minimamente: o resumo de cada atividade, o local, o período de realização e o número de participantes.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
                <template>
                  <v-list-tile
                    avatar
                    @click="downloadArquivo((arquivosAvaliacao.comprovacao_projetos_atividades || {}).co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`g.    Comprovação efetiva de que possui projetos ou atividades culturais realizados em ao menos 5 estados de 2 macrorregiões brasileiras, a partir do exercício de 2016, por meio de: portfólio, folders, publicações, listas de presença, revistas, jornais, conteúdos de divulgação, links de vídeos, registros fotográficos ou outros materiais que permitam, minimamente, a identificação de data e local de realização das atividades e a aferição da veracidade das informações apresentadas.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
                <template>
                  <v-list-tile
                    avatar
                    @click="downloadArquivo((arquivosAvaliacao.lista_associados || {}).co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`h.    Lista de associados ou filiados atestada pelo dirigente da organização ou entidade cultural.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
                <template
                  v-if="!!(arquivosAvaliacao.comprovante_realizacao_projetos || {}).co_arquivo"
                >
                  <v-list-tile
                    avatar
                    @click="downloadArquivo((arquivosAvaliacao.comprovante_realizacao_projetos || {}).co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`i.      Documentação que comprove a atuação da organização ou entidade cultural em instâncias colegiadas do setor cultural, tais como conselhos, comissões ou câmaras, se houver, por meio de termo de posse ou portaria de designação de representante.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
                <template
                  v-if="!!(arquivosAvaliacao.comprovante_instancia_colegiada || {}).co_arquivo"
                >
                  <v-list-tile
                    avatar
                    @click="downloadArquivo((arquivosAvaliacao.comprovante_instancia_colegiada || {}).co_arquivo)"
                  >
                    <v-list-tile-content>
                      <v-list-tile-title
                        v-html="`j.      Documentação que comprove a realização de projetos na área de pesquisa ou produção do conhecimento no campo da cultura a partir de 2016, tais como: publicações, pesquisa de campo e artigos científicos, se houver.`"
                      />
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn icon ripple>
                        <v-icon color="blue darken-4">cloud_download</v-icon>
                      </v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                </template>
              </v-list>
            </v-flex>
          </v-layout>
          <v-layout v-else wrap align-center>
            <v-flex xs12 sm12 class="ma-3">
              <p>Documentação comprobatória não enviada.</p>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card>
    </div>
    <div class="ma-4 text-justify title">
      <v-toolbar color="white darken-3">Avaliação</v-toolbar>
      <v-card class="elevation-1">
        <v-container fluid grid-list-xl>
          <v-layout>
            <v-flex sm6>
              <v-select
                v-model="(formulario.organizacaoHabilitacao || {}).st_avaliacao"
                :value="(formulario.organizacaoHabilitacao || {}).st_avaliacao"
                :items="resultadoItens"
                item-value="valor"
                item-text="descricao"
                box
                label="* Resultado da avaliação"
                :disabled="true"
              />
            </v-flex>
          </v-layout>

          <v-layout>
            <v-flex class="pa-3">
              <v-textarea
                v-model="(formulario.organizacaoHabilitacao || {}).ds_parecer"
                box
                label="* Parecer"
                name="input-7-4"
                rows="13"
                row-height="28"
                :readonly="true"
                :disabled="true"
              />
            </v-flex>
          </v-layout>

          <v-layout>
            <v-flex class="pa-3" sm4>
              <v-radio-group
                v-model="possuiNovaPontuacao"
                column
                label="Houve alteração da pontuação?"
                required
                :disabled="true"
              >
                <v-radio value="1" color="success">
                  <template v-slot:label>
                    <div>Sim</div>
                  </template>
                </v-radio>
                <v-radio value="0" color="error">
                  <template v-slot:label>
                    <div>Não</div>
                  </template>
                </v-radio>
              </v-radio-group>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  name: "OrganizacaoListaDadosHabilitacao",
  data: () => ({
    possuiNovaPontuacao: null,
    resultadoItens: [
      {
        descricao: "Habilitada e classificada",
        valor: "2"
      },
      {
        descricao: "Habilitada e desclassificada",
        valor: "1"
      },
      {
        descricao: "Habilitada",
        valor: "3"
      },
      {
        descricao: "Inabilitada",
        valor: "0"
      }
    ],
    arquivosAvaliacaoInicial: {
      ata_reuniao_conselho: {
        st_em_conformidade: null,
        co_representante_arquivo: null,
        ds_observacao: String(),
        co_arquivo: null
      },
      ato_normativo_conselho: {
        st_em_conformidade: null,
        co_representante_arquivo: null,
        ds_observacao: String(),
        co_arquivo: null
      },
      documento_identificacao_responsavel: {
        st_em_conformidade: null,
        co_representante_arquivo: null,
        ds_observacao: String(),
        co_arquivo: null
      }
    },
    arquivosAvaliacao: {}
  }),
  methods: {
    ...mapActions({
      downloadArquivo: "shared/downloadArquivo"
    }),

    inicializarValoresComponente() {
      this.arquivosAvaliacao = Object.assign({}, this.arquivosAvaliacaoInicial);
      Object.keys(this.arquivosAvaliacao).forEach(indice => {
        this.arquivosAvaliacao[indice] = Object.assign({
          st_em_conformidade: null,
          co_representante_arquivo: null,
          ds_observacao: String(),
          co_arquivo: null
        });
      });

      // this.possuiNovaPontuacao = null;
    },

    atribuirValoresConformidade(organizacaoHabilitacao) {
      organizacaoHabilitacao.arquivosAvaliacao.forEach((item) => {
        this.arquivosAvaliacao[item.tp_arquivo] = Object.assign({}, item);
      });
      this.possuiNovaPontuacao = '0';
      if (organizacaoHabilitacao.nu_nova_pontuacao >= 0) {
        this.possuiNovaPontuacao = '1';
      }
    },
  },
  props: {
    formulario: {
      type: Object,
      default: () => {}
    }
  },
  watch: {
    value(valor) {
      this.dialog = valor;
      if (!valor) {
        this.arquivosAvaliacao = Object.assign(
          {},
          this.arquivosAvaliacaoInicial
        );
        this.arquivosAvaliacao.forEach(item => {
          this.arquivosAvaliacao[item.tp_arquivo] = Object.assign({}, item);
        });
      }
    },
    possuiNovaPontuacao(valor) {
      if (valor === '0') {
        this.formulario.organizacaoHabilitacao.nu_nova_pontuacao = String();
      }

      if (this.formulario.organizacaoHabilitacao.nu_nova_pontuacao === null) {
        this.formulario.organizacaoHabilitacao.nu_nova_pontuacao = this.formulario.pontuacao;
        this.possuiNovaPontuacao = '0';
      }
    },
    formulario(organizacao) {
      this.formulario = organizacao;

      if (organizacao.organizacaoHabilitacao) {
          this.atribuirValoresConformidade(organizacao.organizacaoHabilitacao);
        }
      this.inicializarValoresComponente();
    }
  },
  mounted: () => {}
};
</script>
