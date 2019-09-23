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
        <v-container>
          <v-card>
            <v-card-text>
              <v-tabs
                v-model="model"
                centered
                color="cyan"
                slider-color="yellow"
              >
                <v-tabs-slider />
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
                  <v-card flat>
                    <v-divider />

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm12
                        class="ma-3"
                      >
                        <div class="ma-4 text-justify subheading grey--text">
                          <b>Documentação:</b>
                        </div>
                        <v-container
                          fluid
                          grid-list-xl
                        >
                          <v-layout
                            align-center
                            justify-center
                            class="mb-4"
                            wrap
                          >
                            <v-flex sm4>
                              <v-card
                                min-height="260"
                                class="mx-auto"
                              >
                                <v-card-text class="mb-1">
                                  <div class="justify-center mb-1">
                                    Ato normativo que constituiu o conselho
                                  </div>
                                  <div class="justify-center mb-1 center">
                                    <v-icon
                                      size="40px"
                                      color="blue darken-4"
                                    >
                                      cloud_download
                                    </v-icon>
                                  </div>
                                  <p>
                                    * Documento em conformidade com o item 4.2.3 do edital?
                                  </p>
                                  <v-layout>
                                    <v-flex>
                                      <v-radio-group
                                        v-model="conselho.st_em_conformidade"
                                        disabled
                                        row
                                      >
                                        <v-radio
                                          label="Estadual"
                                          value="e"
                                        />
                                        <v-radio
                                          label="Capital"
                                          value="c"
                                        />
                                      </v-radio-group>
                                    </v-flex>
                                  </v-layout>
                                </v-card-text>
                              </v-card>
                            </v-flex>
                            <v-flex sm4>
                              <v-card
                                min-height="260"
                                class="mx-auto"
                              >
                                <v-card-title class=" mb-1">
                                  Ata da última reunião do conselho
                                  <p>
                                    * Documento em conformidade com o item 4.2.3 do edital?
                                  </p>
                                  <p />
                                </v-card-title>
                                <v-card-text />
                              </v-card>
                            </v-flex>
                            <v-flex sm4>
                              <v-card
                                min-height="260"
                                class="mx-auto"
                              >
                                <v-card-title class=" mb-1">
                                  Documento de identificação do representante com CPF
                                  <p>
                                    * Documento em conformidade com o item 4.2.3 do edital?
                                  </p>
                                </v-card-title>
                                <v-card-text />
                              </v-card>
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-flex>
                    </v-layout>
                  </v-card>
                </v-tab-item>
                <v-tab-item
                  value="tab-2"
                >
                  <v-card flat>
                    <conselho-detalhes-inscricao-visualizacao />
                  </v-card>
                </v-tab-item>
              </v-tabs-items>
              <!--<v-form-->
              <!--ref="form_recurso"-->
              <!--v-model="valid"-->
              <!--lazy-validation-->
              <!--&gt;-->
              <!--</v-form>-->
            </v-card-text>
          </v-card>
        </v-container>
      </v-card-text>
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
  },
  data() {
    return {
      avaliacaoArquivo: {
        ata_reuniao_conselho: {
          st_em_conformidade: '',
        },
        ato_normativo_conselho: {
          st_em_conformidade: '',
        },
        documento_identificacao_responsavel: {
          st_em_conformidade: '',
        },
      },
      confirmacaoDados: false,
      model: 'tab-1',
      modalConfirmacao: false,
      dialog: false,
      loading: false,
      valid: false,
      formulario: { no_nome: String(), ds_parecer: String() },
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
        tamanhoMaximoCaracteres: value => (!!value && value.length <= 3000) || 'Máximo 3000 caracteres',
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
    value(val) {
      this.dialog = val;
    },
    dialog(valor) {
      this.$emit('input', valor);
      this.formulario = Object.assign({});
      this.$refs.form_recurso.reset();
    },
  },
  methods: {
    ...mapActions({
      avaliarRecursoInscricao: 'recurso/avaliarRecursoInscricao',
    }),
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
    // this.buscarPerfisAlteracao();
  },
};
</script>
