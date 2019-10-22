<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-window v-model="step">
      <v-window-item :value="1">
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
            v-model="valid"
            lazy-validation
            autocomplete="off"
          >
            <v-text-field
              v-model="usuario.nu_cpf"
              prepend-icon="account_circle"
              name="login"
              label="CPF"
              mask="###.###.###-##"
              validate-on-blur
              type="text"
              :rules="[rules.required, rules.validarCPF]"
            />
            <v-text-field
              v-model="usuario.no_nome"
              prepend-icon="person"
              name="nome"
              label="Nome completo"
              validate-on-blur
              type="text"
              :rules="[rules.required]"
            />
            <template>
              <v-menu
                ref="menu"
                v-model="menu"
                lazy
                transition="scale-transition"
                :close-on-content-click="false"
                offset-y
                full-width
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="dataFormatada"
                    mask="##/##/####"
                    return-masked-value
                    label="Data de Nascimento"
                    prepend-icon="event"
                    :rules="[rules.required]"
                    v-on="on"
                  />
                </template>
                <v-date-picker
                  v-model="date"
                  @input="menu = false"
                />
              </v-menu>
            </template>
            <v-text-field
              v-model="usuario.no_email"
              prepend-icon="mail_outline"
              name="no_email"
              label="E-mail"
              validate-on-blur
              type="text"
              :rules="[rules.required, rules.emailValido]"
            />
            <v-text-field
              v-model="usuario.confirma_email"
              prepend-icon="mail_outline"
              name="confirmacao_email"
              label="Confirmar e-mail"
              validate-on-blur
              type="text"
              :rules="[rules.required, rules.emailValido, rules.confirmaEmail(usuario.confirma_email, usuario.no_email)]"
            />
            <v-text-field
              id="password"
              v-model="usuario.ds_senha"
              prepend-icon="vpn_key"
              :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
              :type="mostrarSenha ? 'text' : 'password'"
              label="Senha"
              name="password"
              :rules="[rules.required, rules.minCaracter, rules.senhaValida]"
              @click:append="mostrarSenha = !mostrarSenha"
            />
            <v-text-field
              id="confirm_password"
              v-model="usuario.confirma_senha"
              prepend-icon="vpn_key"
              :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
              :type="mostrarSenha ? 'text' : 'password'"
              label="Confirmar senha"
              name="confirm_password"
              :rules="[rules.required, rules.confirmaSenha(usuario.confirma_senha, usuario.ds_senha)]"
              @click:append="mostrarSenha = !mostrarSenha"
            />
          </v-form>
          <span class="grey--text">Todos os campos são obrigatórios</span>
        </v-card-text>
        <!-- <v-card-actions> -->
        <div class="login-btn">
          <v-btn
            :disabled="!valid"
            block
            color="primary"
            :loading="loading"
            @click="login"
          >
            Cadastrar
          </v-btn>
          <v-spacer />
          <v-btn
            block
            color="default"
            :to="{ name: 'conta-autenticar' }"
          >
            Voltar
          </v-btn>
        </div>
        <!-- </v-card-actions> -->
      </v-window-item>
      <v-window-item :value="2">
        <v-card-text>
          <div class="text-xs-center">
            <v-icon
              size="80px"
              color="primary"
            >
              check_circle
            </v-icon>
            <h3 class="title font-weight-light mb-2">
              Cadastro realizado com sucesso
            </h3>
            <span
              class="caption grey--text"
            >Um link para ativação da sua conta foi enviado para o e-mail {{ usuario.no_email }}.</span>
          </div>
        </v-card-text>
        <!-- <v-card-actions> -->
        <v-btn
          block
          color="primary"
          :to="{ name: 'conta-autenticar' }"
        >
          Login
        </v-btn>
        <!-- </v-card-actions> -->
      </v-window-item>
    </v-window>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';

export default {
  data: () => ({
    loading: false,
    mostrarSenha: false,
    valid: true,
    menu: false,
    date: '',
    dataFormatada: '',
    step: 1,
    usuario: {
      no_cpf: '',
      no_nome: '',
      dt_nascimento: '',
      no_email: '',
      ds_senha: '',
    },
    rules: {
      required: value => !!value || 'Este campo é obrigatório',
      validarCPF: value => Validate.isCpfValido(value) || 'CPF inválido',
      emailValido: value => Validate.isEmailValido(value) || 'E-mail inválido',
      confirmaEmail: (confirma_email, no_email) => confirma_email === no_email || 'O E-mail não confere',
      minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
      senhaValida: value => Validate.isSenhaValida(value)
        || 'Mínimo uma letra maiúscula, uma minúscula e um número',
      confirmaSenha: (confirma_senha, ds_senha) => confirma_senha === ds_senha || 'A senha não confere',
    },
  }),
  watch: {
    date() {
      this.dataFormatada = this.formatDate(this.date);
    },
  },
  methods: {
    ...mapActions({
      cadastrarUsuario: 'conta/cadastrarUsuario',
      setMensagemErro: 'app/setMensagemErro',
    }),
    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.split('-');
      return `${day}/${month}/${year}`;
    },
    login() {
      if (!this.$refs.form.validate()) {
        return;
      }
      this.loading = true;

      const [dia, mes, ano] = this.dataFormatada.split('/');
      this.usuario.dt_nascimento = `${ano}-${mes}-${dia}`;

      this.cadastrarUsuario(this.usuario)
        .then(() => {
          this.loading = false;
          this.step = 2;
        })
        .catch((error) => {
          this.loading = false;
          this.setMensagemErro({ text: error.response.data.message });
        });
    },
  },
};
</script>
