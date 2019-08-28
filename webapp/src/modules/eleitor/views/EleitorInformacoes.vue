<template>
  <v-layout wrap>
    <v-flex>
      <v-layout
        wrap
        align-center
      >
        <v-flex>
          <v-text-field
            v-model="eleitorGetter.nu_cpf"
            disabled
            label="CPF"
            append-icon="account_circle"
            mask="###.###.###-##"
          />
        </v-flex>
      </v-layout>
      <v-layout
        wrap
        align-center
      >
        <v-flex>
          <v-text-field
            v-model="eleitorGetter.no_nome"
            disabled
            label="Nome completo"
            append-icon="perm_identity"
          />
        </v-flex>
      </v-layout>
      <v-layout
        wrap
        align-center
      >
        <v-flex>
          <v-text-field
            v-model="eleitorGetter.nu_rg"
            disabled
            label="RG"
            append-icon="account_circle"
            mask="#########"
          />
        </v-flex>
      </v-layout>

      <v-layout
        wrap
        align-center
      >
        <v-flex>
          <v-text-field
            v-model="eleitorGetter.dt_nascimento"
            disabled
            label="Data de Nascimento"
            append-icon="event"
            mask="##/##/####"
          />
        </v-flex>
      </v-layout>

      <v-layout
        wrap
        align-center
      >
        <v-flex>
          <v-text-field
            v-model="eleitorGetter.ds_email"
            disabled
            label="E-mail"
            append-icon="mail"
            placeholder="email@exemplo.com"
          />
        </v-flex>
      </v-layout>

      <v-layout
        wrap
        align-center
      >
        <v-flex>
          <v-select
            v-model="eleitorGetter.st_estrangeiro"
            :items="[{ st_estrangeiro: 0 , nome: 'Brasileiro'},
                     { st_estrangeiro: 1 , nome: 'Outros'}]"
            item-value="st_estrangeiro"
            item-text="nome"
            label="Nacionalidade"
            append-icon="place"
            disabled
          />
        </v-flex>
      </v-layout>
      <v-layout
        wrap
        align-center
      >
        <v-flex>
          <v-select
            v-model="eleitorGetter.co_ibge"
            :items="listaUF"
            label="Unidade da Federação"
            append-icon="place"
            item-value="co_ibge"
            item-text="no_uf"
            disabled
          />
        </v-flex>
      </v-layout>
    </v-flex>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'EleitorInformacoes',
  data: () => ({
    listaUF: [],
    eleitor: {},
  }),
  // props: {
  //   value: {
  //     type: Boolean,
  //     default: true,
  //   },
  // },
  computed: {
    ...mapGetters({
      eleitorGetter: 'eleitor/eleitor',
      estadosGetter: 'localidade/estados',
    }),
  },
  watch: {
    eleitorGetter(value) {
      this.eleitor = value;
    },
  },
  mounted() {
    this.listaUF = this.estadosGetter;
    if (this.listaUF.length < 1) {
      this.obterEstados();
    }
    this.eleitor = this.eleitorGetter;
  },
  methods: {
    formatarDataCarbon(data) {
      const dia = data.split('/')[0];
      const mes = data.split('/')[1];
      const ano = data.split('/')[2];

      return `${ano}-${(`0${mes}`).slice(-2)}-${(`0${dia}`).slice(-2)}`;
    },
    ...mapActions({
      obterEstados: 'localidade/obterEstados',
    }),
  },

};
</script>
