<template>
  <v-container>
    <v-card class="elevation-1 pa-4 login-card">
      <v-card-title>
        <div class="layout column align-center">
          <h2 class="flex my-2 primary--text">
            {{ $route.meta.title }}
          </h2>
        </div>
      </v-card-title>
      <v-card-text>
        <lista-inscritos :sou-administrador="souAdministrador"></lista-inscritos>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ListaInscritos from './ListaInscritos';

export default {
  components: { ListaInscritos },
  name: 'ListaParcial',
  data: () => ({
    souAdministrador: false,
    loading: false,
    step: 1,
    pesquisar: '',
    tp_inscricao: null,
    pagination_organizacao: {
      page: 1,
      rowsPerPage: 10,
      sortBy: 'no_organizacao',
      descending: false,
    },
    pagination_conselho: {
      page: 1,
      rowsPerPage: 10,
      sortBy: 'no_orgao_gestor',
      descending: false,
    },
    totalItems: 0,
    headers: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'CNPJ',
        value: 'nu_cnpj_mascarado',
      },
      {
        text: 'Nome Conselho',
        value: 'no_orgao_gestor',
      },
      {
        text: 'UF',
        value: 'endereco.municipio.uf.no_uf',
      },
      {
        text: 'Região',
        value: 'endereco.municipio.uf.regiao.no_regiao',
      },
    ],
    headers_organizacao: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'CNPJ',
        value: 'nu_cnpj_mascarado',
      },
      {
        text: 'Nome da Organização ou Entidade',
        value: 'no_organizacao',
      },
      {
        text: 'Segmento',
        value: 'segmento.ds_detalhamento',
      },
      {
        text: 'Pontuação',
        value: 'pontuacao',
      },
    ],
  }),
  computed: {
    ...mapGetters({
      conselhosGetter: 'conselho/conselhos',
      organizacoesGetter: 'organizacao/organizacoes',
      perfil: 'conta/perfil',
    }),
  },
  methods: {
    ...mapActions({
      obterConselhos: 'conselho/obterConselhos',
      obterOrganizacoes: 'organizacao/obterOrganizacoes',
    }),
  },
  mounted() {
    const self = this;
    self.loading = true;
    self.obterConselhos().finally(() => {
      self.loading = false;
    });
    self.obterOrganizacoes().finally(() => {
      self.loading = false;
    });
    this.souAdministrador = !!(this.perfil.no_perfil === 'administrador');
  },
};
</script>
