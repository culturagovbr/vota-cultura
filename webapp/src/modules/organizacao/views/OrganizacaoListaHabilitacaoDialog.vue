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
          Habilitação - Organizacao de cultura
        </v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-card-text>
        <v-form
          ref="form_recurso"
          v-model="valid"
        >
          <v-container v-if="!!arquivosAvaliacao.ata_reuniao_organizacao">
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
                    Dados do organizacao
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
                      <v-flex>



                        <v-list two-line>
                          <template>
                            <!--<v-subheader-->
                             <!---->
                            <!--&gt;-->
                              <!---->
                            <!--</v-subheader>-->

                            <v-divider
                            ></v-divider>

                            <v-list-tile
                              avatar
                              @click=""
                            >
                              <v-list-tile-avatar>
                                biruleibe
                              </v-list-tile-avatar>

                              <v-list-tile-content>
                                <v-list-tile-title v-html="`asdasd`"></v-list-tile-title>
                                <v-list-tile-sub-title v-html="`aasdas`"></v-list-tile-sub-title>
                              </v-list-tile-content>
                              <v-list-tile-action>
                                <v-btn icon ripple>
                                  <v-icon color="blue darken-4">cloud_download</v-icon>
                                </v-btn>
                              </v-list-tile-action>
                            </v-list-tile>
                          </template>
                          <template>
                            <!--<v-subheader-->
                             <!---->
                            <!--&gt;-->
                              <!---->
                            <!--</v-subheader>-->

                            <v-divider
                            ></v-divider>

                            <v-list-tile
                              avatar
                              @click=""
                            >
                              <v-list-tile-avatar>
                                biruleibe
                              </v-list-tile-avatar>

                              <v-list-tile-content>
                                <v-list-tile-title v-html="`asdasd`"></v-list-tile-title>
                                <v-list-tile-sub-title v-html="`aasdas`"></v-list-tile-sub-title>
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
                            <v-flex class="pa-3">
                              <v-radio-group
                                v-model="formulario.organizacaoHabilitacao.st_avaliacao"
                                column
                                :rules="[rules.required]"
                                :disabled="!!formulario.organizacaoHabilitacao.co_organizacao_habilitacao"
                              >
                                <v-radio
                                  value="1"
                                  color="success"
                                  :disabled="!avaliacaoPositiva"
                                >
                                  <template v-slot:label>
                                    <div><strong class="success--text">Habilitado</strong></div>
                                  </template>
                                </v-radio>
                                <v-radio
                                  value="0"
                                  color="error"
                                >
                                  <template v-slot:label>
                                    <div><strong class="error--text">Inabilitado</strong></div>
                                  </template>
                                </v-radio>
                              </v-radio-group>
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
                                :counter="3000"
                                :rules="[rules.required, rules.tamanhoMaximo3000Caracteres]"
                                :disabled="!!formulario.organizacaoHabilitacao.co_organizacao_habilitacao"
                              />
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card>
                    </div>
                    <v-card-actions class="justify-center">
                      <v-btn
                        @click="dialog = false"
                      >
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
        max-width="290"
      >
        <v-card>
          <v-card-title class="headline">
            Deseja realmente enviar?
          </v-card-title>

          <v-card-text>
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
<style scoped>
  .v-label {
    font-size: 14px;
  }
</style>
<script>
import { mapGetters, mapActions } from 'vuex';
import OrganizacaoDetalhesInscricaoVisualizacao from './OrganizacaoDetalhesInscricaoVisualizacao';

export default {
  name: 'OrganizacaoListaHabilitacaoDialog',
  components: {
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
      arquivosAvaliacaoInicial: {
        ata_reuniao_organizacao: {
          st_em_conformidade: null,
          co_representante_arquivo: null,
          ds_observacao: String(),
          co_arquivo: null,
        },
        ato_normativo_organizacao: {
          st_em_conformidade: null,
          co_representante_arquivo: null,
          ds_observacao: String(),
          co_arquivo: null,
        },
        documento_identificacao_responsavel: {
          st_em_conformidade: null,
          co_representante_arquivo: null,
          ds_observacao: String(),
          co_arquivo: null,
        },
      },
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
        },
      },
      formulario: {},
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
        tamanhoMaximo3000Caracteres: value => (!!value && value.length <= 3000) || 'Máximo 3000 caracteres',
        tamanhoMaximo500Caracteres: value => (!!value && value.length <= 500) || 'Máximo 500 caracteres',
      },
    };
  },
  computed: {
    ...mapGetters({
      perfis: 'conta/perfis',
      perfisInscricao: 'conta/perfisInscricao',
    }),
    avaliacaoPositiva: function() {
      const avaliacao = (!!this.arquivosAvaliacao && this.arquivosAvaliacao.ata_reuniao_organizacao.st_em_conformidade === '1'
        && this.arquivosAvaliacao.ato_normativo_organizacao.st_em_conformidade === '1'
        && this.arquivosAvaliacao.documento_identificacao_responsavel.st_em_conformidade === '1');

      if (!this.formulario.organizacaoHabilitacao.co_organizacao_habilitacao && !avaliacao) {
        this.formulario.organizacaoHabilitacao.st_avaliacao = '0';
      }

      return avaliacao;
    },
  },
  watch: {
    value(valor) {
      this.dialog = valor;
      if (!valor) {
        this.formulario.organizacaoHabilitacao = Object.assign({}, this.formularioInicial.organizacaoHabilitacao);
        this.arquivosAvaliacao = Object.assign({}, this.arquivosAvaliacaoInicial);
        // this.$refs.form_recurso.reset();
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

        this.arquivosAvaliacao = Object.assign({}, this.arquivosAvaliacaoInicial);

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
  },
  methods: {
    ...mapActions({
      avaliarHabilitacao: 'organizacao/avaliarHabilitacao',
      obterDadosOrganizacao: 'organizacao/obterDadosOrganizacao',
      downloadArquivo: 'shared/downloadArquivo',
    }),
    atribuirValoresConformidade(organizacaoHabilitacao) {
      organizacaoHabilitacao.arquivosAvaliacao.forEach((item) => {
        this.arquivosAvaliacao[item.tp_arquivo] = Object.assign({}, item);
      });
    },
    salvar() {
      const self = this;
      if (!self.$refs.form_recurso.validate()) {
        return false;
      }
      self.loading = true;
      self.formulario.organizacaoHabilitacao.co_organizacao = self.formulario.co_organizacao;
      self.formulario.organizacaoHabilitacao.arquivosAvaliacao = self.arquivosAvaliacao;
      this.avaliarHabilitacao(self.formulario.organizacaoHabilitacao)
        .then(() => {
          window.location.reload();
        })
        .finally(() => {
          self.loading = false;
        });
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
  },
};
</script>
