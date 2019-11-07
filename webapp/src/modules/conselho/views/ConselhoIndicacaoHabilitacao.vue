<template>
  <v-container>
    <v-card-title>
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
    </v-card-title>011.505.161-94
    <v-card-text class="pa-0">
      <v-data-table
        :headers="headers"
        :items="listarIndicacaoConselhoGetter"
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
          <td>{{ props.item.cpf_indicado_formatado }}</td>
          <td>{{ props.item.no_indicado }}</td>
          <td>
            <v-chip>
              {{ props.item.endereco.municipio.uf.no_uf }}
            </v-chip>
          </td>
          <td class="text-md-center">
            {{ props.item.conselho.no_conselho }}
          </td>
          <td class="text-md-center">
            <v-chip
              v-if="(props.item.avaliacaoHabilitacao || {}).st_avaliacao != null"
              dark
              color="primary"
            >
              {{props.item.avaliacaoHabilitacao.st_avaliacao ? 'Habilitado': 'Inabilitado' }}
            </v-chip>
            <v-chip
              v-else
              dark
              color="primary"
            >
              -
            </v-chip>
          </td>
          <td class="text-md-center">
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
                  @click="editarItemModal(props.item)"
                >
                  <v-icon v-if="(props.item.avaliacaoHabilitacao || {}).st_revisao_final">remove_red_eye</v-icon>
                  <v-icon v-else>gavel</v-icon>
                </v-btn>
              </template>
              <span v-if="(props.item.avaliacaoHabilitacao || {}).st_revisao_final">remove_red_eye</span>
              <span v-else>gavel</span>
            </v-tooltip>
          </td>
        </template>
      </v-data-table>
    </v-card-text>
    <conselho-indicacao-habilitacao-dialog
      v-model="mostrarModalEdicao"
      :indicado="itemEditado"
    />
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ConselhoIndicacaoHabilitacaoDialog from './ConselhoIndicacaoHabilitacaoDialog';

export default {
  name: 'ConselhoIndicacao',
  components: {
    ConselhoIndicacaoHabilitacaoDialog,
  },
  data: () => ({
    dialogo: false,
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
        text: 'CPF',
        value: 'cpf_indicado_formatado',
      },
      {
        text: 'Nome ',
        value: 'no_indicado',
      },
      {
        text: 'Unidade da federação em que reside',
        value: 'endereco.municipio.uf.no_uf',
      },
      {
        text: 'Nome do conselho',
        value: 'conselho.no_conselho',
        align: 'center',
      },
      {
        text: 'Resultado da habilitação',
        value: 'avaliacaoHabilitacao.st_revisao_final',
        align: 'center',
      },
      {
        text: 'Ações',
        align: 'center',
        sortable: false,
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
      listarIndicacaoConselhoGetter: 'conselho/listarIndicacaoConselho',
      organizacoesGetter: 'organizacao/organizacoes',
      perfil: 'conta/perfil',
    }),
  },
  methods: {
    ...mapActions({
      obterListaIndicacaoConselho: 'conselho/obterListaIndicacaoConselho',
    }),
    editarItemModal(item) {
      this.itemEditado = Object.assign({}, item);
      this.mostrarModalEdicao = true;
    },
  },
  mounted() {
    this.loading = true;
    this.obterListaIndicacaoConselho().finally(() => {
      this.loading = false;
    });
  },
};
</script>
