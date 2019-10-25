<template>
  <v-container>
    <v-card-title v-if="exibirTitulo">
      <div class="layout column align-center">
        <h2 class="flex my-2 primary--text">
          {{ $route.meta.title }}
        </h2>
      </div>
    </v-card-title>
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
    <v-card-text class="pa-0">
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
        <template
          slot="items"
          slot-scope="props"
        >
          <td />
          <td>{{ props.item.cnpj_formatado }}</td>
          <td>{{ props.item.no_organizacao }}</td>
          <td>
            {{ props.item.segmento.ds_detalhamento }}
          </td>
          <td class="text-md-center">
            <v-chip>
              {{ props.item.pontuacao }}
            </v-chip>
          </td>
          <td class="text-md-center">
            <v-chip v-if="!!(props.item || {}).organizacaoHabilitacao">
              {{ (parseInt((props.item || {}).organizacaoHabilitacao.nu_nova_pontuacao) >= 0) ? ((props.item || {}).organizacaoHabilitacao || {}).nu_nova_pontuacao : props.item.pontuacao }}
            </v-chip>
            <v-chip v-else>
              -
            </v-chip>
          </td>
          <td class="text-md-center">
            <v-chip>
              {{ obterPontuacaoFinal(props.item) }}
            </v-chip>
          </td>
          <td class="text-md-center">
            <!-- <span
              v-if="!!(props.item || {}).organizacaoHabilitacao && !!((props.item || {}).organizacaoHabilitacao || {}).situacao_avaliacao"
              v-html="props.item.organizacaoHabilitacao.situacao_avaliacao"
            /> -->
            <span>{{ obterSituacaoAvaliacao(props.item) }}</span>
          </td>
          <td v-if="exibirColunaAcoes">
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
                  <v-icon v-if="(props.item || {}).organizacaoHabilitacao === null || ((!!props.item.organizacaoHabilitacao || {}).co_organizacao_habilitacao && perfil.no_perfil === 'administrador' && ((props.item || {}).organizacaoHabilitacao || {}).st_revisao_final !== true)">
                    gavel
                  </v-icon>
                  <v-icon v-else>
                    remove_red_eye
                  </v-icon>
                </v-btn>
              </template>
              <span v-if="(props.item || {}).organizacaoHabilitacao === null">Avaliar</span>
              <span v-else>Visualizar</span>
            </v-tooltip>
          </td>
        </template>
      </v-data-table>
      <organizacao-lista-habilitacao-dialog
        v-model="mostrarModalEdicao"
        :organizacao="itemEditado"
      />
    </v-card-text>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import OrganizacaoListaHabilitacaoDialog from './OrganizacaoListaHabilitacaoDialog';

export default {
  name: 'OrganizacaoListaHabilitacao',
  components: {
    OrganizacaoListaHabilitacaoDialog,
  },
  props: {
    exibirTitulo: {
      type: Boolean,
      default: true,
    },
    exibirColunaAcoes: {
      type: Boolean,
      default: true,
    },
  },
  data: () => ({
    loading: true,
    pesquisar: '',
    itemEditado: {},
    totalItems: 0,
    mostrarModalEdicao: false,
    pagination_organizacao: {
      page: 1,
      rowsPerPage: 10,
      sortBy: 'no_organizacao',
      descending: false,
    },
    headers: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'CNPJ',
        value: 'cnpj_formatado',
      },
      {
        text: 'Nome ',
        value: 'no_organizacao',
      },
      {
        text: 'Segmento',
        value: 'segmento.ds_detalhamento',
      },
      {
        text: 'Pontuação inicial',
        value: 'pontuacao',
        align: 'center',
      },
      {
        text: 'Pontuação após análise',
        value: 'pontuacao',
        align: 'center',
      },
      {
        text: 'Pontuação final',
        value: 'habilitacaoRecurso.nu_pontuacao',
        align: 'center',
      },
      {
        text: 'Resultado final',
        value: 'organizacaoHabilitacao.situacao_avaliacao',
        align: 'center',
      },
    ],
  }),
  watch: {
    mostrarModalEdicao(valor) {
      if (!valor) {
        this.itemEditado = Object.assign({});
      }
    },
  },
  computed: {
    ...mapGetters({
      organizacoesGetter: 'organizacao/organizacoes',
      perfil: 'conta/perfil',
    }),
  },
  methods: {
    ...mapActions({
      obterOrganizacoesHabilitacao: 'organizacao/obterOrganizacoesHabilitacao',
    }),
    obterSituacaoAvaliacao(item) {
        if(Object.keys((item.habilitacaoRecurso || {})).length > 0) {
          return this.mapCodeResultadoAvaliacaoToString(item.habilitacaoRecurso.st_parecer).text;
        }

        return this.mapCodeResultadoAvaliacaoToString(item.organizacaoHabilitacao.st_avaliacao).text;
    },
    mapCodeResultadoAvaliacaoToString(stParecer) {
      let parecer = {};
      switch (parseInt(stParecer)) {
        case 0:
          parecer = {
            text: 'Inabilitada',
            color: "red--text"
          };
          break;
        case 1:
          parecer = {
            text: 'Habilitada e desclassificada',
            color: 'orange--text'
          };
          break;
        case 2:
          parecer = {
            text: 'Habilitada e classificada',
            color: 'green--text'
          };
          break;
          break;
        case 3:
          parecer = {
            text: 'Habilitada',
            color: 'green--text'
          };
          break;
        default:
          parecer = { text: ' - ', color: '' };
          break;
      }

      return parecer;
    },
    obterPontuacaoFinal(item) {
      if ((item.habilitacaoRecurso || {}).nu_pontuacao) {
          return parseInt(item.habilitacaoRecurso.nu_pontuacao, 10);
      }

      let novaPontuacao = parseInt(parseInt((item.organizacaoHabilitacao || {}).nu_nova_pontuacao) >= 0 ?
        (item.organizacaoHabilitacao || {}).nu_nova_pontuacao :
        item.pontuacao, 10);

        return novaPontuacao === 0 ? ' - ' : novaPontuacao;
    },
    editarItemModal(item) {
      this.itemEditado = item;
      this.mostrarModalEdicao = true;
    },
  },
  mounted() {
    const self = this;
    self.loading = true;
    self.obterOrganizacoesHabilitacao().finally(() => {
      self.loading = false;
    });
    if(self.exibirColunaAcoes) {
      this.headers.push({
        text: 'Ações',
        sortable: false,
      });
    }
  },
};
</script>
