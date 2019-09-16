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
        <v-toolbar-title>
          Avaliação de recurso
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
                      mask="##.###.###/####-##"
                      required
                      disabled
                    />
                  </v-flex>
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-text-field
                      v-model="razao_social"
                      label="Razão social"
                      append-icon="people_outline"
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
                      mask="###.###.###-##"
                      disabled
                    />
                  </v-flex>
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-text-field
                      v-model="nomePessoaFisica"
                      label="*Nome do representante"
                      append-icon="perm_identity"
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
                      v-model="formulario.ds_email"
                      data-vv-name="email"
                      label="*E-mail do representante"
                      append-icon="mail"
                      placeholder="email@exemplo.com"
                      maxlength="100"
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
                      <b>Descrição do recurso:</b>
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
                      :rules="[rules.required, rules.tamanhoMaximoCaracteres]"
                      :counter="3000"
                      disabled
                    />
                  </v-flex>
                </v-layout>
                <v-divider />

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
                      :rules="[rules.required, rules.tamanhoMaximoCaracteres]"
                      required
                      :disabled="formulario.dh_parecer !== null"
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
                    <v-radio-group
                      v-model="formulario.st_parecer"
                      :rules="[rules.required]"
                      :disabled="formulario.dh_parecer !== null"
                    >
                      <template v-slot:label>
                        <div><strong>Avaliação</strong></div>
                      </template>
                      <v-radio
                        value="1"
                        color="success"
                      >
                        <template v-slot:label>
                          <div><strong class="success--text">Aceito</strong></div>
                        </template>
                      </v-radio>
                      <v-radio
                        value="0"
                        color="error"
                      >
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
          :disabled="!valid || loading || formulario.dh_parecer !== null"
          color="primary"
          @click.native="abrirDialogo"
        >
          <v-icon left>
            send
          </v-icon>
          Avaliar
        </v-btn>
      </v-card-actions>
    </v-card>


    <v-layout justify-center>
      <v-dialog
        v-model="modalConfirmacao"
        max-width="290"
      >
        <v-card>
          <v-card-title class="headline">
            Deseja realmente enviar?
          </v-card-title>

          <v-card-text>
            Os dados enviados não poderão ser alterados posteriormente.
          </v-card-text>

          <v-card-actions>
            <v-spacer />

            <v-btn
              color="red darken-1"
              text
              flat
              @click="fecharDialogo"
            >
              Não
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              flat
              :loading="loading"
              :disabled="loading"
              @click="salvar"
            >
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

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
      confirmacaoDados: false,
      modalConfirmacao: false,
      razao_social: String(),
      co_perfil: String(),
      nomeFormularioError: String(),
      nomePessoaFisica: String(),
      dialog: false,
      loading: false,
      valid: false,
      perfilPodeSerAlterado: false,
      formulario: { no_nome: String(), ds_parecer: String() },
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
        tamanhoMaximoCaracteres: value => (!!value && value.length <= 3000) || 'Máximo 3000 caracteres',
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
      this.formulario = Object.assign({});
      this.$refs.form_recurso.reset();
      if (valor) {
        this.formulario = Object.assign(this.formulario, this.usuario);
      }
    },
    usuario(usuario) {
      this.formulario = Object.assign(this.formulario, usuario);
    },
    'formulario.nu_cpf': function (valor) {
      this.carregarCPF(valor);
    },
    nomePessoaFisica(value) {
      this.formulario.no_nome = value;
    },
    'formulario.nu_cnpj': function (value) {
      const self = this;
      this.consultarCNPJ(value).then((response) => {
        const { data } = response.data;
        self.razao_social = data.nmRazaoSocial;
      });
    },
  },
  methods: {
    ...mapActions({
      buscarPerfisAlteracao: 'conta/buscarPerfisAlteracao',
      consultarCNPJ: 'pessoa/consultarCNPJ',
      consultarCPF: 'pessoa/consultarCPF',
      avaliarRecursoInscricao: 'recurso/avaliarRecursoInscricao',
    }),
    salvar() {
      const self = this;
      if (!self.$refs.form_recurso.validate()) {
        return false;
      }

      self.loading = true;
      this.avaliarRecursoInscricao(self.formulario)
        .then(() => {
          self.dialog = false;
        })
        .finally(() => {
          self.loading = false;
        });
      return true;
    },
    carregarCPF(valor) {
      const self = this;
      this.consultarCPF(valor).then((response) => {
        const { data } = response.data;
        self.nomePessoaFisica = data.nmPessoaFisica;
      });
    },
    abrirDialogo() {
      const self = this;
      if (!self.$refs.form_recurso.validate()) {
        return false;
      }
      this.modalConfirmacao = true;
      return true;
    },
    fecharDialogo() {
      this.modalConfirmacao = false;
    },
  },
  mounted() {
    this.buscarPerfisAlteracao();
  },
};
</script>
