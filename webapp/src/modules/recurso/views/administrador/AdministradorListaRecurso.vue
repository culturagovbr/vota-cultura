<template>
  <div class="list-table">
    <v-container
      grid-list-xl
      fluid
    >
      <v-layout
        row
        wrap
      >
        <v-flex lg12>
          <v-card>
            <v-card-title>
              <v-spacer />
              <v-text-field
                v-model="pesquisar"
                append-icon="search"
                label="Pesquisar"
                single-line
                hide-details
              />
            </v-card-title>
            <v-card-text class="pa-0">
              <v-data-table
                :headers="headers"
                :items="recursosGetter"
                :pagination.sync="pagination"
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
                  <td> <v-chip color="primary" text-color="white">{{ props.item.fase.ds_detalhamento }}</v-chip></td>
                  <td>{{ props.item.cpf_formatado }}</td>
                  <td>{{ props.item.ds_email }}</td>
                  <td>{{ props.item.dh_cadastro_formatado }}</td>
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
                          @click="editarItemModal(props.item)"
                        >
                          <v-icon v-if="props.item.st_parecer === null">gavel</v-icon>
                          <v-icon v-else>remove_red_eye</v-icon>
                        </v-btn>
                      </template>
                      <span v-if="props.item.st_parecer === null">Avaliar</span>
                      <span v-else>Visualizar</span>
                    </v-tooltip>
                  </td>
                </template>
              </v-data-table>
              <administrador-lista-recursos-dialog
                v-model="mostrarModalEdicao"
                :usuario="itemEditado"
              />
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import AdministradorListaRecursosDialog from './AdministradorListaRecursosDialog';

export default {
  name: 'ListaRecurso',
  components: {
    AdministradorListaRecursosDialog,
  },
  data() {
    return {
      loading: true,
      pesquisar: '',
      mostrarModalEdicao: false,
      itemEditado: {},
      pagination: {
        page: 1,
        rowsPerPage: 10,
      },
      totalItems: 0,
      headers: [
        {
          text: 'Tipo recurso',
          value: 'fase.ds_detalhamento',
        },
        {
          text: 'CPF',
          value: 'nu_cpf_formatado',
        },
        {
          text: 'Email',
          value: 'ds_email',
        },
        {
          text: 'Data solicitação',
          value: 'perfil.ds_perfil',
        },
        {
          text: 'Ações',
          sortable: false,
        },
      ],
    };
  },
  computed: {
    ...mapGetters({
      recursosGetter: 'recurso/recursos',
    }),
  },
  methods: {
    ...mapActions({
      obterRecursos: 'recurso/obterRecursos',
    }),
    editarItemModal(item) {
      this.itemEditado = item;
      this.mostrarModalEdicao = true;
    },
  },
  mounted() {
    const self = this;
    self.loading = true;
    self.obterRecursos().finally(() => {
      self.loading = false;
    });
  },
};
</script>
