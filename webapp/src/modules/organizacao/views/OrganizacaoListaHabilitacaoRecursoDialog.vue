<template>
  <v-form ref="form_recurso_habilitacao" v-model="valid">
    <v-container fluid>
      <v-card>
        <v-card-text>
          <v-tabs v-model="modelTabs" centered :color="'grey darken-3'" dark slider-color="yellow">
            <v-tab href="#tab-1">Recurso</v-tab>
            <v-tab href="#tab-2">Dados da habilitação</v-tab>
            <v-tab href="#tab-3">Dados da organização</v-tab>
          </v-tabs>
          <v-tabs-items v-model="modelTabs" class="white elevation-1">
            <v-tab-item value="tab-1">
              <organizacao-lista-dados-recurso :organizacao="organizacao" />
            </v-tab-item>

            <v-tab-item value="tab-2">
              <organizacao-lista-dados-habilitacao :formulario="organizacao" />
            </v-tab-item>

            <v-tab-item value="tab-3">
              <v-container>
                <organizacao-detalhes-inscricao-visualizacao />
              </v-container>
            </v-tab-item>
          </v-tabs-items>
        </v-card-text>
      </v-card>
    </v-container>
  </v-form>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import OrganizacaoListaDadosRecurso from "./components/OrganizacaoListaDadosRecurso";
import OrganizacaoListaDadosHabilitacao from "./components/OrganizacaoListaDadosHabilitacao";
import OrganizacaoDetalhesInscricaoVisualizacao from "./OrganizacaoDetalhesInscricaoVisualizacao";
// import OrganizacaoDetalhesInscricaoVisualizacao from './OrganizacaoDetalhesInscricaoVisualizacao';

export default {
  name: "OrganizacaoListaHabilitacaoDialog",
  components: {
    OrganizacaoListaDadosRecurso,
    OrganizacaoListaDadosHabilitacao,
    OrganizacaoDetalhesInscricaoVisualizacao
  },
  props: {
    value: {
      type: Boolean,
      default: false
    },
    organizacao: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      valid: true,
      modelTabs: "tab-1",
      formularioInicial: {
        recursoHabilitacao: {
          ds_recurso: "",
          ds_parecer: "",
          st_parecer: null,
          st_avaliacao_final: 0,
          nu_pontuacao: null
        }
      },
      formulario: Object.assign({}, this.formularioInicial)
    };
  },
  computed: {
    ...mapGetters({
      organizacaoGetter: "organizacao/organizacao",
      criteriosGetter: "organizacao/criterios"
    })
  },
  watch: {
    value(valor) {
      if (!valor) {
        this.formulario.recursoHabilitacao = Object.assign(
          {},
          this.formularioInicial.recursoHabilitacao
        );
        this.$refs.form_recurso_habilitacao.reset();
      }
    },
    organizacao(valor) {
      this.obterDadosOrganizacao(valor.co_organizacao);
    }
  },
  methods: {
    ...mapActions({
      obterDadosOrganizacao: "organizacao/obterDadosOrganizacao"
    })
  }
};
</script>
