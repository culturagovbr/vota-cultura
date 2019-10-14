<template>
  <v-dialog
    v-model="dialog"
    fullscreen
    hide-overlay
    transition="dialog-bottom-transition"
    v-if="formulario.length > 0"
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
          Cadastrar
        </v-toolbar-title>

        <v-spacer />
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-card>
            <v-toolbar
              color="white elevation-1"
            >
              <v-toolbar-title>Indicação</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
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
                        color="white elevation-0"
                      >
                        <v-toolbar-title>Dados básicos</v-toolbar-title>
                      </v-toolbar>
                      <v-card-text>
                        <v-container
                          grid-list-md
                        >
                          <v-layout>
                            <v-flex md3>
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
                            <v-flex
                              md3
                              offset-md7
                              style="margin-bottom: -272px; top: -86px; position: relative;"
                            >
                              <!--<file-->
                                <!--v-model="indicado_foto_rosto"-->
                                <!--style-panel-layout="compact circle"-->
                                <!--style-load-indicator-position="center bottom"-->
                                <!--style-progress-indicator-position="right bottom"-->
                                <!--style-button-remove-item-position="left bottom"-->
                                <!--style-button-process-item-position="right bottom"-->
                                <!--label-idle="Clique aqui para anexar foto do rosto (JPEG/JPG))"-->
                                <!--:accepted-file-types="['image/jpeg']"-->
                              <!--/>-->
                            </v-flex>
                          </v-layout>

                          <v-layout>
                            <v-flex md9>
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
                            <v-flex md3>
                              <v-select
                                v-model="formulario.endereco.co_ibge"
                                :items="listaUF"
                                label="*Unidade da federação em que reside"
                                append-icon="place"
                                item-value="co_ibge"
                                item-text="no_uf"
                                required
                                box
                              />
                            </v-flex>
                            <v-flex
                              md3
                            >
                              <v-select
                                v-model="formulario.endereco.co_municipio"
                                :items="listaMunicipios"
                                label="*Cidade em que reside"
                                append-icon="place"
                                item-value="co_municipio"
                                item-text="no_municipio"
                                box
                                :disabled="formulario.endereco.co_ibge < 1 || formulario.endereco.co_ibge == null"
                              />
                            </v-flex>
                            <v-flex md3>
                              <template activator="{ on }">
                                <v-menu
                                  ref="menu"
                                  v-model="menu"
                                  lazy
                                  transition="scale-transition"
                                  :close-on-content-click="false"
                                  offset-y
                                  full-width
                                  min-width="290px"
                                >
                                  <template v-slot:activator="{ on }">
                                    <v-text-field
                                      v-model="formulario.dt_nascimento_indicado"
                                      label="*Data de Nascimento"
                                      append-icon="event"
                                      placeholder="ex: 01/12/2019"
                                      return-masked-value
                                      mask="##/##/####"
                                      required
                                      v-on="on"
                                    />
                                  </template>
                                  <v-date-picker
                                    v-model="date"
                                    locale="pt-BR"
                                    scrollable
                                  >
                                    <v-spacer />
                                    <v-btn
                                      flat
                                      color="primary"
                                      @click="menu = false"
                                    >
                                      Cancel
                                    </v-btn>
                                    <v-btn
                                      flat
                                      color="primary"
                                      @click="$refs.menu.save(date)"
                                    >
                                      OK
                                    </v-btn>
                                  </v-date-picker>
                                </v-menu>
                              </template>
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
                              />
                              <span>
                                  Atenção! O texto do currículo resumido ficará disponível na plataforma de votação e será a defesa da candidatura do indicado.
                                </span>
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card-text>
                    </v-card>
                  </v-flex>

                  <v-flex>
                    <v-card>
                      <v-toolbar
                        color="white elevation-0"
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
                                    <v-list two-line>
                                      <!--<template-->
                                        <!--v-for="documento in documentos"-->
                                      <!--&gt;-->
                                        <!--&lt;!&ndash;<v-layout>&ndash;&gt;-->
                                          <!--&lt;!&ndash;<v-flex&ndash;&gt;-->
                                            <!--&lt;!&ndash;class="text-md-center title"&ndash;&gt;-->
                                            <!--&lt;!&ndash;sm10&ndash;&gt;-->
                                          <!--&lt;!&ndash;&gt;&ndash;&gt;-->
                                            <!--&lt;!&ndash;Ato normativo que constituiu o conselho&ndash;&gt;-->
                                          <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                          <!--&lt;!&ndash;<v-flex sm1>&ndash;&gt;-->
                                            <!--&lt;!&ndash;<v-icon&ndash;&gt;-->
                                              <!--&lt;!&ndash;right&ndash;&gt;-->
                                              <!--&lt;!&ndash;size="32px"&ndash;&gt;-->
                                              <!--&lt;!&ndash;color="blue darken-4"&ndash;&gt;-->
                                              <!--&lt;!&ndash;@click="downloadArquivo(arquivosAvaliacao.ata_reuniao_conselho.co_arquivo)"&ndash;&gt;-->
                                            <!--&lt;!&ndash;&gt;&ndash;&gt;-->
                                              <!--&lt;!&ndash;cloud_download&ndash;&gt;-->
                                            <!--&lt;!&ndash;</v-icon>&ndash;&gt;-->
                                          <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                        <!--&lt;!&ndash;</v-layout>&ndash;&gt;-->
                                      <!--</template>-->
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
            </v-card-actions>
          </v-card>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';

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
      console.log(valor);
      this.dialog = valor;
    },
    dialog(valor) {
      console.log(valor);
      this.$emit('input', valor);
    },
    conselho(valor) {
      console.log(valor)
      if (Object.keys(valor).length) {
        this.formulario = Object.assign({}, valor);
      }
    },
    estadosGetter() {
      this.listaUF = this.estadosGetter;
    },
    municipiosGetter() {
      this.listaMunicipios = this.municipiosGetter;
    },
  },
  methods: {
    ...mapActions({
      downloadArquivo: 'shared/downloadArquivo',
    }),
  },
};
</script>
