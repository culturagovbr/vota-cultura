<template>
  <v-layout wrap>
    <v-flex v-if="Object.keys(conselhoGetter).length > 0">
      <v-layout>
        <v-flex>
          <v-radio-group
            v-model="conselho.tp_governamental"
            disabled
            row
          >
            <v-radio
              label="Estadual"
              value="e"
            />
            <v-radio
              label="Capital"
              value="c"
            />
          </v-radio-group>
        </v-flex>
      </v-layout>


      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.nu_cnpj"
            label="CNPJ do Orgão Gestor do Conselho"
            append-icon="people"
            mask="##.###.###/####-##"
            disabled
          />
        </v-flex>
      </v-layout>


      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.no_orgao_gestor"
            label="Nome do órgão gestor de cultura"
            append-icon="people"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.no_conselho"
            label="*Nome do conselho de cultura"
            append-icon="people"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.nu_telefone"
            label="Telefone do Conselho"
            append-icon="phone"
            mask="(##) #####-####"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.ds_email"
            label="E-mail do Conselho"
            append-icon="mail"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.ds_sitio_eletronico"
            label="Sítio eletrônico do conselho"
            append-icon="public"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.endereco.nu_cep"
            label="CEP"
            append-icon="my_location"
            mask="#####-###"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.endereco.ds_logradouro"
            label="Logradouro"
            append-icon="place"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.endereco.ds_complemento"
            label="Complemento"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="conselho.endereco.co_ibge"
            :items="listaUF"
            label="Unidade da Federação da Sede"
            item-value="co_ibge"
            item-text="no_uf"
            append-icon="place"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="conselho.endereco.co_municipio"
            :items="listaMunicipios"
            label="Cidade"
            append-icon="place"
            item-value="co_municipio"
            item-text="no_municipio"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.representante.no_nome"
            label="Nome do representante"
            append-icon="perm_identity"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.representante.nu_telefone"
            label="Celular do representante"
            append-icon="phone"
            mask="(##) #####-####"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.representante.nu_cpf"
            label="CPF"
            append-icon="person"
            mask="###.###.###.##"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.representante.nu_rg"
            label="RG"
            append-icon="person"
            mask="##.###.###-#"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="conselho.representante.ds_email"
            label="E-mail do representante"
            append-icon="mail"
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
  name: 'ConselhoDetalhesInscricaoVisualizacao',
  data: () => ({
    listaUF: [],
    listaMunicipios: [],
    conselho: {},
  }),
  computed: {
    ...mapGetters({
      conselhoGetter: 'conselho/conselho',
      estadosGetter: 'localidade/estados',
      municipiosGetter: 'localidade/municipios',
    }),
  },
  watch: {
    conselhoGetter(value) {
      this.conselho = value;
      if (this.listaMunicipios.length < 1 && Object.keys(this.conselhoGetter).length > 0) {
        this.obterMunicipios(value.endereco.co_ibge);
      }
    },
    estadosGetter(value) {
      this.listaUF = value;
    },
    municipiosGetter(value) {
      this.listaMunicipios = value;
    },
  },
  mounted() {
    this.listaUF = this.estadosGetter;
    if (this.listaUF.length < 1) {
      this.obterEstados();
    }
    this.conselho = this.conselhoGetter;
    this.listaMunicipios = this.municipiosGetter;
  },
  methods: {
    formatarDataCarbon(data) {
      if (data.length === 0 || !data.trim()) {
        return false;
      }
      const [dia, mes, ano] = data.split('/');

      return `${ano}-${(`0${mes}`).slice(-2)}-${(`0${dia}`).slice(-2)}`;
    },
    ...mapActions({
      obterEstados: 'localidade/obterEstados',
      obterMunicipios: 'localidade/obterMunicipios',
    }),

  },

};
</script>
