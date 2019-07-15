<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <div class="layout column align-center">
        <h2 class="flex my-2 primary--text">
          Cadastro
        </h2>
      </div>
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
        autocomplete="off"
      >
        <v-text-field
          v-model="usuario.no_cpf"
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
        <template activator="{ on }">
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
                      v-model="usuario.dt_nascimento"
                      mask="NN/NN/NNNN"
                      label="Data de Nascimento"
                      :rules="[rules.required]"
                      prepend-icon="event"
                      v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              locale="pt-BR"
              v-model="date"
              scrollable>
              <v-spacer></v-spacer>
              <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
              <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
            </v-date-picker>
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
          @click:append="mostrarSenha = !mostrarSenha"
          :rules="[rules.required, rules.minCaracter, rules.senhaValida]"
        />
        <v-text-field
          id="confirm_password"
          v-model="usuario.confirma_senha"
          prepend-icon="vpn_key"
          :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
          :type="mostrarSenha ? 'text' : 'password'"
          label="Confirmar senha"
          name="confirm_password"
          @click:append="mostrarSenha = !mostrarSenha"
          :rules="[rules.required, rules.confirmaSenha(usuario.confirma_senha, usuario.ds_senha)]"
        />
      </v-form>
      <span class="grey--text">Todos os campos são obrigatórios </span>
    </v-card-text>
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
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
import Validate from '@/modules/shared/util/validate';

export default {
  data: () => ({
    appTitle: process.env.VUE_APP_TITLE,
    loading: false,
    mostrarSenha: false,
    valid: true,
    menu: false,
    date:'',
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
      minCaracter: (value) => value.length >= 8 || 'Mínimo 8 caracteres',
      senhaValida: value => Validate.isSenhaValida(value) || 'Mínimo uma letra maiúscula, uma minúscula e um número',
      confirmaSenha: (confirma_senha, ds_senha) => confirma_senha === ds_senha || 'A senha não confere',
    },
  }),
  watch: {
    date () {
        this.usuario.dt_nascimento = this.formatDate(this.date);
    }
  },
  methods: {
    ...mapActions({
      cadastrarUsuario: 'conta/cadastrarUsuario',
    }),
    formatDate (date) {
      if (!date) return null;
      const [year, month, day] = date.split('-');
      return `${day}/${month}/${year}`;
    },
    login() {
      if (!this.$refs.form.validate()) {
        return;
      }
      this.loading = true;
      console.log(this.usuario);
      // this.cadastrarUsuario(this.usuario).then(() => {
      //   this.$router.push('/');
      // }).finally(() => {
      //   this.loading = false;
      // });
    },
  },
};
</script>
