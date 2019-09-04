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
                v-if="Object.keys(formulario).length > 0"
                v-show="true"
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
                        :value="formulario.nu_cpf"
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
                        disabled
                        maxlength="100"
                        :rules="[rules.required]"
                      />
                    </v-flex>
                    <v-flex
                      xs6
                      md6
                      sm12
                    >
                      <v-text-field
                        v-model="formulario.ds_email"
                        name="ds_email"
                        label="E-mail"
                        validate-on-blur
                        type="text"
                        maxlength="80"
                        :rules="[rules.required, rules.emailValido]"
                      />
                    </v-flex>
                    <v-flex
                      xs4
                      md4
                      sm12>
                      <v-select
                        v-model="formulario.perfil.co_perfil"
                        :items="perfis"
                        :disabled="rules.podeAlterarPerfil()"
                        item-text="ds_perfil"
                        item-value="co_perfil"
                        label="Perfil"
                        validate-on-blur
                      />
                    </v-flex>
                    <v-flex
                      xs12
                      sm4
                    >
                      <v-switch
                        v-model="formulario.st_ativo"
                        :label="formulario.st_ativo ? 'Ativo' : 'Inativo'"
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
import { includes } from "lodash";
import Validate from '@/modules/shared/util/validate';

export default {
  name: 'AdministradorListaUsuariosDialog',
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
      perfilPodeSerAlterado: false,
      formulario: {},
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        emailValido: value => Validate.isEmailValido(value) || 'O endereço de e-mail é inválido',
        minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
        podeAlterarPerfil: () => {
          return !includes(this.perfisInscricao, this.usuario.perfil);
        },
      },
    };
  },
  computed: {
    ...mapGetters({
      perfis: 'conta/perfis',
      perfisInscricao: 'conta/perfisInscricao',
    }),
  },
  watch: {
    value(val) {
      this.dialog = val;
    },
    dialog(val) {
      this.$emit('input', val);

    },
    usuario(val) {
      this.formulario = Object.assign({}, val);
    },
  },
  methods: {
    ...mapActions({
      atualizarUsuario: 'conta/atualizarUsuario',
      buscarPerfisAlteracao: 'conta/buscarPerfisAlteracao',
    }),
    salvarUsuario() {
    },
    habilitaAlteracaoPerfil() {
      if(this.formulario.perfi){

      }
    },
  },
  mounted() {
    this.buscarPerfisAlteracao();
  },
};
</script>
