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
          Visualizar indicado - Conselho de cultura
        </v-toolbar-title>

        <v-spacer />
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-container
            grid-list-md
          >
            <v-layout
              row
              wrap
            >
              <v-flex>
                <v-card>
                  <v-toolbar
                    color="white elevation-1"
                  >
                    <v-toolbar-title>Dados básicos</v-toolbar-title>
                  </v-toolbar>
                  <v-card-text>
                    <v-container
                      grid-list-md
                    >
                      <v-layout>
                        <v-flex md8>
                          <v-layout>
                            <v-flex md12>
                              <v-text-field
                                v-model="formulario.nu_cpf_indicado"
                                placeholder="999.999.999-99"
                                append-icon="person"
                                name="login"
                                label="*CPF"
                                mask="###.###.###-##"
                                validate-on-blur
                                type="text"
                                disabled
                              />
                            </v-flex>
                          </v-layout>
                          <v-layout>
                            <v-flex md12>
                              <v-text-field
                                v-model="formulario.no_indicado"
                                append-icon="person_outline"
                                name="login"
                                label="*Nome completo"
                                validate-on-blur
                                type="text"
                                :disabled="true"
                              />
                            </v-flex>
                          </v-layout>
                          <v-layout>
                            <v-flex md12>
                              <v-text-field
                                v-model="formulario.dt_nascimento_indicado"
                                label="*Data de Nascimento"
                                append-icon="event"
                                placeholder="ex: 01/12/2019"
                                return-masked-value
                                mask="##/##/####"
                                disabled
                              />
                            </v-flex>
                          </v-layout>

                          <v-layout>
                            <v-flex md12>
                              <v-select
                                v-model="(formulario.endereco || {}).co_ibge"
                                :items="listaUF"
                                label="*Unidade da federação em que reside"
                                append-icon="place"
                                item-value="co_ibge"
                                item-text="no_uf"
                                disabled
                                box
                              />
                            </v-flex>
                          </v-layout>
                          <v-layout>
                            <v-flex md12>
                              <v-select
                                v-model="(formulario.endereco || {} ).co_municipio"
                                :items="listaMunicipios"
                                label="*Cidade em que reside"
                                append-icon="place"
                                item-value="co_municipio"
                                item-text="no_municipio"
                                box
                                disabled
                              />
                            </v-flex>
                          </v-layout>

                          <v-layout>
                            <v-flex md12>
                              <v-textarea
                                v-model="formulario.ds_curriculo"
                                label="* Currículo resumido para a candidatura"
                                rows="13"
                                row-height="28"
                                :counter="1000"
                                box
                                auto-grow
                                disabled
                              />
                              <span>
                                Atenção! O texto do currículo resumido ficará disponível na plataforma de votação e será a defesa da candidatura do indicado.
                              </span>
                            </v-flex>
                          </v-layout>
                        </v-flex>
                        <v-flex
                          md4
                          class="text-md-center"
                        >
                          <v-content>
                            <img
                              width="260"
                              style="border-radius:50px;"
                              :src="(formulario || {}).foto_indicado"
                            >
                          </v-content>
                        </v-flex>
                      </v-layout>
                    </v-container>
                  </v-card-text>
                </v-card>
              </v-flex>

              <v-flex v-if="(formulario.arquivos || []).length > 0">
                <v-card>
                  <v-toolbar
                    color="white elevation-1"
                  >
                    <v-toolbar-title>Documentação</v-toolbar-title>
                  </v-toolbar>
                  <v-card-text>
                    <v-container
                      grid-list-md
                    >
                      <div class="ma-4 text-justify">
                        <v-toolbar color="white darken-3 title">
                          Documentação
                        </v-toolbar>
                        <v-card class="elevation-1">
                          <v-container
                            fluid
                            grid-list-xl
                          >
                            <v-layout>
                              <v-flex class="pa-3">
                                <v-list
                                  two-line
                                >
                                  <template>
                                    <v-layout
                                      v-for="(documento, index) in formulario.arquivos"
                                      :key="index"
                                    >
                                      <v-flex
                                        class="text-md-left"
                                        sm10
                                      >
                                        <span v-html="obterDescricaoDocumento(documento.tp_arquivo)" />
                                      </v-flex>
                                      <v-flex sm1>
                                        <v-icon
                                          right
                                          size="32px"
                                          color="blue darken-4"
                                          @click="downloadArquivo(documento.co_arquivo)"
                                        >
                                          cloud_download
                                        </v-icon>
                                      </v-flex>
                                    </v-layout>
                                  </template>
                                </v-list>
                              </v-flex>
                            </v-layout>
                          </v-container>
                        </v-card>
                      </div>
                    </v-container>
                  </v-card-text>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
          <v-footer
            height="auto"
            color="white lighten-1 justify-center"
          >
            <v-btn
              @click="dialog = false"
            >
              <v-icon left>
                undo
              </v-icon>
              Voltar
            </v-btn>
          </v-footer>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
import { documentosIndicacao } from '../api/documentosIndicacao';

export default {
  name: 'ConselhoIndicacaoDialogo',
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
      dialog: false,
      listaMunicipios: [],
      listaUF: [],
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
      usuarioLogado: {},
      fotoIndicado: {},
    };
  },
  computed: {
    ...mapGetters({
      perfis: 'conta/perfis',
      perfisInscricao: 'conta/perfisInscricao',
      estadosGetter: 'localidade/estados',
      municipiosGetter: 'localidade/municipios',
    }),
  },
  watch: {
    value(valor) {
      this.dialog = valor;
    },
    dialog(valor) {
      this.$emit('input', valor);
    },
    conselho(valor) {
      this.formulario.conselhoHabilitacao = valor || this.formularioInicial;
      if (Object.keys(valor).length > 0) {
        this.formulario = valor || {};
      }
    },
    estadosGetter(value) {
      this.listaUF = value;
    },
    municipiosGetter(valor) {
      this.listaMunicipios = valor;
    },
    formulario(valor) {
      if (this.listaMunicipios.length < 1 && Object.keys(this.formulario.endereco).length > 0) {
        this.obterMunicipios(this.formulario.endereco.co_ibge);
      }
    },
  },
  methods: {
    ...mapActions({
      downloadArquivo: 'shared/downloadArquivo',
      obterMunicipios: 'localidade/obterMunicipios',
    }),
    obterDescricaoDocumento(tpArquivo) {
      const indiceDocumento = documentosIndicacao.findIndex(elemento => (elemento || {}).slug === tpArquivo);
      if (indiceDocumento === -1) {
        return 'Documento inválido';
      }
      return documentosIndicacao[indiceDocumento].descricao;
    },
  },
  mounted() {
    this.usuarioLogado = this.usuario;
  },

};
</script>
