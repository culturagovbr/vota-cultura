<template>
  <v-container>

    <carregando
      v-if="loading"
    />
    <v-card v-if="!loading">
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>Recurso da Habilitação</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-form
          ref="form_recurso_habilitacao"
          v-model="valid"
          lazy-validation
        >
          <v-layout class="mt-1">
            <v-flex
              xs12
              sm6
            >
              <div class="ma-12 text-justify subheading grey--text">
                <span class="font-weight-bold">Nome do conselho:</span> {{ conselho.no_conselho }}
              </div>
            </v-flex>
          </v-layout>


          <v-layout class="mt-1">
            <v-flex
              md12
              subheading
              grey--text
              mt-2
              d-inline-flex
            >
              <div class="md6">
                <span class="font-weight-bold">CNPJ do órgão gestor do conselho:</span> {{ conselho.cnpj_formatado }}
              </div>

              <div class="md6">
                <span class="font-weight-bold">Nome do órgão Gestor:</span> {{ conselho.no_orgao_gestor }}
              </div>
            </v-flex>
          </v-layout>

          <v-card
            class="ma-3"
          >
            <v-layout
              wrap
              align-center
            >
              <v-flex
                xs12
                sm12
              >
                <div class="ma-4 text-justify subheading grey--text">
                  Ilmo Sr. Secretário da Diversidade Cultural, <br /><br />
                  com base no <b>item 6</b> deste edital de CHAMADA PÚBLICA PARA COMPOSIÇÃO DO
                  CONSELHO NACIONAL DE POLÍTICA CULTURAL (CNPC) no triênio 2019/2022,
                  venho interpor recurso em face do resultado na etapa de habilitação pelos motivos
                  abaixo descritos:
                </div>
              </v-flex>
            </v-layout>
            <v-layout
              wrap
              align-center
            >
              <v-flex
                xs12
                sm12
                class="ma-3"
              >
                <v-textarea
                  v-model="recursoHabilitacao.ds_recurso"
                  :readonly="recursoHabilitacao.isLocked"
                  :disabled="recursoHabilitacao.isLocked"
                  name="input-7-1"
                  box
                  solo
                  label="Descrição do recurso"
                  auto-grow
                  :placeholder="'Digite seu recurso aqui.'"
                  :counter="3000"
                  :rules="[rules.required, rules.tamanhoMaximoCaracteres]"
                />
              </v-flex>
            </v-layout>

            <v-card v-if="Object.keys(recursoHabilitacao.anexo).length > 0 && recursoHabilitacao.isLocked">
              <v-toolbar
                dark
                color="primary"
              >
              <v-toolbar-title>Documentação enviada</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-container
                  grid-list-md
                  text-xs-center
                >
                  <v-layout
                    row
                    wrap
                  >
                    <v-flex
                      xs12
                      text-xs-center
                    >
                      <v-card
                        color="blue-grey lighten-5"
                      >
                        <v-card-title primary-title>
                           {{ recursoHabilitacao.anexo.no_arquivo }}
                            <v-flex sm1>
                              <v-icon
                                right
                                size="32px"
                                color="blue darken-4"
                                @click="downloadArquivo(recursoHabilitacao.anexo.co_arquivo, true)"
                              >
                                cloud_download
                              </v-icon>
                            </v-flex>
                        </v-card-title>
                        <v-card-actions />
                      </v-card>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card-text>
            </v-card>

            <v-layout
              v-if="!recursoHabilitacao.isLocked"
              wrap
              align-center
              class="grey--text subheading text-lg-center"
            >
              <v-flex
                xs12
                sm12
                class="ma-2"
                v-if="!recursoHabilitacao.isLocked"
              >
                <div class="lg-12">
                  Caso seja necessário, anexe documento no formato PDF (preferencialmente), JPEG. Para enviar mais de um arquivo utilize ZIP ou RAR.
                </div>
                <div class="lg-12 font-weight-bold align-items-center">
                  Atenção!
                </div>
                <div class="lg-12 align-items-center">
                  Anexe arquivos com tamanho até 40MB.
                </div>
              </v-flex>
            </v-layout>
            <v-layout
              v-if="!recursoHabilitacao.isLocked"
              align-center
              justify-center
              class="mb-4"
              wrap
            >
              <v-flex md12>
                <v-card
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-text>
                    <file
                      v-model="recursoHabilitacao.anexo"
                      :readonly="recursoHabilitacao.isLocked"
                      :disabled="recursoHabilitacao.isLocked"
                    />
                    <v-input
                      error
                      disabled
                    />
                  </v-card-text>
                </v-card>
              </v-flex>
            </v-layout>
          </v-card>
        </v-form>
      </v-card-text>
      <v-layout
        wrap
        align-center
      >
        <v-flex offset-xs5>
          <v-btn to="/">
            Cancelar
          </v-btn>
          <v-btn
            :readonly="recursoHabilitacao.isLocked"
            :disabled="recursoHabilitacao.isLocked || !valid"
            color="primary"
            @click="abrirDialogo"
          >
            Enviar
          </v-btn>
        </v-flex>
      </v-layout>
    </v-card>

    <v-layout justify-center>
      <v-dialog
        v-model="dialog"
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
              @click="salvar"
            >
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Validate from '../../shared/util/validate';
import File from '@/core/components/upload/File';
import Carregando from "../../shared/components/CardCarregando";

