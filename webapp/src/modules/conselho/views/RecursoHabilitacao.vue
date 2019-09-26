<template>
  <v-container>
    <v-card>
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

            <v-layout
              wrap
              align-center
              class="grey--text subheading text-lg-center"
            >
              <v-flex
                xs12
                sm12
                class="ma-2"
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
                    <file v-model="recursoHabilitacao.anexo" />
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
            :disabled="!valid"
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

export default {
  components: { File },
  data: () => ({
    dialog: false,
    valid: false,
    conselho: {},
    nomeConselhoError: '',
    nomeRepresentante: '',
    nomeRepresentanteError: '',
    recursoHabilitacao: {
      ds_recurso: '',
      anexo: {},
    },
    listaRecursos: [
      {
        co_fase: 4,
        tp_fase: 'recurso_inscricoes_conselho',
        ds_detalhamento: 'Conselho',
      },
      {
        co_fase: 5,
        tp_fase: 'recurso_inscricoes_organizacao',
        ds_detalhamento: 'Organização',
      },
    ],
    rules: {
      required: value => !!value || 'Campo não preenchido',
      cnpjInvalido: value => !!value || 'CNPJ não encontrado',
      cpfInvalido: value => !!value || 'CPF não encontrado',
      phoneMin: value => (value && value.length >= 9) || 'Mínimo de 9 caracteres',
      cnpjMin: value => (value && value.length === 14) || 'Mínimo de 14 caracteres',
      cpfMin: value => (value && value.length === 11) || 'Mínimo de 11 caracteres',
      email: (value) => {
        // eslint-disable-next-line
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(value) || 'E-mail invalido';
      },
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
    }),
    validarIrProximaEtapa(formRef) {
      if (this.$refs[formRef].validate()) {
        this.etapaFormulario = this.etapaFormulario + 1;
      }
    },
    salvar() {
      this.loading = true;
      this.recursoInscricao.no_razao_social = this.nomeConselho;
      this.recursoInscricao.no_representante = this.nomeRepresentante;

      this.enviarDadosRecursoInscricao(this.recursoInscricao)
        .then((response) => {
          this.definirMensagemSucesso(response.data.message);
          this.$router.push('/');
        }).finally(() => {
          this.loading = false;
          this.fecharDialogo();
        });
    },
    abrirDialogo() {
      if (!this.$refs.form_recurso.validate()) {
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
    self.obterDadosConselho(this.usuario.co_conselho).finally(() => {
      self.loading = false;
    });

    if (Object.keys(this.conselhoGetter).length > 0) {
      this.conselho = this.conselhoGetter;
    }
  },
};
</script>
