<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-window v-model="step">
      <v-window-item :value="1">
        <v-card-title>
          <div class="layout column align-center">
            <h2 class="flex my-2 primary--text">{{$route.meta.title}}</h2>
          </div>
        </v-card-title>
        <v-card-text>
          <v-form ref="form" v-model="valid" lazy-validation>
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
                  ></v-text-field>
                </template>
                <v-date-picker v-model="date" @input="menu = false"></v-date-picker>
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
          </v-form>
        </v-card-text>
        <div class="login-btn">
          <v-btn
            type="submit"
            :disabled="!valid"
            block
            color="primary"
            :loading="loading"
            @click="recuperar"
          >Recuperar</v-btn>
          <v-spacer />
          <v-btn block color="default" :to="{ name: 'conta-autenticar' }">Voltar</v-btn>
        </div>
      </v-window-item>
      <v-window-item :value="2">
        <v-card-text>
          <div class="text-xs-center">
            <v-icon size="80px" color="primary">check_circle</v-icon>
            <h3
              class="title font-weight-light mb-2"
            >Solicitação para alterar senha realizada com sucesso</h3>
            <span
              class="caption grey--text"
            >Um link para criação de uma nova senha foi enviado para o e-mail {{usuario.no_email}}</span>
          </div>
        </v-card-text>
        <!-- <v-card-actions> -->
        <v-btn block color="primary" :to="{ name: 'conta-autenticar' }">Login</v-btn>
        <!-- </v-card-actions> -->
      </v-window-item>
    </v-window>
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Validate from "@/modules/shared/util/validate";

export default {
  data: () => ({
    loading: false,
    mostrarSenha: false,
    valid: true,
    menu: false,
    date: "",
    dataFormatada: "",
    step: 1,
    usuario: {
      no_cpf: "",
      dt_nascimento: "",
      no_email: ""
    },
    rules: {
      required: value => !!value || "Este campo é obrigatório",
      validarCPF: value => Validate.isCpfValido(value) || "CPF inválido",
      emailValido: value => Validate.isEmailValido(value) || "E-mail inválido"
    }
  }),
  watch: {
    date() {
      this.dataFormatada = this.formatDate(this.date);
    }
  },
  methods: {
    ...mapActions({
      recuperarSenha: "conta/recuperarSenha",
      mensagemErro: "app/setMensagemErro"
    }),
    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    recuperar() {
      if (!this.$refs.form.validate()) {
        return;
      }
      this.loading = true;
      const [dia, mes, ano] = this.dataFormatada.split("/");
      this.usuario.dt_nascimento = `${ano}-${mes}-${dia}`;

      this.recuperarSenha(this.usuario)
        .then(() => {
          this.step = 2;
        })
        .catch(error => {
          this.loading = false;
          this.mensagemErro(error.response.data.message);
        });
    }
  }
};
</script>
