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
                <span class="font-weight-bold">Nome do órgão gestor do conselho:</span> {{ conselho.no_orgao_gestor }}
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
                  Ilmo Sr. Secretário da Diversidade Cultural, <br><br>
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
                  v-model="habilitacaoRecurso.ds_recurso"
                  :readonly="habilitacaoRecurso.isLocked"
                  :disabled="habilitacaoRecurso.isLocked"
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
          </v-card>

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
                  Caso seja necessário o envio de documentos, encaminhar para o e-mail <span class="font-weight-bold">votacultura@cidadania.gov.br</span> informando no assunto: Recurso de habilitação e o nome do conselho.
                </div>
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
            :readonly="habilitacaoRecurso.isLocked"
            :disabled="habilitacaoRecurso.isLocked || !valid"
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
import Carregando from '../../shared/components/CardCarregando';

export default {
  components: { Carregando },
  data: () => ({
    loading: true,
    dialog: false,
    valid: false,
    conselho: {},
    nomeConselhoError: '',
    nomeRepresentante: '',
    nomeRepresentanteError: '',
    habilitacaoRecurso: {
      ds_recurso: '',
      isLocked: false,
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
      obterHabilitacaoRecurso: 'conselho/obterHabilitacaoRecurso',
      enviarDadosRecursoConselhoHabilitacao: 'conselho/enviarDadosRecursoConselhoHabilitacao',
      definirMensagemSucesso: 'app/setMensagemSucesso',
      definirMensagemErro: 'app/setMensagemErro',
    }),
    salvar() {
      this.loading = true;
      const dadosSubmit = {
        dsRecurso: this.habilitacaoRecurso.ds_recurso,
      };

      this.enviarDadosRecursoConselhoHabilitacao(dadosSubmit)
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

  beforeUpdate(){
    this.definirMensagemErro('O prazo de envio do recurso da habilitação expirou');
    this.$router.push('/');
  },
  mounted() {
    const self = this;
    self.loading = true;
    self.obterDadosConselho(this.usuario.co_conselho).then((dadosConselho) => {
      if (dadosConselho.habilitacaoRecurso) {
        const recurso = dadosConselho.habilitacaoRecurso;
        this.habilitacaoRecurso.ds_recurso = recurso.ds_recurso;
        this.habilitacaoRecurso.isLocked = true;
      }
    }).finally(() => {
      self.loading = false;
    });
  },
};
</script>
