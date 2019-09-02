<template>
  <v-container fluid>
    <v-form
      ref="form"
      v-model="valid"
      lazy-validation
      @submit.prevent="filtrarLista"
    >
      <v-layout
        row
        justify-space-between
      >
        <v-flex
          xs12
          md3
        >
          <v-text-field
            v-model="filtro.no_cpf"
            name="no_cpf"
            label="CPF"
            mask="###.###.###-##"
            validate-on-blur
            type="text"
            :rules="[rules.validarCPF]"
          />
        </v-flex>
        <v-flex
          xs12
          md5
        >
          <v-text-field
            v-model="filtro.no_nome"
            name="nome"
            label="Nome"
            maxlength="100"
            validate-on-blur
            type="text"
          />
        </v-flex>
        <v-flex
          xs12
          md4
        >
          <v-select
            v-model="filtro.co_perfil"
            :items="perfis"
            item-text="no_perfil"
            item-value="co_perfil"
            label="Perfil"
            validate-on-blur
          />
        </v-flex>
      </v-layout>
      <v-layout
        row
        justify-space-between
      >
        <v-flex
          xs12
          md3
        >
          <v-switch
            v-model="filtro.st_ativo"
            color="primary"
            :label="`Status: ${$options.filters.filtroLabelStatus(filtro.st_ativo)}`"
          />
        </v-flex>
        <v-flex
          xs12
          md4
          class="text-xs-right"
        >
          <v-btn
            type="submit"
            color="primary"
            class="white--text"
            :disabled="!valid"
            @click.prevent="filtrarLista()"
          >
            Pesquisar
            <v-icon
              right
              dark
            >
              search
            </v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
    </v-form>
  </v-container>
</template>

<script>

import { mapActions, mapGetters } from 'vuex';
import Validate from '@/modules/shared/util/validate';

export default {
  filters: {
    filtroLabelStatus(status) {
      return status ? 'Ativo' : 'Inativo';
    },
  },
  data: () => ({
    allowSpaces: false,
    valid: true,
    filtro: {
      st_ativo: 1,
      no_nome: '',
      nu_cpf: '',
      co_perfil: '',
    },
    rules: {
      validarCPF: v => Validate.isCpfValido(v) || !v || 'O CPF informado é inválido',
    },
  }),
  computed: {
    ...mapGetters({
      perfis: 'conta/perfis',
    }),
  },
  created() {
    this.buscarPerfis();
  },
  methods: {
    ...mapActions({
      buscarPerfis: 'conta/buscarPerfis',
    }),
    validateField() {
      this.$refs.form.validate();
    },
    filtrarLista() {
      this.$emit('filtrarLista', this.filtro);
    },
  },
};
</script>
