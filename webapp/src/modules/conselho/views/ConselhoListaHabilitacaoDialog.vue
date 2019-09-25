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
          Habilitação - Conselho de cultura
        </v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-card-text>
        <v-form
          ref="form_recurso"
          v-model="valid"
        >
          <v-container v-if="!!avaliacaoArquivo.ata_reuniao_conselho">
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
                    Dados do conselho
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
                          <v-flex sm12>
                            <div class="ma-2 text-justify subheading grey--text">
                              <b>Nome do conselho:</b>
                              {{ formulario.no_conselho }}
                            </div>
                          </v-flex>
                        </v-layout>
                        <v-layout>
                          <v-flex sm6>
                            <div class="ma-2 text-justify subheading grey--text">
                              <b>CNPJ do orgão gestor:</b>
                              {{ formulario.cnpj_formatado }}
                            </div>
                          </v-flex>
                          <v-flex sm6>
                            <div class="ma-2 text-justify subheading grey--text">
                              <b>Nome do orgão gestor:</b>
                              {{ formulario.no_orgao_gestor }}
                            </div>
                          </v-flex>
                        </v-layout>
                        <div
                          class="ma-2 text-justify title "
                        >
                          <v-toolbar color="white darken-3">
                            Documentação
                          </v-toolbar>
                          <v-card>
                            <v-container
                              fluid
                              grid-list-xl
                            >
                              <v-layout
                                align-center
                                justify-center
                                class="mb-4"
                              >
                                <v-flex sm6>
                                  <v-card
                                    min-height="260"
                                    class="elevation-1"
                                  >
                                    <v-card-text>
                                      <v-layout>
                                        <v-flex
                                          class="text-md-center title"
                                          sm10
                                        >
                                          Ato normativo que constituiu o conselho
                                        </v-flex>
                                        <v-flex sm1>
                                          <v-icon
                                            right
                                            size="32px"
                                            color="blue darken-4"
                                          >
                                            cloud_download
                                          </v-icon>
                                        </v-flex>
                                      </v-layout>
                                      <v-layout>
                                        <v-flex class="pa-3">
                                          <v-radio-group
                                            v-model="avaliacaoArquivo.ata_reuniao_conselho.st_em_conformidade"
                                            label="* Documento em conformidade com o item 4.2.3 do edital?"
                                            column
                                            :disabled="!!formulario.conselhoHabilitacao.co_conselho_habilitacao"
                                          >
                                            <v-radio
                                              label="Sim"
                                              class="v-label"
                                              value="1"
                                            />
                                            <v-radio
                                              label="Não"
                                              class="v-label"
                                              value="0"
                                            />
                                          </v-radio-group>
                                        </v-flex>
                                      </v-layout>
                                      <v-layout>
                                        <v-flex class="pa-3">
                                          <v-textarea
                                            box
                                            label="Observação"
                                            name="input-7-4"
                                            v-model="avaliacaoArquivo.ata_reuniao_conselho.ds_observacao"
                                            rows="13"
                                            row-height="28"
                                            :counter="500"
                                            :rules="[rules.required, rules.tamanhoMaximo500Caracteres]"
                                            :disabled="!!formulario.conselhoHabilitacao.co_conselho_habilitacao"
                                          />
                                        </v-flex>
                                      </v-layout>
                                    </v-card-text>
                                  </v-card>
                                </v-flex>

                                <v-flex sm6>
                                  <v-card
                                    min-height="260"
                                    class="elevation-1"
                                  >
                                    <v-card-text>
                                      <v-layout>
                                        <v-flex
                                          class="text-md-center title"
                                          sm10
                                        >
                                          Ato normativo que constituiu o conselho
                                        </v-flex>
                                        <v-flex sm1>
                                          <v-icon
                                            right
                                            size="32px"
                                            color="blue darken-4"
                                          >
                                            cloud_download
                                          </v-icon>
                                        </v-flex>
                                      </v-layout>
                                      <v-layout>
                                        <v-flex class="pa-3">
                                          <v-radio-group
                                            v-model="avaliacaoArquivo.ato_normativo_conselho.st_em_conformidade"
                                            label="* Documento em conformidade com o item 4.2.3 do edital?"
                                            column
                                            :disabled="!!formulario.conselhoHabilitacao.co_conselho_habilitacao"
                                          >
                                            <v-radio
                                              label="Sim"
                                              class="v-label"
                                              value="1"
                                            />
                                            <v-radio
                                              label="Não"
                                              class="v-label"
                                              value="0"
                                            />
                                          </v-radio-group>
                                        </v-flex>
                                      </v-layout>
                                      <v-layout>
                                        <v-flex class="pa-3">
                                          <v-textarea
                                            box
                                            label="Observação"
                                            name="input-7-4"
                                            rows="13"
                                            row-height="28"
                                            :counter="500"
                                            :rules="[rules.required, rules.tamanhoMaximo500Caracteres]"
                                            v-model="avaliacaoArquivo.ato_normativo_conselho.ds_observacao"
                                            :disabled="!!formulario.conselhoHabilitacao.co_conselho_habilitacao"
                                          />
                                        </v-flex>
                                      </v-layout>
                                    </v-card-text>
                                  </v-card>
                                </v-flex>
                              </v-layout>
                              <v-layout
                                align-center
                                justify-center
                                class="mb-4"
                              >
                                <v-flex sm12>
                                  <v-card
                                    min-height="260"
                                    class="elevation-1"
                                  >
                                    <v-card-text>
                                      <v-layout>
                                        <v-flex
                                          class="text-md-center title"
                                          sm10
                                        >
                                          Ato normativo que constituiu o conselho
                                        </v-flex>
                                        <v-flex sm1>
                                          <v-icon
                                            right
                                            size="32px"
                                            color="blue darken-4"
                                          >
                                            cloud_download
                                          </v-icon>
                                        </v-flex>
                                      </v-layout>
                                      <v-layout>
                                        <v-flex class="pa-3">
                                          <v-radio-group
                                            v-model="avaliacaoArquivo.documento_identificacao_responsavel.st_em_conformidade"
                                            label="* Documento em conformidade com o item 4.2.3 do edital?"
                                            column
                                            :disabled="!!formulario.conselhoHabilitacao.co_conselho_habilitacao"
                                          >
                                            <v-radio
                                              label="Sim"
                                              class="v-label"
                                              value="1"
                                            />
                                            <v-radio
                                              label="Não"
                                              class="v-label"
                                              value="0"
                                            />
                                          </v-radio-group>
                                        </v-flex>
                                      </v-layout>
                                      <v-layout>
                                        <v-flex class="pa-3">
                                          <v-textarea
                                            box
                                            label="Observação"
                                            name="input-7-4"
                                            rows="13"
                                            row-height="28"
                                            :counter="500"
                                            :rules="[rules.required, rules.tamanhoMaximo500Caracteres]"
                                            v-model="avaliacaoArquivo.ato_normativo_conselho.ds_observacao"
                                            :disabled="!!formulario.conselhoHabilitacao.co_conselho_habilitacao"
                                          />
                                        </v-flex>
                                      </v-layout>
                                    </v-card-text>
                                  </v-card>
                                </v-flex>
                              </v-layout>
                            </v-container>
                          </v-card>
                        </div>
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
                                column
                                v-model="formulario.conselhoHabilitacao.st_avaliacao"
                                :disabled="!!formulario.conselhoHabilitacao.co_conselho_habilitacao"
                              >
                                <v-radio
                                  value="1"
                                  color="success"
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
                                v-model="formulario.conselhoHabilitacao.ds_parecer"
                                box
                                label="* Parecer"
                                name="input-7-4"
                                rows="13"
                                row-height="28"
                                :counter="3000"
                                :rules="[rules.required, rules.tamanhoMaximo3000Caracteres]"
                                :disabled="!!formulario.conselhoHabilitacao.co_conselho_habilitacao"
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
                        :loading="loading"
                        :disabled="!valid || loading || formulario.dh_parecer !== null"
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
                      <conselho-detalhes-inscricao-visualizacao />
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
import ConselhoDetalhesInscricaoVisualizacao from './ConselhoDetalhesInscricaoVisualizacao';

