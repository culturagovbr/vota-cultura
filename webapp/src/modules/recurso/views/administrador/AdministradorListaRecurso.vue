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
                  <td>{{ props.item.nu_cpf }}</td>
                  <td>{{ props.item.ds_email }}</td>
                  <td>{{ props.item.dh_cadastro_formatado }}</td>
                  <td>
                    <v-btn
                      depressed
                      outline
                      icon
                      fab
                      dark
                      color="primary"
                      small
                      @click=""
                    >
                      <v-icon>zoom_in</v-icon>
                    </v-btn>
                  </td>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'ListaRecurso',
  data() {
    return {
      loading: true,
      pesquisar: '',
      pagination: {
        page: 1,
        rowsPerPage: 10,
      },
      totalItems: 0,
      headers: [
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
  },
  watch: {
    recursosGetter(va){
      console.log(va);
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
