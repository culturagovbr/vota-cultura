<template>
  <v-container fluid>
    <v-card>
      <v-toolbar
        dark
        color="primary">
        <v-toolbar-title>Inscrição - Organização ou Entidade Cultural</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-stepper v-model="etapaFormulario">
          <v-stepper-header>
            <v-stepper-step
              :complete="etapaFormulario > 1"
              step="1">
              Organização ou Entidade Cultural
            </v-stepper-step>

            <v-divider/>

            <v-stepper-step
              :complete="etapaFormulario > 2"
              step="2">
              Representante
            </v-stepper-step>

            <v-divider/>

            <v-stepper-step
              :complete="etapaFormulario > 3"
              step="3">
              Segmento
            </v-stepper-step>

            <v-divider/>

            <v-stepper-step
              :complete="etapaFormulario > 4"
              step="4">
              Critérios
            </v-stepper-step>

            <v-divider/>

            <!--<v-stepper-step-->
              <!--:complete="etapaFormulario > 5"-->
              <!--step="5">-->
              <!--Anexo-->
            <!--</v-stepper-step>-->
          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content step="1">
              <v-form
                ref="form_dados_entidade"
                v-model="valid_dados_entidade"
                lazy-validation>
                <v-card flat>
                  <v-container
                    fluid
                    grid-list-xl>
                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm5>
                        <v-text-field
                          v-model="organizacao.nu_cnpj"
                          label="*CNPJ"
                          append-icon="people"
                          placeholder="99.999.999/9999-99"
                          :error-messages="nomeOrganizacaoError"
                          mask="##.###.###/####-##"
                          :rules="[rules.required, rules.cnpjMin]"
                          required/>
                      </v-flex>
                      <v-flex
                        xs12
                        sm5>
                        <v-text-field
                          v-model="organizacao.no_organizacao"
                          label="*Nome da Organização/Entidade"
                          append-icon="perm_identity"
                          :disabled="true"
                          :error-messages="nomeOrganizacaoError"
                          :rules="[rules.cnpjInvalido]"
                          required/>
                      </v-flex>

                      <v-flex
                        xs12
                        sm2>
                        <v-text-field
                          v-model="organizacao.nu_telefone"
                          label="*Telefone"
                          append-icon="phone"
                          placeholder="(99) 99999-9999"
                          mask="(##) #####-####"
                          :rules="[rules.required, rules.phoneMin]"
                          required/>

                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm4>
                        <v-text-field
                          v-model="organizacao.ds_email"
                          data-vv-name="email"
                          label="*E-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email]"
                          counter
                          maxlength="100"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4>
                        <v-text-field
                          v-model="organizacao.ds_email_confirmacao"
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email, rules.emailMatch(organizacao.ds_email, organizacao.ds_email_confirmacao)]"
                          counter
                          maxlength="100"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4>
                        <v-text-field
                          v-model="organizacao.ds_sitio_eletronico"
                          label="Sítio eletrônico da Organização/Entidade"
                          append-icon="public"
                          counter
                          maxlength="250"
                          :rules="[rules.url]"
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm3>
                        <v-text-field
                          v-model="organizacao.endereco.nu_cep"
                          label="*CEP"
                          append-icon="my_location"
                          placeholder="99999-999"
                          mask="#####-###"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6>
                        <v-text-field
                          v-model="organizacao.endereco.ds_logradouro"
                          label="*Logradouro"
                          append-icon="place"
                          :rules="[rules.required]"
                          counter
                          maxlength="250"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm3>
                        <v-text-field
                          v-model="organizacao.endereco.ds_complemento"
                          counter
                          maxlength="250"
                          label="Complemento"
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm3>
                        <v-select
                          v-model="organizacao.endereco.co_ibge"
                          :items="listaUF"
                          label="*Unidade da Federação da sede"
                          append-icon="place"
                          item-value="co_ibge"
                          item-text="no_uf"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm5>
                        <v-select
                          v-model="organizacao.endereco.co_municipio"
                          :items="listaMunicipios"
                          label="*Cidade"
                          append-icon="place"
                          item-value="co_municipio"
                          item-text="no_municipio"
                          :rules="[rules.required]"
                          :disabled="organizacao.endereco.co_ibge < 1 || organizacao.endereco.co_ibge == null"
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn
                to="/inicio"
                flat>
                Cancelar
              </v-btn>
              <v-btn
                color="primary"
                @click="validarIrProximaEtapa('form_dados_entidade')">
                Próximo
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="2">
              <v-form
                ref="form_representante"
                v-model="valid_representante"
                lazy-validation>
                <v-card flat>
                  <v-container
                    fluid
                    grid-list-xl>
                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm3>
                        <v-text-field
                          v-model="organizacao.representante.nu_cpf"
                          label="*CPF do representante"
                          append-icon="person"
                          placeholder="999.999.999.99"
                          mask="###.###.###.##"
                          :rules="[rules.required, rules.cpfMin]"
                          required/>
                      </v-flex>
                      <v-flex
                        xs12
                        sm4>
                        <v-text-field
                          v-model="organizacao.representante.nu_telefone"
                          label="*Celular do representante"
                          append-icon="phone"
                          placeholder="(99) 99999-9999"
                          mask="(##) #####-####"
                          :rules="[rules.required, rules.phoneMin]"
                          required />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm8>
                        <v-text-field
                          v-model="organizacao.representante.no_pessoa"
                          label="*Nome do representante"
                          :disabled="true"
                          :error-messages="nomeRepresentante"
                          append-icon="perm_identity"
                          :rules="[rules.cnpjInvalido]"
                          required/>
                      </v-flex>
                      <v-flex
                        xs12
                        sm4>
                        <v-text-field
                          v-model="organizacao.representante.nu_rg"
                          label="*RG do representante"
                          append-icon="person"
                          mask="#########"
                          counter
                          maxlength="11"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm6>
                        <v-text-field
                          v-model="organizacao.representante.ds_email"
                          label="*E-mail do representante"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email]"
                          counter
                          maxlength="250"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6>
                        <v-text-field
                          v-model="organizacao.representante.ds_email_confirmation"
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[rules.required, rules.email, rules.emailMatch(organizacao.representante.ds_email, organizacao.representante.ds_email_confirmation)]"
                          counter
                          maxlength="250"
                          required
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn flat @click="voltarEtapaAnterior">
                Anterior
              </v-btn>
              <v-btn :disabled="!valid_representante"
                     color="primary"
                     @click="validarIrProximaEtapa('form_representante')">
                Próximo
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
              <v-form ref="form_segmento"
                      v-model="valid_segmento"
                      lazy-validation>
                <v-card flat>
                  <v-container fluid grid-list-xl>
                    <v-layout wrap align-center>
                      <v-flex xs12 sm6>
                        <v-radio-group
                          v-model="organizacao.co_segmento"
                          label="*Informe o segmento no qual pretende concorrer">
                          <v-radio
                            v-for="(segmento, i) in listaSegmentos"
                            :key="i"
                            :label="segmento.ds_detalhamento"
                            :value="segmento.co_segmento"
                          />
                        </v-radio-group>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn flat
                     @click="voltarEtapaAnterior">
                Anterior
              </v-btn>
              <v-btn :disabled="!valid_segmento"
                     color="primary"
                     @click="validarIrProximaEtapa('form_segmento')">
                Próximo
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="4">
              <v-form ref="form_criterio"
                      v-model="valid_criterio"
                      lazy-validation>
                <v-card flat>
                  <v-container
                    fluid
                    grid-list-xl>
                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm6>

                          <v-select
                            v-model="organizacao.criterios.abrangencia_nacional"
                            :items="listaCriterios.abrangencia_nacional"
                            item-value="co_criterio"
                            item-text="ds_detalhamento"
                            label="*Abrangência Nacional"
                            :rules="[rules.required]"
                            required
                            box
                            hint="Atividades ou projetos culturais em, no mínimo, 5 estados de 2
                            macrorregiões brasileiras, a partir de 2016."
                            persistent-hint
                            >
                          </v-select>


                      </v-flex>
                      <v-flex
                        xs12
                        sm6>
                        <v-select
                          v-model="organizacao.criterios.abrangencia_estadual"
                          :items="listaCriterios.abrangencia_estadual"
                          item-value="co_criterio"
                          item-text="ds_detalhamento"
                          label="*Abrangência Estadual"
                          :rules="[rules.required]"
                          required
                          box
                          hint="Atividades ou projetos culturais em, no mínimo, 5 estados, a partir de 2016."
                          persistent-hint
                          placeholder="Selecione"/>
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm6>
                        <v-select
                          v-model="organizacao.criterios.tempo_funcionamento"
                          :items="listaCriterios.tempo_funcionamento"
                          item-value="co_criterio"
                          item-text="ds_detalhamento"
                          label="*Tempo de Funcionamento"
                          :rules="[rules.required]"
                          required
                          placeholder="Selecione"
                          box
                          hint="A partir da data de fundação."
                          persistent-hint
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6>
                        <v-select
                          v-model="organizacao.criterios.nu_associados_filiados"
                          :items="listaCriterios.nu_associados_filiados"
                          item-value="co_criterio"
                          item-text="ds_detalhamento"
                          label="*Nº de Associados ou Filiados"
                          :rules="[rules.required]"
                          required
                          placeholder="Selecione"
                          box
                          hint="Lista de associados ou filiados atestada pelo dirigente da organização ou entidade cultural."
                          persistent-hint
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm6>
                        <v-select
                          v-model="organizacao.criterios.nu_atividades"
                          :items="listaCriterios.nu_atividades"
                          item-value="co_criterio"
                          item-text="ds_detalhamento"
                          label="*Nº Atividades/projetos realizados no campo cultural a partir de 2016"
                          :rules="[rules.required]"
                          required
                          placeholder="Selecione"
                          box
                          hint="Comprovados por relatório de atividades e portfólio."
                          persistent-hint
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6>
                        <v-select
                          v-model="organizacao.criterios.participacao_instancias"
                          :items="listaCriterios.participacao_instancias"
                          item-value="co_criterio"
                          item-text="ds_detalhamento"
                          label="Participação em instâncias de formulação de política cultural"
                          placeholder="Selecione"
                          box
                          hint="Na qualidade de conselheiro ou membro, comprovado por documento de designação ou de posse."
                          persistent-hint
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center>
                      <v-flex
                        xs12
                        sm6>
                        <v-select
                          v-model="organizacao.criterios.pesquisa_producao"
                          :items="listaCriterios.pesquisa_producao"
                          item-value="co_criterio"
                          item-text="ds_detalhamento"
                          label="Projetos na área de pesquisa ou produção do conhecimento no campo da cultura a partir de 2016"
                          placeholder="Selecione"
                          box
                          hint="Publicações, pesquisa de campo, artigos científicos."
                          persistent-hint
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn flat @click="voltarEtapaAnterior">
                Anterior
              </v-btn>
              <v-btn :disabled="!valid_criterio"
                     color="primary"
                     @click="salvar">
                Próximo
              </v-btn>
            </v-stepper-content>

          </v-stepper-items>
        </v-stepper>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';
  import _ from 'lodash';
  import File from '@/core/components/upload/File';
  import {eventHub} from '@/event';
  import Validate from '../../shared/util/validate';