export default {
  name: 'ConselhoListaHabilitacaoDialog',
  components: {
    ConselhoDetalhesInscricaoVisualizacao,
  },
  props: {
    value: {
      type: Boolean,
      default: false,
    },
    conselho: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      avaliacaoArquivoInicial: {
        ata_reuniao_conselho: {
          st_em_conformidade: null,
          co_representante_arquivo: null,
          ds_observacao: String(),
        },
        ato_normativo_conselho: {
          st_em_conformidade: null,
          co_representante_arquivo: null,
          ds_observacao: String(),
        },
        documento_identificacao_responsavel: {
          st_em_conformidade: null,
          co_representante_arquivo: null,
          ds_observacao: String(),
        },
      },
      avaliacaoArquivo: {},
      confirmacaoDados: false,
      model: 'tab-1',
      modalConfirmacao: false,
      dialog: false,
      loading: false,
      valid: false,
      formularioInicial: {
        conselhoHabilitacao: {
          co_conselho_habilitacao: null,
          co_conselho: null,
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
  },
  watch: {
    value(valor) {
      this.dialog = valor;
    },
    conselho(valor) {
      this.formulario = Object.assign(this.formularioInicial, valor);
      this.avaliacaoArquivo = Object.assign({}, this.avaliacaoArquivoInicial);
      if (valor.conselhoHabilitacao) {
        this.atribuirValoresConformidade(valor.conselhoHabilitacao);
      }

      this.obterDadosConselho(valor.co_conselho);
    },
    dialog(valor) {
      this.$emit('input', valor);
      this.limparFormulario();
    },
  },
  methods: {
    ...mapActions({
      avaliarRecursoInscricao: 'recurso/avaliarRecursoInscricao',
      obterDadosConselho: 'conselho/obterDadosConselho',
    }),
    atribuirValoresConformidade(conselhoHabilitacao) {
      conselhoHabilitacao.arquivosAvaliacao.forEach((item) => {
        this.avaliacaoArquivo[item.tp_arquivo] = Object.assign({}, item);
      });
    },
    salvar() {
      const self = this;
      if (!self.$refs.form_recurso.validate()) {
        return false;
      }
      self.loading = true;
      this.avaliarRecursoInscricao(self.formulario)
        .then(() => {
          self.dialog = false;
        })
        .finally(() => {
          self.loading = false;
        });
      return true;
    },
    limparFormulario() {
      if (this.$refs.form_recurso) {
        this.$refs.form_recurso.reset();
      }
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
  mounted() {
    this.formulario = Object.assign({}, this.formularioInicial);
  },
  created() {

  },
};
</script>
