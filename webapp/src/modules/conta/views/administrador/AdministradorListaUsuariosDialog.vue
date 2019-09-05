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
        <v-toolbar-title v-if="!!formulario.hasOwnProperty('co_usuario')">
          Editar Usuário
        </v-toolbar-title>
        <v-toolbar-title v-else>
          Cadastrar Usuário
        </v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-card>
            <v-card-text>
              <v-form
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
                        v-model="formulario.nu_cpf"
                        label="*CPF"
                        append-icon="account_circle"
                        :rules="[rules.required, rules.cpfMin, rules.cpfInvalido]"
                        :error-messages="nomeFormularioError"
                        mask="###.###.###-##"
                        required
                        :disabled="!!formulario.hasOwnProperty('co_usuario')"
                      />
                    </v-flex>
                    <v-flex
                      xs8
                      md8
                      sm12
                    >
                      <v-text-field
                        v-model="nmPessoaFisica"
                        :disabled="true"
                        label="*Nome completo"
                        append-icon="perm_identity"
                        :error-messages="nomeFormularioError"
                        :rules="[rules.cpfInvalido]"
                        required
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
                      sm12
                    >
                      <v-select
                        v-model="formulario.perfil.co_perfil"
                        :items="perfis"
                        item-text="ds_perfil"
                        item-value="co_perfil"
                        :rules="[rules.required]"
                        label="Perfil"
                        :disabled="
                          this.formulario.perfil.co_perfil !== 777 &&
                          this.formulario.perfil.co_perfil !== 1 &&
                          formulario.hasOwnProperty('co_usuario')"
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
                        :disabled="
                          !formulario.hasOwnProperty('co_usuario') ||
                          !!formulario.ds_codigo_ativacao"
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
                @click.native="salvar"
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
      co_perfil: '',
      nomeFormularioError: '',
      dialog: false,
      loading: false,
      valid: false,
      perfilPodeSerAlterado: false,
      formulario: {
        no_nome: '',
        nu_cpf: '',
        perfil: {
          co_perfil: '',
        },
      },
      nmPessoaFisica: '',
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        cpfMin: value => (value && value.length === 11) || 'Mínimo de 11 caracteres',
        cpfInvalido: value => !!value || 'CPF não encontrado',
        emailValido: value => Validate.isEmailValido(value) || 'O endereço de e-mail é inválido',
        minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
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
    dialog(valor) {
      this.$emit('input', valor);
      this.formulario = Object.assign({
        no_nome: '',
        nu_cpf: '',
        perfil: {
          co_perfil: '',
        },
      });
      this.$refs.form.reset();

      if (!!valor) {
        this.formulario = Object.assign(this.formulario, this.usuario);
      }
    },
    nmPessoaFisica(nome) {
      this.formulario.no_nome = nome;
    },
    usuario(usuario) {
      this.formulario = Object.assign(this.formulario, usuario);
    },
    'formulario.nu_cpf': function (valor) {
      this.formulario.no_nome = String();
      this.nomeFormularioError = String();
      this.nmPessoaFisica = String();
      if (!!valor && valor.length === 11) {
        if (!Validate.isCpfValido(valor)) {
          this.nomeFormularioError = 'CPF inválido';
          return false;
        }
        this.carregarCPF(valor);
      }
    },
  },
  methods: {
    ...mapActions({
      salvarUsuario: 'conta/salvarUsuario',
      buscarPerfisAlteracao: 'conta/buscarPerfisAlteracao',
      consultarCPF: 'pessoa/consultarCPF',
    }),
    salvar() {
      if (!this.$refs.form.validate()) {
        return false;
      }

      const self = this;
      self.carregando = true;
      this.salvarUsuario(self.formulario)
        .then(() => {
          self.dialog = false;
        })
        .finally(() => {
          self.carregando = false;
        });
    },
    carregarCPF(valor) {
      this.consultarCPF(valor).then((response) => {
        const { data } = response.data;
        this.formulario.no_nome = data.nmPessoaFisica;
        this.nmPessoaFisica = data.nmPessoaFisica;
      });
    },
    checarUsuarioPodeEditarPerfil(){
      if(this.formulario.perfil.co_perfil !== 777 && this.formulario.perfil.co_perfil !== 1 ){
        this.perfilPodeSerAlterado = false;
      }

      if (!this.formulario.hasOwnProperty('co_usuario')) {
        this.perfilPodeSerAlterado = true;
      }
      return this.perfilPodeSerAlterado;
    },
  },
  mounted() {
    this.buscarPerfisAlteracao();
  },
};
</script>