export default {
  components: {Carregando, File },
  data: () => ({
    loading : true,
    dialog: false,
    valid: false,
    conselho: {},
    nomeConselhoError: '',
    nomeRepresentante: '',
    nomeRepresentanteError: '',
    recursoHabilitacao: {
      ds_recurso: '',
      anexo: {},
      isLocked : false
    },
    rules: {
      required: value => !!value || 'Campo não preenchido',
      tamanhoMaximoCaracteres: value => (!!value && value.length <= 3000) || 'Máximo 3000 caracteres',
    },
  }),
  watch: {
    usuario(valor) {
      this.usuarioLogado = valor;
    },
    usuarioLogado(usuario) {
      if (usuario.co_conselho) {
        this.obterDadosConselho(usuario.co_conselho);
      }
    },
    conselhoGetter(valor) {
      if (Object.keys(valor).length > 0) {
        this.conselho = valor;
      }
    }
  },
  computed: {
    ...mapGetters({
      conselhoGetter: 'conselho/conselho',
      usuario: 'conta/usuario',
    }),
  },
  methods: {
    ...mapActions({
      obterDadosConselho: 'conselho/obterDadosConselho',
      obterRecursoHabilitacao: 'conselho/obterRecursoHabilitacao',
      enviarDadosRecursoHabilitacaoConselho: 'conselho/enviarDadosRecursoHabilitacaoConselho',
      definirMensagemSucesso: 'app/setMensagemSucesso',
      definirMensagemErro: 'app/setMensagemErro',
      downloadArquivo: 'shared/downloadArquivo',
    }),
    salvar() {
      this.loading = true;
        console.log(this.recursoHabilitacao);
        let dadosSubmit = {
            dsRecurso : this.recursoHabilitacao.ds_recurso
        };

        if(!!Object.keys(this.recursoHabilitacao.anexo).length) {
            dadosSubmit.anexo = this.recursoHabilitacao.anexo.file;
        }

        this.enviarDadosRecursoHabilitacaoConselho(dadosSubmit)
        .then((response) => {
          this.definirMensagemSucesso(response.data.message);
          this.$router.push('/');
        }).finally(() => {
          this.loading = false;
          this.fecharDialogo();
        });
    },
    abrirDialogo() {
      if (!this.$refs.form_recurso_habilitacao.validate()) {
        return false;
      }
      this.dialog = true;
      return true;
    },
    fecharDialogo() {
      this.dialog = false;
    },
  },
  mounted() {
    const self = this;
    self.loading = true;
    self.obterDadosConselho(this.usuario.co_conselho).then(dadosConselho => {
        console.log('Dados conselho', dadosConselho);
        if(Object.keys(dadosConselho.recursoHabilitacao).length > 0) {
            let recurso = dadosConselho.recursoHabilitacao;
            this.recursoHabilitacao.ds_recurso = recurso.ds_recurso;
            if (Object.keys(this.recursoHabilitacao.anexo) > 0) {
              this.recursoHabilitacao.anexo = recurso.anexo;

            }
            this.recursoHabilitacao.isLocked = true;
        }
    }).finally(() => {
      self.loading = false;
    });
  },
};
</script>
