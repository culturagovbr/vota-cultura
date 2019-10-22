<template>
  <v-container fluid subheading grey--text mt-2 text-xs-left font-weight-bold>
    <v-layout row wrap>
      <v-flex xs6>Nome da organização/entidade cultural: {{ organizacao.no_organizacao }}</v-flex>
      <v-flex xs6>CNPJ: {{ organizacao.cnpj_formatado }}</v-flex>
    </v-layout>

    <v-layout row wrap mt-2>
      <v-flex xs6>Pontuação inicial: {{ organizacao.pontuacao }}</v-flex>
      <v-flex xs6>Segmento cultural: {{ ((organizacao || {}).segmento || {}).ds_detalhamento }}.</v-flex>
    </v-layout>

    <v-layout row wrap mt-2>
      <v-flex
        xs6
      >Pontuação após análise: {{ ((organizacao || {}).organizacaoHabilitacao || {}).nu_nova_pontuacao }}</v-flex>
      <v-flex xs6>
        Resultado parcial da habilitação:
        <span
          :class="((organizacao || {}).organizacaoHabilitacao || {}).st_avaliacao === 0 ? 'red--text' : 'green--text'"
        >{{ ((organizacao || {}).organizacaoHabilitacao || {}).situacao_avaliacao }}</span>
      </v-flex>
    </v-layout>

    <v-layout row wrap mt-2>
      <v-flex xs6>Pontuação final: {{ ((organizacao || {}).habilitacaoRecurso || {}).nu_pontuacao }}</v-flex>
      <v-flex xs6>
        Resultado final da habilitação:
        <span
          :class="mapCodeResultadoAvaliacaoToString(parseInt(((organizacao || {}).habilitacaoRecurso || {}).st_parecer),10).color"
        >{{ mapCodeResultadoAvaliacaoToString(parseInt(((organizacao || {}).habilitacaoRecurso || {}).st_parecer),10).text}}</span>
      </v-flex>
    </v-layout>

    <v-container fluid subheading mt-2 text-xs-left>
      <v-layout row wrap>
        <v-flex>
          <v-card>
            <v-card-text>
              <div class="grey--text">
                Ilmo Sr. Secretário da Diversidade Cultural.
                <div class="mt-4 p4">
                  Com base no item 6 desta CHAMADA PÚBLICA PARA COMPOSIÇÃO DO CONSELHO NACIONAL DE POLÍTICA CULTURAL
                  <br />(CNPC) NO TRIÊNIO 2019/2022, venho interpor recurso em face do resultado, na etapa de habilitação, pelos motivos abaixo descritos:
                </div>
                <div class="mt-4">
                  <v-textarea
                    disabled
                    :placeholder="((organizacao || {}).habilitacaoRecurso || {}).ds_recurso"
                    rows="13"
                    row-height="28"
                    box
                    auto-grow
                  />
                </div>
              </div>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>

    <v-form
      ref="form_recurso_habilitacao_avaliacao"
      v-model="valid"
      lazy-validation
      enctype="multipart/form-data"
    >
      <v-container fluid subheading mt-2 text-xs-left>
        <v-layout row wrap>
          <v-flex>
            <v-card>
              <v-card-text>
                <div class="grey--text">
                  Avaliação
                  <div mt-2 md12>
                    <v-select
                      v-model="formulario.resultadoHabilitacao.value"
                      :items="itemsResultadoHabilitacao"
                      label="*Resultado final da habilitação"
                      append-icon="place"
                      required
                      box
                      :rules="[rules.required]"
                      :error="formulario.resultadoHabilitacao.error"
                    />
                  </div>

                  <div class="mt-2">
                    <v-textarea
                      v-model="formulario.dsParecer.value"
                      placeholder="*Parecer"
                      rows="13"
                      row-height="28"
                      :counter="15000"
                      box
                      auto-grow
                      :rules="[rules.required, rules.tamanhoMaximoCaracteres]"
                      :error="formulario.dsParecer.error"
                    />
                  </div>

                  <v-flex class="mt-2" sm2>
                    <v-text-field
                      v-model="formulario.pontuacaoFinal.value"
                      type="number"
                      min="0"
                      max="99"
                      step="1"
                      mask="##"
                      :error="formulario.pontuacaoFinal.error"
                      onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
                      label="Pontuação final"
                      :rules="[rules.required]"
                    />
                  </v-flex>
                </div>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
      <v-container fluid subheading mt-2 text-xs-left>
        <v-layout>
          <v-flex>
            <v-card>
              <v-card-text class="grey--text">
                Anexo
                <div mt-2 class="text-xs-center">
                  <span mt-2>Caso seja necessário, anexe o documento no formato PDF</span>
                  <v-flex mt-2>
                    <file v-model="formulario.anexo" :accepted-file-types="['application/pdf']" />
                  </v-flex>
                </div>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>

        <v-layout mt-4 align-center justify-center row fill-height>
          <v-btn href="/">Cancelar</v-btn>
          <v-btn color="primary" :loading="loading" @click="validarFormulario">Avaliar</v-btn>
        </v-layout>
      </v-container>
      <v-layout justify-center>
      <v-dialog
        v-model="dialogConfirmarAvaliacao"
        max-width="360"
      >
        <v-card>
          <v-card-title class="headline">
            Deseja realmente enviar?
          </v-card-title>
          <v-card-actions>
            <v-spacer />

            <v-btn
              color="red darken-1"
              text
              flat
              @click="handleDialogConcluirAvaliacao"
            >
              Não
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              flat
              @click="enviar"
            >
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
    </v-form>
  </v-container>

