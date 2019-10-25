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
          @click="fecharDialogo"
        >
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>
          Habilitação - Indicados do conselho de cultura
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
                <v-tab-item value="tab-1">
                  <div class="ma-4 text-justify title ">
                    <v-toolbar color="white darken-3">
                      Dados básicos
                    </v-toolbar>
                    <v-card class="elevation-1">
                      <v-container>
                        <v-layout>
                          <v-flex md8>
                            <v-layout>
                              <v-flex md6>
                                <v-text-field
                                  v-model="indicado.nu_cpf_indicado"
                                  placeholder="999.999.999-99"
                                  append-icon="person"
                                  name="login"
                                  label="CPF"
                                  mask="###.###.###-##"
                                  disabled
                                />
                              </v-flex>
                              <v-flex md6>
                                <v-text-field
                                  v-model="indicado.dt_nascimento_indicado"
                                  label="Data de nascimento"
                                  append-icon="event"
                                  mask="##/##/####"
                                  required
                                  disabled
                                />
                              </v-flex>
                            </v-layout>
                            <v-layout>
                              <v-flex md12>
                                <v-text-field
                                  v-model="indicado.no_indicado"
                                  append-icon="person_outline"
                                  name="login"
                                  label="Nome completo"
                                  validate-on-blur
                                  type="text"
                                  disabled
                                />
                              </v-flex>
                            </v-layout>

                            <v-layout>
                              <v-flex md12>
                                <v-text-field
                                  v-model="(((indicado.endereco || {}).municipio||{}).uf || {}).no_uf"
                                  :items="listaUF"
                                  label="Unidade da federação em que reside"
                                  append-icon="place"
                                  disabled
                                  box
                                />
                              </v-flex>
                            </v-layout>

                            <v-layout>
                              <v-flex
                                md12
                                ma3
                              >
                                <v-text-field
                                  v-model="((indicado.endereco || {}).municipio||{}).no_municipio"
                                  append-icon="place"
                                  label="Cidade em que reside"
                                  box
                                  type="text"
                                  disabled
                                />
                              </v-flex>
                            </v-layout>
                          </v-flex>
                          <v-flex
                            v-show="$vuetify.breakpoint.smAndUp"
                            md4
                            sm12
                            xs12
                            align-center
                            justify-center
                            layout
                            text-xs-center
                          >
                            <v-avatar
                              size="280"
                              tile
                              color="grey lighten-4"
                            >
                              <img
                                style="border-radius: 10px"
                                :src="indicado.foto_indicado"
                                alt="avatar"
                              >
                            </v-avatar>
                          </v-flex>
                        </v-layout>
                        <v-layout>
                          <v-flex md12>
                            <v-textarea
                              v-model="indicado.ds_curriculo"
                              label="Currículo resumido para a candidatura"
                              rows="13"
                              row-height="28"
                              box
                              disabled
                              auto-grow
                            />
                          </v-flex>
                        </v-layout>
                      </v-container>
                    </v-card>
                  </div>


                  <div class="ma-4 text-justify title ">
                    <v-toolbar color="white darken-3">
                      Documentação
                    </v-toolbar>
                    <v-card class="elevation-1">
                      <v-container
                        fluid
                        grid-list-xl
                      >
                        <v-layout>
                          <v-flex v-if="(indicado.arquivos || []).length > 0">
                            <v-container
                              grid-list-md
                            >
                              <v-container
                                fluid
                                grid-list-xl
                              >
                                <v-layout>
                                  <v-flex class="pa-3">
                                    <v-list
                                      two-line
                                    >
                                      <v-list-tile
                                        v-for="(documento, index) in indicado.arquivos"
                                        :key="index"
                                        avatar
                                        @click="downloadArquivo(documento.co_arquivo)"
                                      >
                                        <v-list-tile-content>
                                          <v-list-tile-title v-html="obterDescricaoDocumento(documento.tp_arquivo)" />
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
                                    </v-list>
                                  </v-flex>
                                </v-layout>
                              </v-container>
                            </v-container>
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
                      <v-form
                        ref="formulario"
                        v-model="valid"
                        lazy-validation
                      >
                        <v-container
                          fluid
                          grid-list-xl
                        >
                          <v-layout>
                            <v-flex class="pa-3">
                              <v-radio-group
                                v-model="(formulario || {}).st_avaliacao"
                                column
                                :rules="[rules.required]"
                                :disabled="(formulario || {}).st_revisao_final"
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
                              <ckeditor
                                :disabled="(formulario || {}).st_revisao_final"
                                :editor="editor"
                                v-model="(formulario || {}).ds_parecer"
                                :config="editorConfig"></ckeditor>
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-form>
                    </v-card>
                  </div>

                  <v-card-actions class="justify-center">
                    <v-btn
                      @click="fecharDialogo"
                    >
                      <v-icon left>
                        undo
                      </v-icon>
                      Voltar
                    </v-btn>
                    <v-btn
                      :loading="loading"
                      :disabled="!valid || loading"
                      color="primary"
                      @click="abrirDialogoConfirmacao"
                      v-if="!(formulario || {}).st_revisao_final"
                    >
                      <span v-if="!!(indicado || {}).avaliacaoHabilitacao">Revisar</span>
                      <span v-else>Avaliar</span>
                      <v-icon right>
                        send
                      </v-icon>
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
      </v-card-text>
    </v-card>


    <v-layout justify-center>
      <v-dialog
        v-model="modalConfirmacao"
        max-width="360"
      >
        <v-card>
          <v-card-title class="headline">
            Deseja realmente&nbsp;
            <span v-if="(indicado.avaliacaoHabilitacao || {}).co_conselho_indicacao_habilitacao">
              revisar?
            </span>
            <span v-else>
              enviar?
            </span>
          </v-card-title>

          <v-card-text v-if="(indicado.avaliacaoHabilitacao || {}).co_conselho_indicacao_habilitacao">
            <span class="subheading">
              Indique abaixo se é uma revisão final:
            </span>

            <v-container>
              <v-layout>
                <v-flex>
                  <v-checkbox
                    v-model="(formulario || {}).st_revisao_final"
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

          <v-card-actions>
            <v-spacer />

            <v-btn
              color="red darken-1"
              text
              flat
              @click="fecharDialogoConfirmacao"
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
import { documentosIndicacao } from '../api/documentosIndicacao';
import Vue from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import '@ckeditor/ckeditor5-build-classic/build/translations/pt-br';

