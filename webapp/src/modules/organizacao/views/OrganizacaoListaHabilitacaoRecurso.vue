<template>
  <v-container>
    <v-card-title>
      <div class="layout column align-center">
        <h2 class="flex my-2 primary--text">{{ $route.meta.title }}</h2>
      </div>
    </v-card-title>

    <v-card>
      <v-tabs color="white" centered icons-and-text>
        <v-tab href="#organizacao">
          Organização ou Entidade
          <v-icon>color_lens</v-icon>
        </v-tab>
      </v-tabs>
      <v-card-title>
        <v-spacer />
        <v-text-field
          v-model="pesquisar"
          append-icon="search"
          label="Pesquisar"
          single-line
          hide-details
        />
        <v-spacer />
      </v-card-title>
      <v-tabs-items>
        <v-tab-item value="organizacao">
          <v-data-table
            :headers="headers"
            :items="organizacoesGetter"
            :pagination.sync="pagination_organizacao"
            :total-items="totalItems"
            :loading="loading"
            :search="pesquisar"
            item-key="co_usuario"
            class="elevation-1"
          >
            <template slot="items" slot-scope="props">
              <td>{{ props.item.cnpj_formatado }}</td>
              <td>{{ props.item.no_organizacao }}</td>
              <td>
                <v-chip dark color="primary">{{ props.item.segmento.ds_detalhamento }}</v-chip>
              </td>
              <td class="text-md-center">
                <v-chip v-if="!!props.item.organizacaoHabilitacao">
                  {{
                  (((props.item || {}).organizacaoHabilitacao || {}).nu_nova_pontuacao) >= 0 ?
                  props.item.organizacaoHabilitacao.nu_nova_pontuacao :
                  props.item.pontuacao
                  }}
                </v-chip>
                <v-chip v-else>-</v-chip>
              </td>
              <td class="text-md-center">
                <v-chip>
                  {{ parseInt(((props.item || {}).habilitacaoRecurso || {}).nu_pontuacao) >= 0 ?
                  props.item.habilitacaoRecurso.nu_pontuacao :
                  ' - '
                  }}
                </v-chip>
              </td>
              <td class="text-md-center">
                <v-chip dark color="primary">
                  <span v-if="!!props.item.habilitacaoRecurso && !!props.item.habilitacaoRecurso.st_parecer">
                      {{itemsResultadoHabilitacao[props.item.habilitacaoRecurso.st_parecer]}}
                  </span>
                  <span v-else>-</span>
                </v-chip>
              </td>
              <td>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      depressed
                      outline
                      icon
                      fab
                      dark
                      color="primary"
                      small
                      v-on="on"
                      @click="editarItemModal(props.item);"
                    >
                      <v-icon
                        title="Revisar"
                        v-if="!((props.item.habilitacaoRecurso || {})).st_avaliacao_final"
                      >gavel</v-icon>
                      <v-icon v-else>remove_red_eye</v-icon>
                    </v-btn>
                  </template>
                  <span
                    v-if="((props.item.habilitacaoRecurso || {})).st_parecer && !((props.item.habilitacaoRecurso || {})).st_avaliacao_final"
                  >Avaliar</span>
                  <span v-else>Visualizar</span>
                </v-tooltip>
              </td>
            </template>
          </v-data-table>

          <v-dialog v-model="mostrarModalEdicao" fullscreen hide-overlay transition="dialog-bottom-transition">
            <v-card>
              <v-toolbar dark color="primary">
                <v-btn icon dark href="/organizacao/lista-recurso-habilitacao">
                  <v-icon>close</v-icon>
                </v-btn>
                <v-toolbar-title>Avaliar recurso</v-toolbar-title>
                <v-spacer />
              </v-toolbar>
              <v-card-text>
                <organizacao-lista-habilitacao-recurso-dialog
                  :organizacao="itemEditado"
                />
              </v-card-text>
            </v-card>
          </v-dialog>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import OrganizacaoListaHabilitacaoRecursoDialog from "./OrganizacaoListaHabilitacaoRecursoDialog";
// import OrganizacaoDetalhesInscricaoVisualizacao from "./OrganizacaoDetalhesInscricaoVisualizacao";

export default {
  name: "OrganizacaoListaHabilitacaoRecurso",
  components: {
    OrganizacaoListaHabilitacaoRecursoDialog
  },
  data: () => ({
    itemsResultadoHabilitacao: [
      'Inabilitada',
      'Habilitada e desclassificada',
      'Habilitada e classificada',
    ],
    loading: true,
    pesquisar: "",
    itemEditado: {},
    totalItems: 0,
    mostrarModalEdicao: false,
    pagination_organizacao: {
      page: 1,
      rowsPerPage: 10,
      sortBy: "no_organizacao",
      descending: false
    },
    headers: [
      {
        text: "CNPJ",
        value: "cnpj_formatado"
      },
      {
        text: "Nome ",
        value: "no_organizacao"
      },
      {
        text: "Segmento",
        value: "segmento.ds_detalhamento"
      },
      {
        text: "Pontuação após análise",
        value: "organizacaoHabilitacao.nu_nova_pontuacao",
        align: "center"
      },
      {
        text: "Pontuação final",
        value: "habilitacaoRecurso.nu_pontuacao",
        align: "center"
      },
      {
        text: "Resultado final",
        value: "habilitacaoRecurso.ds_recurso",
        align: "center"
      },
    ],
  }),
  watch: {
  },
  computed: {
    ...mapGetters({
      organizacoesGetter: "organizacao/organizacoesRecurso",
      perfil: "conta/perfil"
    })
  },
  methods: {
    ...mapActions({
      obterOrganizacoesRecurso: "organizacao/obterOrganizacoesRecurso"
    }),
    editarItemModal(item) {
      this.itemEditado = item;
      this.mostrarModalEdicao = true;
    }
  },
  mounted() {
    const self = this;
    self.loading = true;
    this.mostrarModalEdicao = false;
    self.obterOrganizacoesRecurso().finally(() => {
      self.loading = false;
    });
    this.headers.push({
      text: "Ações",
      sortable: false
    });
  },
  beforeDestroy() {
    this.mostrarModalEdicao = false;
  }
};
</script>