</template>

<script>
import File from "@/core/components/upload/File";
import Validate from '../../../shared/util/validate';
import { mapGetters, mapActions } from "vuex";

export default {
    data: () => ({
    valid: false,
    loading: false,
    dialogConfirmarAvaliacao : false,
    formulario: {
      dsParecer: { value: "", error: false },
      resultadoHabilitacao: { value: "", error: false },
      pontuacaoFinal: { value: "", error: false },
      anexo: {}
    },
    itemsResultadoHabilitacao: [
      { value: "", text: "" },
      { value: '0', text: "Inabilitada" },
      { value: 1, text: "Habilitada e desclassificada" },
      { value: 2, text: "Habilitada e classificada" }
    ],
    rules: {
      required: v => !!v || "Campo não preenchido",
      tamanhoMaximoCaracteres: value =>
        (!!value && value.length <= 15000) || "Máximo 15000 caracteres"
    }
  }),
  props: {
    organizacao: {
      type: Object,
      default: () => {}
    }
  },
  components: {
    File
  },
  methods: {
    ...mapActions({
      obterOrganizacoesRecurso: "organizacao/obterOrganizacoesRecurso",
      enviarDadosOrganizacaoHabilitacaoRecurso:
        "organizacao/alterarDadosOrganizacaoHabilitacaoRecurso",
      definirMensagemSucesso: "app/setMensagemSucesso",
      definirMensagemErro: "app/setMensagemErro"
    }),
    handleDialogConcluirAvaliacao() {
      this.dialogConfirmarAvaliacao = !this.dialogConfirmarAvaliacao;
    },

    validarFormulario() {

      if (!this.$refs.form_recurso_habilitacao_avaliacao.validate()) {
        return false;
      }

        this.handleDialogConcluirAvaliacao();
    },

    enviar() {
      let dadosSubmit = {
        ds_parecer : this.formulario.dsParecer.value,
        st_parecer : this.formulario.resultadoHabilitacao.value,
        nu_pontuacao : this.formulario.pontuacaoFinal.value,
        co_organizacao_habilitacao_recurso : this.organizacao.habilitacaoRecurso.co_organizacao_habilitacao_recurso,
        method : 'PATCH'
      };

      if (this.formulario.anexo) {
          dadosSubmit.anexo = this.formulario.anexo.file;
      }

      this.enviarDadosOrganizacaoHabilitacaoRecurso(dadosSubmit)
        .then((response) => {
          this.definirMensagemSucesso(response.data.message);
          this.$router.push('/');
        }).finally(() => {
          this.loading = false;
          this.handleDialogConcluirAvaliacao();
        });
    },

    mapCodeResultadoAvaliacaoToString(stParecer) {
      let strParecer = {};
      switch (stParecer) {
        case 0:
          strParecer = {
            text: "Inabilitada",
            color: "red--text"
          };
          break;
        case 1:
          strParecer = {
            text: "Habilitada e desclassificada",
            color: "orange--text"
          };
          break;
        case 2:
          strParecer = {
            text: "Habilitada e classificada",
            color: "green--text"
          };
          break;
        default:
          strParecer = { text: " - ", color: "" };
          break;
      }

      return strParecer;
    }
  },
};
</script>
