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
            <v-card-text class="pa-0">
              <v-data-table
                :headers="headers"
                :items="usuariosGetter"
                :pagination.sync="pagination"
                :total-items="totalItems"
                :loading="loading"
                item-key="co_usuario"
                class="elevation-1"
              >
                <template
                  slot="items"
                  slot-scope="props"
                >
                  <td>{{ props.item.nu_cpf }}</td>
                  <td>{{ props.item.no_nome }}</td>
                  <td>
                    <v-chip>
                      {{ props.item.perfil.ds_perfil }}
                    </v-chip>
                  </td>
                  <td>
                    <v-chip
                      :color="props.item.st_ativo ? 'green' : 'red'"
                      text-color="white"
                    >
                      {{ props.item.st_ativo ? 'Ativo' : 'Inativo' }}
                    </v-chip>
                  </td>
                  <td>
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
                      <v-icon>edit</v-icon>
                    </v-btn>
                    <v-btn
                      depressed
                      outline
                      icon
                      fab
                      dark
                      color="secondary"
                      small
                      @click="atualizarStatus(props.item)"
                    >
                      <v-icon>{{ props.item.st_ativo ? 'lock' : 'lock_open' }}</v-icon>
                    </v-btn>
                    <v-btn
                      depressed
                      outline
                      icon
                      fab
                      dark
                      color="pink"
                      small
                      @click="excluirItem(props.item)"
                    >
                      <v-icon>delete</v-icon>
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
  data() {
    return {
      loading: true,
      pagination: {
        page: 1,
        rowsPerPage: 10,
      },
      totalItems: 0,
      filtros: {},
      itemEditado: {},
      headers: [
        {
          text: 'CPF',
          value: 'no_cpf',
        },
        {
          text: 'Nome',
          value: 'no_nome',
        },
        {
          text: 'Perfil',
          value: 'perfis',
          sortable: false,
        },
        {
          text: 'Status',
          value: 'st_ativo',
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
      usuariosGetter: 'conta/usuarios',
    }),
  },
  methods: {
    ...mapActions({
      buscarUsuariosPerfis: 'conta/buscarUsuariosPerfis',
      // atualizarItemAction: 'conta/atualizarUsuario',
      // excluirItemAction: 'conta/excluirUsuario',
      // mensagemSucesso: 'app/setMensagemSucesso',
    }),
    editarItemModal(item) {
      this.itemEditado = item;
      this.mostrarModalEdicao = true;
    },
    excluirItem() {
      // return this.excluirItemAction(item.co_usuario);
    },
  },
  mounted() {
    const self = this;
    self.loading = true;
    self.buscarUsuariosPerfis().finally(() => {
      self.loading = false;
    });
  },
};
</script>
