<template>
  <v-dialog
    v-model="dialog"
    fullscreen
    hide-overlay
    transition="dialog-bottom-transition"
  >
    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-btn
          icon
          dark
          @click="dialog = false"
        >
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>
          Habilitação - Organização ou entidade cultural
        </v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-card-text>

        <v-form
          ref="form_recurso"
          v-model="valid"
        >
          <v-container v-if="!!arquivosAvaliacao.documento_identificacao_representante">

            <v-card>
              <v-card-text>
                <v-tabs
                  v-model="model"
                  centered
                  :color="'grey darken-3'"
                  dark
                  slider-color="yellow"
                >
                  <v-tab
                    href="#tab-1"
                  >
                    Habilitação
                  </v-tab>
                  <v-tab
                    href="#tab-2"
                  >
                    Dados da organização
                  </v-tab>
                  <v-tab href="#tab-3" v-if="possuoHistoricoRevisoes">
                    Histórico de revisões
                  </v-tab>
                </v-tabs>

                <v-tabs-items
                  v-model="model"
                  class="white elevation-1"
                >
                  <v-tab-item
                    value="tab-1"
                  >
                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm12
                        class="ma-3"
                      >
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
                              {{ formulario.segmento.ds_detalhamento }}
                            </div>
                          </v-flex>
                        </v-layout>

                        <v-layout v-if="!!formulario.organizacaoHabilitacao && !!formulario.organizacaoHabilitacao.situacao_avaliacao">
                          <v-flex sm6>
                            <div class="ma-2 text-justify subheading grey--text">
                              <b>Pontuação após análise:</b>
                              {{ !!formulario.organizacaoHabilitacao.nu_nova_pontuacao.toString() ? formulario.organizacaoHabilitacao.nu_nova_pontuacao:formulario.pontuacao }}
                            </div>
                          </v-flex>
                        </v-layout>
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    />

                    <div class="ma-4 text-justify">
                      <v-toolbar color="white darken-3 title">
                        Documentação
                      </v-toolbar>
                      <v-card class="elevation-1">
                        <v-container
                          fluid
                          grid-list-xl
                        >
                          <v-layout v-if="!!formulario.representante.arquivos && !!formulario.representante.arquivos.length > 0">
                            <v-flex class="pa-3">
                              <v-list two-line>
                                <template>
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.documento_identificacao_representante.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`a.    Cópia de documento de identificação do representante legal responsável pela inscrição da organização ou entidade cultural (conforme item 2.5.2 deste edital) e CPF.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                                <template>
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.comprovante_cnpj.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`b.    Cópia do Cadastro Nacional da Pessoa Jurídica (CNPJ) que comprove a existência da entidade há pelo menos três anos.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                                <template>
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.constituicao_diretoria.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`c.     Cópia do documento de constituição da atual diretoria e da presidência, ou cargo equivalente, da organização ou entidade cultural.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                                <template>
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.documento_identificacao_presidente.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`d.    Cópia do documento de identificação (conforme item 2.5.2 deste edital) e CPF do presidente, diretor executivo ou cargo equivalente.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                                <template>
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.contrato_social.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`e.    Cópia do atual estatuto social ou contrato social, conforme o caso, devidamente registrado no órgão competente, de modo a comprovar o caráter cultural da entidade e seu ano de criação.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                                <template>
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.relatorio_anual_atividades.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`f.      Relatório anual das atividades culturais no último triênio (2016, 2017 e 2018), com ações realizadas em cada um dos três anos, contendo, minimamente: o resumo de cada atividade, o local, o período de realização e o número de participantes.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                                <template>
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.comprovacao_projetos_atividades.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`g.    Comprovação efetiva de que possui projetos ou atividades culturais realizados em ao menos 5 estados de 2 macrorregiões brasileiras, a partir do exercício de 2016, por meio de: portfólio, folders, publicações, listas de presença, revistas, jornais, conteúdos de divulgação, links de vídeos, registros fotográficos ou outros materiais que permitam, minimamente, a identificação de data e local de realização das atividades e a aferição da veracidade das informações apresentadas.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                                <template>
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.lista_associados.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`h.    Lista de associados ou filiados atestada pelo dirigente da organização ou entidade cultural.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                                <template v-if="!!arquivosAvaliacao.comprovante_realizacao_projetos.co_arquivo">
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.comprovante_realizacao_projetos.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`i.      Documentação que comprove a atuação da organização ou entidade cultural em instâncias colegiadas do setor cultural, tais como conselhos, comissões ou câmaras, se houver, por meio de termo de posse ou portaria de designação de representante.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                                <template v-if="!!arquivosAvaliacao.comprovante_instancia_colegiada.co_arquivo">
                                  <v-list-tile
                                    avatar
                                    @click="downloadArquivo(arquivosAvaliacao.comprovante_instancia_colegiada.co_arquivo)"
                                  >
                                    <v-list-tile-content>
                                      <v-list-tile-title v-html="`j.      Documentação que comprove a realização de projetos na área de pesquisa ou produção do conhecimento no campo da cultura a partir de 2016, tais como: publicações, pesquisa de campo e artigos científicos, se houver.`" />
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                      <v-btn
                                        icon
                                        ripple
                                      >
                                        <v-icon color="blue darken-4">
                                          cloud_download
                                        </v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                  </v-list-tile>
                                </template>
                              </v-list>
                            </v-flex>
                          </v-layout>
                          <v-layout
                            v-else
                            wrap
                            align-center
                          >
                            <v-flex
                              xs12
                              sm12
                              class="ma-3"
                            >
                              <p>
                                Documentação comprobatória não enviada.
                              </p>
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card>
                    </div>
                    <div class="ma-4 text-justify title ">
                      <v-toolbar color="white darken-3">
                        Avaliação
                      </v-toolbar>
                      <v-card class="elevation-1">
                        <v-container
                          fluid
                          grid-list-xl
                        >
                          <v-layout>
                            <v-flex sm6>
                              <v-select
                                v-model="formulario.organizacaoHabilitacao.st_avaliacao"
                                :items="resultadoItens"
                                item-value="valor"
                                item-text="descricao"
                                box
                                label="* Resultado da avaliação"
                                required
                                :disabled="desabilitarRevisaoHabilitacao()"
                              />
                            </v-flex>
                          </v-layout>

                          <v-layout>
                            <v-flex class="pa-3">
                              <v-textarea
                                v-model="formulario.organizacaoHabilitacao.ds_parecer"
                                box
                                label="* Parecer"
                                name="input-7-4"
                                rows="13"
                                row-height="28"
                                :counter="15000"
                                :rules="[rules.required, rules.tamanhoMaximo15000Caracteres]"
                                :readonly="desabilitarRevisaoHabilitacao()"
                              />
                            </v-flex>
                          </v-layout>

                          <v-layout>
                            <v-flex
                              class="pa-3"
                              sm4
                            >
                              <v-radio-group
                                v-model="possuiNovaPontuacao"
                                column
                                label="Houve alteração da pontuação?"
                                :rules="[rules.required]"
                                required
                                :disabled="desabilitarRevisaoHabilitacao()"
                              >
                                <v-radio
                                  value="1"
                                  color="success"
                                >
                                  <template v-slot:label>
                                    <div>Sim</div>
                                  </template>
                                </v-radio>
                                <v-radio
                                  value="0"
                                  color="error"
                                >
                                  <template v-slot:label>
                                    <div>Não</div>
                                  </template>
                                </v-radio>
                              </v-radio-group>
                            </v-flex>
                            <v-flex
                              v-if="possuiNovaPontuacao === '1'"
                              class="pa-3"
                              sm7
                            >
                              <v-text-field
                                v-model="formulario.organizacaoHabilitacao.nu_nova_pontuacao"
                                type="number"
                                min="0"
                                max="99"
                                step="1"
                                mask="##"
                                onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
                                label="Informe a nova pontuação da organização/entidade cultural:"
                                :disabled="desabilitarRevisaoHabilitacao()"
                              />
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card>
                    </div>
                    <v-card-actions class="justify-center">
                      <v-btn @click="dialog = false">
                        <v-icon left>
                          undo
                        </v-icon>
                        Voltar
                      </v-btn>
                      <v-btn
                        v-if="!formulario.organizacaoHabilitacao.co_organizacao_habilitacao"
                        :loading="loading"
                        :disabled="!valid || loading"
                        color="primary"
                        @click.native="abrirDialogo"
                      >
                        <v-icon left>
                          send
                        </v-icon>
                        Avaliar
                      </v-btn>
                      <v-btn
                        v-if="!!formulario.organizacaoHabilitacao.co_organizacao_habilitacao && !desabilitarRevisaoHabilitacao()"
                        :loading="loading"
                        :disabled="!valid || loading"
                        color="primary"
                        @click.native="abrirDialogo"
                      >
                        <v-icon left>
                          send
                        </v-icon>
                        Revisar
                      </v-btn>
                    </v-card-actions>
                  </v-tab-item>
                  <v-tab-item value="tab-2">
                    <v-card
                      flat
                      class="pa-4"
                    >
                      <organizacao-detalhes-inscricao-visualizacao />
                    </v-card>
                  </v-tab-item>
                  <v-tab-item value="tab-3" v-if="possuoHistoricoRevisoes">

                    <v-card
                      flat
                      class="pa-4"
                    >
                      <organizacao-lista-habilitacao-historico :historico="formulario.organizacaoHabilitacao.historico" />
                    </v-card>
                  </v-tab-item>
                </v-tabs-items>
              </v-card-text>
            </v-card>
          </v-container>
        </v-form>
      </v-card-text>
    </v-card>

    <v-layout justify-center>
      <v-dialog
        v-model="modalConfirmacao"
        max-width="390"
      >
        <v-card>
          <v-card-title class="headline">
            Deseja realmente
            <span
              v-if="!!formulario.organizacaoHabilitacao.co_organizacao_habilitacao && perfil.no_perfil === 'administrador'"
              style="margin-left:5px"
            >
              revisar
            </span>
            <span
              v-else
              style="margin-left:5px"
            >
              enviar
            </span>
            ?
          </v-card-title>

          <v-card-text v-if="!!formulario.organizacaoHabilitacao.co_organizacao_habilitacao && perfil.no_perfil === 'administrador'">
            <span class="subheading">
              Indique abaixo se é uma revisão final:
            </span>

            <v-container>
              <v-layout>
                <v-flex>
                  <v-checkbox
                    v-model="formulario.organizacaoHabilitacao.st_revisao_final"
                    class="text-md-center"
                    label="Revisão final"
                  />
                  <span class="body-1">
                    Atenção! Caso selecione que é uma revisão final não será
                    possível revisar novamente.
                  </span>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
          <v-card-text v-else>
            Os dados enviados não poderão ser alterados posteriormente.
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
              :loading="loading"
              :disabled="loading"
              @click="salvar"
            >
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-dialog>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
import OrganizacaoDetalhesInscricaoVisualizacao from './OrganizacaoDetalhesInscricaoVisualizacao';
import OrganizacaoListaHabilitacaoHistorico from "./OrganizacaoListaHabilitacaoHistorico";

export default {
  name: 'OrganizacaoListaHabilitacaoDialog',
  components: {
    OrganizacaoListaHabilitacaoHistorico,
    OrganizacaoDetalhesInscricaoVisualizacao,
  },
  props: {
    value: {
      type: Boolean,
      default: false,
    },
    organizacao: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      resultadoItens: [],
      exibirBotaoRevisao: true,
      arquivosAvaliacaoInicial: {
        documento_identificacao_representante: {},
        comprovante_cnpj: {},
        constituicao_diretoria: {},
        documento_identificacao_presidente: {},
        contrato_social: {},
        relatorio_anual_atividades: {},
        comprovacao_projetos_atividades: {},
        lista_associados: {},
        comprovante_realizacao_projetos: {},
        comprovante_instancia_colegiada: {},
      },
      possuiNovaPontuacao: null,
      arquivosAvaliacao: {},
      confirmacaoDados: false,
      model: 'tab-1',
      modalConfirmacao: false,
      dialog: false,
      loading: false,
      valid: false,
      formularioInicial: {
        organizacaoHabilitacao: {
          co_organizacao_habilitacao: null,
          co_organizacao: null,
          st_avaliacao: null,
          ds_parecer: null,
          st_revisao_final: null,
        },
      },
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
        tamanhoMaximo3000Caracteres: value => (!!value && value.length <= 3000) || 'Máximo 3000 caracteres',
        tamanhoMaximo15000Caracteres: value => (!!value && value.length <= 15000) || 'Máximo 15000 caracteres',
        tamanhoMaximo500Caracteres: value => (!!value && value.length <= 500) || 'Máximo 500 caracteres',
      },
    };
  },
  computed: {
    ...mapGetters({
      perfis: 'conta/perfis',
      perfisInscricao: 'conta/perfisInscricao',
      perfil: 'conta/perfil',
    }),
    possuoHistoricoRevisoes() {
      const { historico } = (this.formulario || {}).organizacaoHabilitacao || {};

      return historico.length > 0;
    },
  },
  watch: {
    value(valor) {
      this.dialog = valor;
      if (!valor) {
        this.formulario.organizacaoHabilitacao = Object.assign({}, this.formularioInicial.organizacaoHabilitacao);
        this.inicializarValoresComponente();
        this.$refs.form_recurso.reset();
      }
    },
    dialog(valor) {
      this.$emit('input', valor);
    },
    organizacao(valor) {
      if (Object.keys(valor).length) {
        this.formulario = Object.assign({}, valor);

        if (this.formulario.organizacaoHabilitacao === null) {
          this.formulario.organizacaoHabilitacao = Object.assign({}, this.formularioInicial.organizacaoHabilitacao);
        }

        this.inicializarValoresComponente();

        this.formulario.representante.arquivos.forEach((item) => {
          this.arquivosAvaliacao[item.tp_arquivo].co_representante_arquivo = item.co_representante_arquivo;
          this.arquivosAvaliacao[item.tp_arquivo].co_arquivo = item.co_arquivo;
        });

        if (valor.organizacaoHabilitacao) {
          this.atribuirValoresConformidade(valor.organizacaoHabilitacao);
        }

        this.obterDadosOrganizacao(valor.co_organizacao);
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
    modalConfirmacao(valor) {
      this.formulario.organizacaoHabilitacao.st_revisao_final = null;
    },
  },
  methods: {
    ...mapActions({
      avaliarHabilitacao: 'organizacao/avaliarHabilitacao',
      revisarHabilitacao: 'organizacao/revisarHabilitacao',
      obterDadosOrganizacao: 'organizacao/obterDadosOrganizacao',
      downloadArquivo: 'shared/downloadArquivo',
    }),
    inicializarValoresComponente() {
      this.arquivosAvaliacao = Object.assign({}, this.arquivosAvaliacaoInicial);
      Object.keys(this.arquivosAvaliacao).forEach((indice) => {
        this.arquivosAvaliacao[indice] = Object.assign({
          st_em_conformidade: null,
          co_representante_arquivo: null,
          ds_observacao: String(),
          co_arquivo: null,
        });
      });
      this.possuiNovaPontuacao = null;

      if (!!this.formulario.organizacaoHabilitacao
        && !!this.formulario.organizacaoHabilitacao.co_organizacao_habilitacao
        && this.perfil.no_perfil === 'administrador') {
        this.resultadoItens.push({
          descricao: 'Habilitada e classificada',
          valor: '2',
        });
        this.resultadoItens.push({
          descricao: 'Habilitada e desclassificada',
          valor: '1',
        });
      }

      this.resultadoItens.push({
        descricao: 'Habilitada',
        valor: '3',
      });

      this.resultadoItens.push({
        descricao: 'Inabilitada',
        valor: '0',
      });
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
    salvar() {
      const self = this;
      if (!self.$refs.form_recurso.validate()) {
        return false;
      }
      self.loading = true;
      self.formulario.organizacaoHabilitacao.co_organizacao = self.formulario.co_organizacao;
      self.formulario.organizacaoHabilitacao.arquivosAvaliacao = Object.assign(self.arquivosAvaliacao);

      if (!this.formulario.organizacaoHabilitacao.co_organizacao_habilitacao) {
        this.avaliarHabilitacao(self.formulario.organizacaoHabilitacao).then((response) => {
          window.location.reload();
        }).finally(() => {
          self.loading = false;
        });
      } else {
        this.revisarHabilitacao({
          coOrganizacaoHabilitacao: self.formulario.organizacaoHabilitacao.co_organizacao_habilitacao,
          organizacaoHabilitacao: self.formulario.organizacaoHabilitacao,
        }).finally(() => {
          window.location.reload();
        });
      }
      return true;
    },
    abrirDialogo() {
      const self = this;
      if (!self.$refs.form_recurso.validate()) {
        return false;
      }
      this.modalConfirmacao = true;
      return true;
    },
    fecharDialogo() {
      this.modalConfirmacao = false;
    },
    desabilitarRevisaoHabilitacao() {
      return !!this.formulario.organizacaoHabilitacao.co_organizacao_habilitacao
        && this.perfil.no_perfil !== 'administrador'
        || (
          !!this.formulario.organizacaoHabilitacao.st_revisao_final
          && this.perfil.no_perfil === 'administrador'
        );
    },

  },
};
</script>
