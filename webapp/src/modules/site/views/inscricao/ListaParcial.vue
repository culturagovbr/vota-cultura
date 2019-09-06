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
        <v-form
          ref="form"
          v-model="formularioValido"
          lazy-validation
        >
          <v-card>
            <v-tabs
              v-model="dadosPrimeiroAcesso.tp_inscricao"
              color="white"
              centered
              icons-and-text
            >
              <v-tabs-slider />

              <v-tab href="#conselho">
                Conselho
                <v-icon>group</v-icon>
              </v-tab>
              <v-tab href="#organizacao">
                Organização ou Entidade
                <v-icon>color_lens</v-icon>
              </v-tab>

            </v-tabs>

            <v-tabs-items v-model="dadosPrimeiroAcesso.tp_inscricao">
              <v-tab-item value="conselho">
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
                    <v-spacer />
                  </v-card-title>
                  <v-card-text class="pa-0">
                    <v-data-table
                      :headers="headers"
                      :items="usuariosGetter"
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
                        <td></td>
                        <td>{{ props.item.no_nome }}</td>
                        <td>
                          <v-chip>
                            {{ props.item.perfil.ds_perfil }}
                          </v-chip>
                        </td>
                      </template>
                    </v-data-table>
                    <administrador-lista-usuarios-dialog
                      v-model="mostrarModalEdicao"
                      :usuario="itemEditado"
                    />
                  </v-card-text>
                </v-card>
              </v-tab-item>
              <v-tab-item value="organizacao" />
            </v-tabs-items>
          </v-card>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'PrimeiroAcesso',
  data: () => ({
    loading: false,
    formularioValido: true,
    step: 1,
    dadosPrimeiroAcesso: {
      nu_cpf: '',
      nu_cnpj: '',
      tp_inscricao: null,
    },
    headers: [
      {
        text: '',
        value: 'no_conselho',
        sortable: false,
      },
      {
        text: 'Nome Conselho',
        value: 'no_conselho',
      },
      {
        text: 'Região',
        value: 'regiao',
      },
    ],
  }),
  computed: {
    ...mapGetters({
      usuariosGetter: 'conta/usuarios',
    }),
  },
  methods: {
    ...mapActions({
      buscarUsuariosPerfis: 'conta/buscarUsuariosPerfis',
    }),
    editarItemModal(item) {
      this.itemEditado = item;
      this.mostrarModalEdicao = true;
    },
  },
  watch: {
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