export default {
  name: 'Organizacao',
  components: { File },
  data: () => ({
    nomeOrganizacaoError: '',
    nomeRepresentante: '',
    mascaraTelefone: '(##) #####-####',
    valid_dados_entidade: false,
    valid_segmento: false,
    valid_criterio: false,
    valid_representante: false,
    etapaFormulario: 1,
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
    // declaracao_representante_legal: {},
    // documento_identificacao_responsavel: {},
    headers: [
      {
        text: 'Tipo',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Arquivo',
        align: 'center',
        sortable: false,
      },
      {
        sortable: false,
      },
    ],
    rules: {
      required: v => !!v || 'Campo não preenchido',
      cnpjInvalido: v => !!v || 'CNPJ não encontrado',
      cpfInvalido: v => !!v || 'CPF não encontrado',
      phoneMin: v => (v && v.length >= 9) || 'Mínimo de 9 caracteres',
      cnpjMin: v => (v && v.length === 14) || 'Mínimo de 14 caracteres',
      cpfMin: v => (v && v.length === 11) || 'Mínimo de 11 caracteres',
      cepMin: v => (v && v.length === 8) || 'Mínimo de 8 caracteres',
      email: (v) => {
        // eslint-disable-next-line
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(v) || 'E-mail invalido';
      },
      url: (v) => {
        // eslint-disable-next-line
        const pattern = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/;
        if (v) return pattern.test(v) || 'Sítio invalido';
        return true;
      },
      emailMatch: (email, emailConfirmation) => email === emailConfirmation || 'Os emails não correspondem',
    },
  }),
  watch: {
    estadosGetter() {
      this.listaUF = this.estadosGetter;
    },
    municipiosGetter() {
      this.listaMunicipios = this.municipiosGetter;
    },
    segmentosGetter() {
      this.listaSegmentos = this.segmentosGetter;
    },
    'organizacao.endereco.co_ibge': function (coIBGE) {
      this.organizacao.endereco.co_municipio = '';
      this.obterMunicipios(coIBGE);
    },
    'organizacao.nu_cnpj': function (value) {
      let self = this;
      self.organizacao.no_organizacao = '';
      this.nomeOrganizacaoError = 'CNPJ inválido';
      if (value.length === 14 && Validate.isCnpjValido(value)) {
        this.consultarCNPJ(value).then((response) => {
          const { data } = response.data;
          self.organizacao.no_organizacao = data.nmRazaoSocial;
        });
        this.nomeOrganizacaoError = '';
      }
    },
    'organizacao.representante.nu_cpf': function (value) {
      let self = this;
      self.organizacao.representante.no_pessoa = '';
      this.nomeRepresentante = 'CPF inválido';
      if (value.length === 11 && Validate.isCpfValido(value)) {
        this.consultarCPF(value).then((response) => {
          const {data} = response.data;
          self.organizacao.representante.no_pessoa = data.nmPessoaFisica;
        });
        this.nomeRepresentante = '';
      }
    },
    criteriosGetter() {
      this.listaCriterios = _.groupBy(
        this.criteriosGetter, criterio => criterio.tp_criterio,
      );

      const participacaoInstancias = [{
        co_criterio: '',
        ds_detalhamento: 'Selecione',
        tp_criterio: 'participacao_instancias',
      }];
      this.listaCriterios.participacao_instancias.forEach((criterio) => {
        participacaoInstancias.push(criterio);
      });
      this.listaCriterios.participacao_instancias = participacaoInstancias;

      const pesquisaProducao = [{
        co_criterio: '',
        ds_detalhamento: 'Selecione',
        tp_criterio: 'pesquisa_producao',
      }];
      this.listaCriterios.pesquisa_producao.forEach((criterio) => {
        pesquisaProducao.push(criterio);
      });
      this.listaCriterios.pesquisa_producao = pesquisaProducao;

    },
  },
  mounted() {
    if (Object.keys(this.organizacaoGetter).length > 0) {
      this.organizacao = this.organizacaoGetter;
      this.obterMunicipios(this.organizacao.endereco.co_municipio);
    }
    this.obterEstados();
    this.obterSegmentos();
    this.obterCriterios();
  },
  computed: {
    ...mapGetters({
      estadosGetter: 'localidade/estados',
      municipiosGetter: 'localidade/municipios',
      segmentosGetter: 'organizacao/segmentos',
      criteriosGetter: 'organizacao/criterios',
      organizacaoGetter: 'organizacao/organizacao',
    }),
  },
  methods: {
    ...mapActions({
      obterEstados: 'localidade/obterEstados',
      obterMunicipios: 'localidade/obterMunicipios',
      obterCriterios: 'organizacao/obterCriterios',
      obterSegmentos: 'organizacao/obterSegmentos',
      confirmarOrganizacao: 'organizacao/confirmarOrganizacao',
      consultarCNPJ: 'pessoa/consultarCNPJ',
      consultarCPF: 'pessoa/consultarCPF',
    }),
    validarIrProximaEtapa(formRef) {
      if (this.$refs[formRef].validate()) {
        this.etapaFormulario = this.etapaFormulario + 1;
      }
    },
    voltarEtapaAnterior() {
      this.etapaFormulario = this.etapaFormulario - 1;
    },
    reset() {
      this.$refs.form.reset();
    },
    salvar() {
      if (this.$refs.form_criterio.validate()) {
        this.confirmarOrganizacao(this.organizacao).then(() => {
          this.$router.push('/organizacao/revisao-organizacao');
        });
      }
    },
  },
};
</script>
