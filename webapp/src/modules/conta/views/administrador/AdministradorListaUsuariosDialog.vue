<template>
  <v-dialog
    v-model="dialog"
    fullscreen
    hide-overlay
    transition="dialog-bottom-transition"
  >
    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-btn
          icon
          dark
          @click="dialog = false"
        >
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>Editar Perfil do Usuário</v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-card>
            <v-card-text>
              <v-form
                v-show="Object.keys(formulario).length > 0"
                ref="form"
                v-model="valid"
                lazy-validation
                autocomplete="off"
              >
                <v-container
                  grid-list-md
                  text-xs-center
                >
                  <v-layout
                    row
                    wrap
                  >
                    <v-flex
                      xs4
                      md4
                      sm12
                    >
                      <v-text-field
                        :value="formulario.no_cpf"
                        name="cpf"
                        label="CPF"
                        mask="###.###.###-##"
                        disabled
                        type="text"
                      />
                    </v-flex>
                    <v-flex
                      xs8
                      md8
                      sm12
                    >
                      <v-text-field
                        v-model="formulario.no_nome"
                        name="nome"
                        label="Nome completo"
                        validate-on-blur
                        type="text"
                        maxlength="100"
                        :rules="[rules.required]"
                      />
                    </v-flex>
                    <v-flex
                      xs4
                      md4
                      sm12
                    >
                      <s-data-picker
                        v-model="formulario.dt_nascimento"
                        :rules="[rules.required, rules.dataValida]"
                      />
                    </v-flex>
                    <v-flex
                      xs8
                      md8
                      sm12
                    >
                      <v-text-field
                        v-model="formulario.no_email"
                        name="no_email"
                        label="E-mail"
                        validate-on-blur
                        type="text"
                        maxlength="80"
                        :rules="[rules.required, rules.emailValido]"
                      />
                    </v-flex>

                    <v-flex
                      xs12
                      sm12
                    >
                      <v-select
                        v-model="formulario.perfis"
                        :items="perfis"
                        item-text="no_perfil"
                        item-value="co_perfil"
                        :rules="[rules.required, rules.minimoDePerfis]"
                        label="Selecione os perfis"
                        multiple
                        chips
                        return-object
                      >
                        <template v-slot:prepend-item>
                          <v-list-tile
                            ripple
                            @click="toggleSelecionarTodos"
                          >
                            <v-list-tile-action>
                              <v-icon :color="perfis.length > 0 ? 'indigo darken-4' : ''">
                                {{ iconeSelecao }}
                              </v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                              <v-list-tile-title>Selecionar Todos</v-list-tile-title>
                            </v-list-tile-content>
                          </v-list-tile>
                          <v-divider class="mt-2" />
                        </template>
                      </v-select>
                    </v-flex>
                    <v-flex
                      xs12
                      sm4
                    >
                      <v-switch
                        v-model="formulario.st_ativo"
                        :label="`${$options.filters.filtroLabelStatus(formulario.st_ativo)}`"
                        color="primary"
                      />
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-form>
            </v-card-text>
            <v-card-actions class="justify-center">
              <v-btn
                @click="dialog = false"
              >
                <v-icon left>
                  undo
                </v-icon>
                Voltar
              </v-btn>
              <v-btn
                :loading="loading"
                :disabled="!valid || loading"
                color="primary"
                @click.native="salvarUsuario()"
              >
                <v-icon left>
                  send
                </v-icon>
                Salvar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';
import SDataPicker from '../../../shared/components/DatePicker';

export default {
  name: 'ListaEditarDialog',
  filters: {
    filtroLabelStatus(status) {
      return status ? 'Ativo' : 'Inativo';
    },
  },
  components: { SDataPicker },
  props: {
    value: {
      type: Boolean,
      default: false,
    },
    usuario: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      dialog: false,
      loading: false,
      showDatePicker: false,
      valid: false,
      formulario: {},
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        emailValido: value => Validate.isEmailValido(value) || 'O endereço de e-mail é inválido',
        dataValida: value => Validate.isDataValida(value) || 'Data inválida',
        minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
        minimoDePerfis: value => value.length > 0 || 'Selecione pelo menos um perfil',
      },
    };
  },
  computed: {
    ...mapGetters({
      perfis: 'conta/perfis',
    }),
    todosPerfisSelecionados() {
      if (Object.keys(this.formulario).length === 0) {
        return 0;
      }

      return this.formulario.perfis.length === this.perfis.length;
    },
    algumPerfilSelecionado() {
      if (Object.keys(this.formulario).length === 0) {
        return 0;
      }

      return this.formulario.perfis.length > 0 && !this.todosPerfisSelecionados;
    },
    iconeSelecao() {
      if (this.todosPerfisSelecionados) return 'check_box';
      if (this.algumPerfilSelecionado) return 'indeterminate_check_box';
      return 'check_box_outline_blank';
    },
  },
  watch: {
    value(val) {
      this.dialog = val;
    },
    dialog(val) {
      this.resetarValidacao();
      this.$emit('input', val);
    },
    usuario(val) {
      this.formulario = Object.assign({}, val);
    },
  },
  created() {
    this.buscarPerfis();
  },
  methods: {
    ...mapActions({
      atualizarUsuario: 'conta/atualizarUsuario',
      buscarPerfis: 'conta/buscarPerfis',
    }),
    toggleSelecionarTodos() {
      this.$nextTick(() => {
        if (this.todosPerfisSelecionados) {
          this.formulario.perfis = [];
        } else {
          this.formulario.perfis = this.perfis.slice();
        }
      });
    },
    salvarUsuario() {
      if (!this.$refs.form.validate()) {
        return;
      }

      const perfis = this.obterArrayIdPerfis(this.formulario);
      const usuario = Object.assign({}, this.formulario, { perfis });

      this.loading = true;
      this.atualizarUsuario({
        coUsuario: this.formulario.co_usuario,
        usuario,
      }).then(() => {
        this.dialog = false;
      }).finally(() => {
        this.loading = false;
      });
    },
    obterArrayIdPerfis(form) {
      return form.perfis.map(item => item.co_perfil);
    },
    resetarValidacao() {
      this.$refs.form.resetValidation();
    },
  },
};
</script>
