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
        <v-toolbar-title v-if="!!formulario.hasOwnProperty('co_recurso_inscricao')">
          Editar Recurso
        </v-toolbar-title>
        <v-toolbar-title v-else>
          Cadastrar Recurso
        </v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-card>
            <v-card-text>
              <v-form
                ref="form_recurso"
                v-model="valid"
                lazy-validation
              >
                <v-layout class="mt-1">
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-radio-group
                      v-model="formulario.co_fase"
                      row
                      :rules="[rules.required]"
                      disabled
                    >
                      <v-radio
                        label="Conselho de cultura"
                        value="4"
                      />
                      <v-radio
                        label="Organização ou entidade cultural"
                        value="5"
                      />
                    </v-radio-group>
                  </v-flex>
                </v-layout>
                <v-layout
                  wrap
                  align-center
                  class="mt-1"
                >
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-text-field
                      v-model="formulario.nu_cnpj"
                      label="*CNPJ"
                      append-icon="people"
                      placeholder="99.999.999/9999-99"
                      :error-messages="nomeConselhoError"
                      mask="##.###.###/####-##"
                      :rules="[rules.required, rules.cnpjMin]"
                      required
                      disabled
                    />
                  </v-flex>
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-text-field
                      v-model="nomeConselho"
                      label="Razão social"
                      append-icon="people_outline"
                      :rules="[rules.cnpjInvalido]"
                      required
                      style="margin-left: 20px"
                      disabled
                    />
                  </v-flex>
                </v-layout>
                <v-layout
                  wrap
                  align-center
                  class="mt-1"
                >
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-text-field
                      v-model="formulario.nu_cpf"
                      label="*CPF do representante"
                      append-icon="person"
                      placeholder="999.999.999-99"
                      mask="###.###.###-##"
                      :error-messages="nomeRepresentanteError"
                      :rules="[rules.required, rules.cpfMin]"
                      required
                      disabled
                    />
                  </v-flex>
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-text-field
                      v-model="nomeRepresentante"
                      label="*Nome do representante"
                      append-icon="perm_identity"
                      :error-messages="nomeRepresentanteError"
                      :rules="[rules.cpfInvalido]"
                      style="margin-left: 20px"
                      required
                      disabled
                    />
                  </v-flex>
                </v-layout>

                <v-layout
                  wrap
                  align-center
                  class="mt-1"
                >
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-text-field
                      v-model="formulario.ds_email"
                      data-vv-name="email"
                      label="*E-mail do representante"
                      append-icon="mail"
                      placeholder="email@exemplo.com"
                      maxlength="100"
                      :rules="[rules.required, rules.email]"
                      required
                      disabled
                    />
                  </v-flex>
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-text-field
                      v-model="formulario.nu_telefone"
                      label="*Celular do representante"
                      append-icon="phone"
                      placeholder="(99) 99999-9999"
                      mask="(##) #####-####"
                      :rules="[rules.required, rules.phoneMin]"
                      required
                      style="margin-left: 20px"
                      disabled
                    />
                  </v-flex>
                </v-layout>
                <v-layout
                  wrap
                  align-center
                >
                  <v-flex
                    xs12
                    sm12
                  >
                    <div class="ma-4 text-justify subheading grey--text">
                      <b>Descrição do Recurso:</b>
                    </div>
                  </v-flex>
                </v-layout>
                <v-layout
                  wrap
                  align-center
                >
                  <v-flex
                    xs12
                    sm12
                    class="ma-3"
                  >
                    <v-textarea
                      v-model="formulario.ds_recurso"
                      name="input-7-1"
                      box
                      solo
                      label="Descrição do recurso"
                      auto-grow
                      :placeholder="'Digite seu recurso aqui.'"
                      :counter="3000"
                      :rules="[rules.required]"
                      disabled
                    />
                  </v-flex>
                </v-layout>
                <v-divider></v-divider>

                <v-layout
                  wrap
                  align-center
                >
                  <v-flex
                    xs12
                    sm12
                    class="ma-3"
                  >
                    <div class="ma-4 text-justify subheading grey--text">
                      <b>Parecer:</b>
                    </div>
                    <v-textarea
                      v-model="formulario.ds_parecer"
                      name="input-7-1"
                      box
                      solo
                      label="Parecer do recurso"
                      auto-grow
                      :placeholder="'Digite seu recurso aqui.'"
                      :counter="3000"
                      :rules="[rules.required]"
                      disabled
                    />
                  </v-flex>
                </v-layout>
                <v-layout
                  wrap
                  align-center
                >
                  <v-flex
                    xs12
                    sm12
                    class="ma-3"
                  >
                    <v-radio-group v-model="formulario.st_parecer">
                      <template v-slot:label>
                        <div><strong>Avaliação</strong></div>
                      </template>
                      <v-radio value="1" color="success">
                        <template v-slot:label>
                          <div><strong class="success--text">Aceito</strong></div>
                        </template>
                      </v-radio>
                      <v-radio value="0" color="error">
                        <template v-slot:label>
                          <div><strong class="error--text">Recusado</strong></div>
                        </template>
                      </v-radio>
                    </v-radio-group>
                  </v-flex>
                </v-layout>
              </v-form>
            </v-card-text>
          </v-card>
        </v-container>
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
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';

export default {
  name: 'AdministradorListaRecursosDialog',
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

      if (valor) {
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
      const self = this;
      if (!self.$refs.form.validate()) {
        return false;
      }
      self.loading = true;
      this.salvarUsuario(self.formulario)
        .then(() => {
          self.dialog = false;
        })
        .finally(() => {
          self.loading = false;
        });
      return true;
    },
    carregarCPF(valor) {
      this.consultarCPF(valor).then((response) => {
        const { data } = response.data;
        this.formulario.no_nome = data.nmPessoaFisica;
        this.nmPessoaFisica = data.nmPessoaFisica;
      });
    },
  },
  mounted() {
    this.buscarPerfisAlteracao();
  },
};
</script>
