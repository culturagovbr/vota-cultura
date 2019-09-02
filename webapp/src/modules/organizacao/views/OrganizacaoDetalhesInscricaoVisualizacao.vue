<template>
  <v-layout wrap>
    <v-flex v-if="Object.keys(organizacaoGetter).length > 0">
      <v-layout>
        <v-flex>
          <v-text-field
            v-model="organizacao.nu_cnpj"
            label="CNPJ"
            append-icon="people"
            mask="##.###.###/####-##"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="organizacao.no_organizacao"
            label="Nome da Organização/Entidade"
            append-icon="perm_identity"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="organizacao.nu_telefone"
            label="Telefone"
            append-icon="phone"
            mask="(##) #####-####"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="organizacao.ds_email"
            label="E-mail"
            append-icon="mail"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="organizacao.ds_sitio_eletronico"
            label="Sítio eletrônico da Organização/Entidade"
            append-icon="public"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="organizacao.endereco.nu_cep"
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
            v-model="organizacao.endereco.ds_logradouro"
            label="Logradouro"
            append-icon="place"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="organizacao.endereco.ds_complemento"
            label="Complemento"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="organizacao.endereco.co_ibge"
            :items="listaUF"
            label="Unidade da federação da sede"
            append-icon="place"
            item-value="co_ibge"
            item-text="no_uf"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="organizacao.endereco.co_municipio"
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
            v-model="organizacao.representante.no_nome"
            label="Nome do representante"
            append-icon="perm_identity"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="organizacao.representante.nu_telefone"
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
            v-model="organizacao.representante.nu_cpf"
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
            v-model="organizacao.representante.nu_rg"
            label="RG"
            append-icon="person"
            mask="#########"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-text-field
            v-model="organizacao.representante.ds_email"
            label="E-mail do representante"
            append-icon="mail"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-radio-group
            v-model="organizacao.co_segmento"
            label="Segmento"
            disabled
          >
            <v-radio
              v-for="(segmento, i) in listaSegmentos"
              :key="i"
              :label="segmento.ds_detalhamento"
              :value="segmento.co_segmento"
            />
          </v-radio-group>
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="organizacao.criterios.abrangencia_nacional"
            :items="listaCriterios.abrangencia_nacional"
            item-value="co_criterio"
            item-text="ds_detalhamento"
            label="Abrangência Nacional"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="organizacao.criterios.abrangencia_estadual"
            :items="listaCriterios.abrangencia_estadual"
            item-value="co_criterio"
            item-text="ds_detalhamento"
            label="Abrangência Estadual"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="organizacao.criterios.tempo_funcionamento"
            :items="listaCriterios.tempo_funcionamento"
            item-value="co_criterio"
            item-text="ds_detalhamento"
            label="Tempo de Funcionamento"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="organizacao.criterios.nu_associados_filiados"
            :items="listaCriterios.nu_associados_filiados"
            item-value="co_criterio"
            item-text="ds_detalhamento"
            label="Nº de Associados ou Filiados"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="organizacao.criterios.nu_atividades"
            :items="listaCriterios.nu_atividades"
            item-value="co_criterio"
            item-text="ds_detalhamento"
            label="Nº Atividades/projetos realizados no campo cultural a partir de 2016"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="organizacao.criterios.participacao_instancias"
            :items="listaCriterios.participacao_instancias"
            item-value="co_criterio"
            item-text="ds_detalhamento"
            label="Participação em instâncias de formulação de política cultural"
            disabled
          />
        </v-flex>
      </v-layout>

      <v-layout>
        <v-flex>
          <v-select
            v-model="organizacao.criterios.pesquisa_producao"
            :items="listaCriterios.pesquisa_producao"
            item-value="co_criterio"
            item-text="ds_detalhamento"
            label="Projetos na área de pesquisa ou produção do conhecimento no campo da cultura a partir de 2016"
            disabled
          />
        </v-flex>
      </v-layout>
    </v-flex>
  </v-layout>
</template>

<script>
import _ from 'lodash';
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'OrganizacaoDetalhesInscricaoVisualizacao',
  data: () => ({
    listaUF: [],
    listaSegmentos: [],
    listaMunicipios: [],
    listaCriterios: [],
    organizacao: {},
  }),
  computed: {
    ...mapGetters({
      organizacaoGetter: 'organizacao/organizacao',
      estadosGetter: 'localidade/estados',
      municipiosGetter: 'localidade/municipios',
      segmentosGetter: 'organizacao/segmentos',
      criteriosGetter: 'organizacao/criterios',
    }),
  },
  watch: {
    criteriosGetter() {
      this.listaCriterios = _.groupBy(
        this.criteriosGetter, criterio => criterio.tp_criterio,
      );
    },
    organizacaoGetter(value) {
      this.organizacao = value;
      this.obterMunicipios(value.endereco.co_ibge);
    },
    segmentosGetter(value) {
      this.listaSegmentos = value;
    },
    estadosGetter(value) {
      this.listaUF = value;
    },
    municipiosGetter(value) {
      this.listaMunicipios = value;
    },
  },
  mounted() {
    this.organizacao = this.organizacaoGetter;
    this.obterSegmentos();
    this.obterCriterios();
    this.listaUF = this.estadosGetter;
    if (this.listaUF.length < 1) {
      this.obterEstados();
    }
    this.listaMunicipios = this.municipiosGetter;
    if (this.listaMunicipios.length < 1 && Object.keys(this.organizacaoGetter).length > 0) {
      this.obterMunicipios(this.organizacaoGetter.endereco.co_ibge);
    }
    this.listaSegmentos = this.segmentosGetter;
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
      obterCriterios: 'organizacao/obterCriterios',
      obterSegmentos: 'organizacao/obterSegmentos',
    }),

  },

};
</script>
