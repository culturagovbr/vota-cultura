<template>
  <v-container>
    <v-layout wrap>
      <v-flex
        offset-xs3
        xs6
      >
        <v-card
          max-width="900"
        >
          <v-toolbar
            dark
            color="primary"
          >
            <v-toolbar-title>Confirmação dos dados</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-container>
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
                    v-model="organizacao.endereco.ds_complementos"
                    label="Complemento"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    v-model="organizacao.co_ibge"
                    :items="listaUF"
                    label="Unidade da Federação da sede"
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
                    v-model="organizacao.representante.no_pessoa"
                    label="Nome do Responsável"
                    append-icon="perm_identity"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.representante.nu_telefone"
                    label="Celular do Responsável"
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
                    placeholder="999.999.999.99"
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
                    label="E-mail do Responsável"
                    append-icon="mail"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-radio-group
                    v-model="organizacao.co_segmento"
                    label="Segmento">
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
                    :rules="[rules.required]"
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
                    label="*Abrangência Estadual"
                    :rules="[rules.required]"
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
                    label="*Tempo de Funcionamento"
                    :rules="[rules.required]"
                    required
                    placeholder="Selecione"
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
                    label="*Nº de Associados ou Filiados"
                    :rules="[rules.required]"
                    required
                    placeholder="Selecione"
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
                    label="*Nº Atividades/projetos realizados no campo cultural a partir de 2016"
                    :rules="[rules.required]"
                    required
                    placeholder="Selecione"
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
                    placeholder="Selecione"
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    v-model="organizacao.criterios.abrangencia_campo_cultural"
                    :items="listaCriterios.abrangencia_campo_cultural"
                    item-value="co_criterio"
                    item-text="ds_detalhamento"
                    label="*Abrangência de projetos realizados no campo cultural a partir de 2016"
                    :rules="[rules.required]"
                    required
                    placeholder="Selecione"
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
                    placeholder="Selecione"
                  />
                </v-flex>
              </v-layout>

              <v-checkbox
                :rules="[v => !!v || 'É necessário concordar para enviar!']"
                label=" Declaro ser representante da organização ou entidade cultural inscrita neste edital e designado (a) para o fornecimento das informações solicitadas e que assumo total responsabilidade pela veracidade das informações apresentadas.

Declaro estar ciente de que qualquer inexatidão nos itens informados me sujeitará às penalidades previstas no Art. 299 do Código Penal brasileiro, sem prejuízo de outras medidas administrativas e legais cabíveis."
                required
              />

              <v-layout
                wrap
                align-center
              >
                <v-flex offset-xs4>
                  <v-btn to="/organizacao/inscricao">
                    Cancelar
                  </v-btn>
                  <v-btn color="primary">
                    Confirmar
                  </v-btn>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { eventHub } from '@/event';

export default {
  name: 'RevisaoConselho',
  data: () => ({
    confirmacaoDadosDeInscricao: false,
    dialog: false,
    listaUF: [],
    conselho: {
      no_orgao_gestor: '',
      ds_email: '',
      ds_email_confirmacao: '',
      nu_telefone: '',
      nu_cnpj: '',
      tp_governamental: '',
      endereco: {
        co_ibge: '',
        ds_complemento: '',
        nu_cep: '',
        ds_logradouro: '',
        co_municipio: '',
      },
      representante: {
        ds_email: '',
        no_pessoa: '',
        nu_rg: '',
        nu_cpf: '',
        nu_telefone: '',
        ds_email_confirmation: '',
      },
      ds_sitio_eletronico: '',
      anexos: [],
    },
  }),
  computed: {
    ...mapGetters({
      conselhoGetter: 'conselho/conselho',
      estadosGetter: 'localidade/estados',
    }),
  },
  watch: {
    conselhoGetter(value) {
      this.conselho = value;
    },
  },
  methods: {

    ...mapActions({
      obterEstados: 'localidade/obterEstados',
      obterMunicipios: 'localidade/obterMunicipios',
      obterCriterios: 'organizacao/obterCriterios',
      obterSegmentos: 'organizacao/obterSegmentos',
      confirmarOrganizacao: 'organizacao/confirmarOrganizacao',
      // enviarDadosOrganizacao: 'conselho/enviarDadosOrganizacao',
    }),
    salvar() {
      this.enviarDadosConselho(this.conselhoGetter).then(() => {
        eventHub.$emit(
          'eventoSucesso',
          'Enviado com sucesso! Um email será enviado com os dados da inscrição.',
        );
        this.$router.push('/');
      }).catch(() => {
        eventHub.$emit(
          'eventoErro',
          'Houve algum erro ao enviar a sua inscrição.',
        );
        this.$router.push('/');
      }).finally(() => {
        this.fecharDialogo();
      });
    },
    abrirDialogo() {
      this.dialog = true;
    },
    fecharDialogo() {
      this.dialog = false;
    },
  },
  mounted() {
    this.listaUF = this.estadosGetter;
    this.organizacao = this.organizacaoGetter;
  },
};
</script>
