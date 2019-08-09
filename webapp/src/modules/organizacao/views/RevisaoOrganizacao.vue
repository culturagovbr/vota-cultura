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
            <v-container v-if="Object.keys(organizacaoGetter).length > 0">
              <!--<v-container>-->
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
                    label="Segmento"
                    disabled>
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

              <v-checkbox
                v-model="confirmacaoDadosdeInscricao"
                :rules="[v => !!v || 'É necessário concordar para enviar!']"
                label=" Declaro ser representante da organização ou entidade cultural inscrita neste edital e designado (a) para o fornecimento das informações solicitadas e que assumo total responsabilidade pela veracidade das informações apresentadas.

Declaro estar ciente de que qualquer inexatidão nos itens informados me sujeitará às penalidades previstas no Art. 299 do Código Penal brasileiro, sem prejuízo de outras medidas administrativas e legais cabíveis."
              />

              <v-layout
                wrap
                align-center
              >
                <v-flex offset-xs4>
                  <v-btn to="/organizacao/inscricao">
                    Cancelar
                  </v-btn>
                  <v-btn
                    :disabled="!confirmacaoDadosdeInscricao"
                    color="primary"
                    @click="abrirDialogo"
                  >
                    Confirmar
                  </v-btn>
                </v-flex>
              </v-layout>
            </v-container>
            <v-container v-else>
              <v-layout>
                <v-flex>
                  <v-alert
                    type="error"
                    :value="true"
                  >
                    É necessário preencher as informações do cadastro.
                  </v-alert>
                  <div class="mb-6">
                    <v-btn to="/organizacao/inscricao">
                      Voltar
                    </v-btn>
                  </div>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
    <v-layout justify-center>
      <v-dialog
        v-model="dialog"
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
            <v-spacer/>

            <v-btn
              color="red darken-1"
              text
              flat
              @click="fecharDialogo">
              Não
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              flat
              @click="salvar">
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-container>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';
  import _ from 'lodash';
  import {eventHub} from '@/event';

  export default {
    name: 'RevisaoOrganizacao',
    data: () => ({
      confirmacaoDadosdeInscricao: false,
      confirmacaoDadosDeInscricao: false,
      dialog: false,
      listaUF: [],
      listaSegmentos: [],
      listaMunicipios: [],
      listaCriterios: [],
      organizacao: {
        st_inscricao: 'e',
        co_segmento: '',
        no_organizacao: '',
        ds_email: '',
        ds_email_confirmacao: '',
        nu_telefone: '',
        nu_cnpj: '',
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
        criterios: {
          abrangencia_estadual: '',
          abrangencia_nacional: '',
          nu_associados_filiados: '',
          nu_atividades: '',
          participacao_instancias: '',
          pesquisa_producao: '',
          tempo_funcionamento: '',
        },
      },
    }),
    computed: {
      ...mapGetters({
        estadosGetter: 'localidade/estados',
        municipiosGetter: 'localidade/municipios',
        segmentosGetter: 'organizacao/segmentos',
        criteriosGetter: 'organizacao/criterios',
        organizacaoGetter: 'organizacao/organizacao',
      }),
    },
    watch: {
      criteriosGetter() {
        const criterios = _.groupBy(
          this.criteriosGetter, criterio => criterio.tp_criterio,
        );
        this.listaCriterios = criterios;
      },
      organizacaoGetter(value) {
        this.organizacao = value;
        this.obterMunicipios(this.organizacao.co_ibge);
      },
    },
    methods: {
      ...mapActions({
        obterEstados: 'localidade/obterEstados',
        obterMunicipios: 'localidade/obterMunicipios',
        obterCriterios: 'organizacao/obterCriterios',
        obterSegmentos: 'organizacao/obterSegmentos',
        enviarDadosOrganizacao: 'organizacao/enviarDadosOrganizacao',
      }),
      salvar() {
        this.enviarDadosOrganizacao(this.organizacaoGetter).then(() => {
          eventHub.$emit(
            'eventoSucesso',
            'Enviado com sucesso! Um email será enviado com os dados da inscrição.',
          );

          this.organizacao = Object.assign({});
          this.$router.push('/');
        }).catch(() => {
          eventHub.$emit(
            'eventoErro',
            'Houve algum erro ao enviar a sua inscrição.',
          );
          this.$router.push('/');
        }).finally(() => {
          console.log(this.organizacao);
          // this.fecharDialogo();
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
      this.obterSegmentos();
      this.obterCriterios();
      this.listaUF = this.estadosGetter;
      this.listaMunicipios = this.municipiosGetter;
      this.listaSegmentos = this.segmentosGetter;
      this.organizacao = this.organizacaoGetter;
    },
  };
</script>