Vue.use(CKEditor);

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
    indicado: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      editor: ClassicEditor,
      editorConfig: {
        placeholder: 'Parecer',
        toolbar: [
          'Bold',
          'Italic',
          'Alignment',
          'Link',
          'NumberedList',
          'BulletedList',
          'List',
          'BlockQuote',
          'Undo',
          'Redo',
        ],
        language: 'pt-br',
      },
      listaUF: [],
      listaMunicipios: [],
      model: 'tab-1',
      modalConfirmacao: false,
      dialog: false,
      loading: false,
      valid: false,
      arquivosAvaliacao: {},
      formulario: {},
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        tamanhoMaximo15000Caracteres: value => (!!value && value.length <= 15000) || 'Máximo 15000 caracteres',
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
    dialog(valor) {
      this.$refs.formulario.reset();
      this.$emit('input', valor);
    },
    estadosGetter(estados) {
      this.listaUF = estados;
    },
    municipiosGetter() {
      this.listaMunicipios = this.municipiosGetter;
    },
    indicado(indicado) {
      this.formulario.st_revisao_final = null;
      if ((indicado.conselho || {}).co_conselho) {
        this.obterDadosConselho(indicado.conselho.co_conselho);
      }

      if (indicado.avaliacaoHabilitacao) {
        this.formulario.ds_parecer = indicado.avaliacaoHabilitacao.ds_parecer;
        this.formulario.st_revisao_final = indicado.avaliacaoHabilitacao.st_revisao_final;
        this.formulario.st_avaliacao = indicado.avaliacaoHabilitacao.st_avaliacao ? '1' : '0';
        this.formulario.co_conselho_indicacao_habilitacao = indicado
          .avaliacaoHabilitacao.co_conselho_indicacao_habilitacao;
      }
    },
  },
  methods: {
    ...mapActions({
      obterDadosConselho: 'conselho/obterDadosConselho',
      downloadArquivo: 'shared/downloadArquivo',
      avaliarHabilitacaoIndicacao: 'conselho/avaliarHabilitacaoIndicacao',
      notificarErro: 'app/setMensagemErro',
      notificarSucesso: 'app/setMensagemSucesso',
      obterListaIndicacaoConselho: 'conselho/obterListaIndicacaoConselho',
    }),
    obterDescricaoDocumento(tpArquivo) {
      const indiceDocumento = documentosIndicacao.findIndex(elemento => (elemento || {}).slug === tpArquivo);
      if (indiceDocumento === -1) {
        return 'Documento inválido';
      }
      return documentosIndicacao[indiceDocumento].descricao;
    },
    atribuirValoresConformidade(conselhoHabilitacao) {
      conselhoHabilitacao.arquivosAvaliacao.forEach((item) => {
        this.arquivosAvaliacao[item.tp_arquivo] = Object.assign({}, item);
      });
    },
    salvar() {
      this.formulario.co_indicado = this.indicado.co_conselho_indicacao;
      const payload = Object.assign({}, this.formulario);
      this.avaliarHabilitacaoIndicacao(payload).then(() => {
        this.notificarSucesso('Habilitação salva com sucesso.');
        this.obterListaIndicacaoConselho();
      }).catch((error) => {
        this.notificarErro(error.response.data.message);
      }).finally(() => {
        this.fecharDialogoConfirmacao();
        this.fecharDialogo();
      });
    },
    abrirDialogoConfirmacao() {
      if (!this.$refs.formulario.validate()) {
        return;
      }
      if (!(this.formulario.ds_parecer || '').length) {
        this.notificarErro('Parecer obrigatório');
        return;
      }
      this.modalConfirmacao = true;
    },
    fecharDialogoConfirmacao() {
      this.modalConfirmacao = false;
    },
    abrirDialogo() {
      this.dialog = true;
    },
    fecharDialogo() {
      this.dialog = false;
    },
  },
};
</script>
