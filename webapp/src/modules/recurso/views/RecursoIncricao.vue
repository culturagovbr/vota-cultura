<template>
  <v-container>
    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>Inscrição - Conselho de Cultura</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-stepper v-model="etapaFormulario">
          <v-stepper-header>
            <v-stepper-step
              :complete="etapaFormulario > 1"
              step="1"
            >
              Conselho de Cultura
            </v-stepper-step>
            <v-divider />
            <v-stepper-step
              :complete="etapaFormulario > 2"
              step="2"
            >
              Representante
            </v-stepper-step>

            <v-divider />

            <v-stepper-step
              :complete="etapaFormulario > 3"
              step="3"
            >
              Anexos
            </v-stepper-step>
          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content step="1">
              <v-form
                ref="form_conselho"
                v-model="valid_conselho"
                lazy-validation
              >
                <v-card flat>
                  <v-container
                    fluid
                    grid-list-xl
                  >
                    <v-layout>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-radio-group
                          v-model="conselho.tp_governamental"
                          row
                          :rules="[rules.required]"
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
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-text-field
                          v-model="conselho.nu_cnpj"
                          label="*CNPJ do Orgão Gestor do Conselho"
                          append-icon="people"
                          placeholder="99.999.999/9999-99"
                          :error-messages="nomeConselhoError"
                          mask="##.###.###/####-##"
                          :rules="[rules.required, rules.cnpjMin]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-text-field
                          v-model="conselho.no_orgao_gestor"
                          label="*Nome do órgão gestor de cultura"
                          append-icon="people_outline"
                          :disabled="true"
                          :rules="[rules.cnpjInvalido]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.no_conselho"
                          label="*Nome do conselho de cultura"
                          append-icon="people"
                          counter
                          maxlength="250"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm2
                      >
                        <v-text-field
                          v-model="conselho.nu_telefone"
                          label="*Telefone do Conselho"
                          append-icon="phone"
                          placeholder="(99) 99999-9999"
                          mask="(##) #####-####"
                          :rules="[rules.required, rules.phoneMin]"
                          required
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.ds_email"
                          data-vv-name="email"
                          label="*E-mail do Conselho"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          counter
                          maxlength="100"
                          :rules="[rules.required, rules.email]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.ds_email_confirmacao"
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          counter
                          maxlength="100"
                          :rules="[
                            rules.required,
                            rules.email,
                            rules.emailMatch(
                              conselho.ds_email,
                              conselho.ds_email_confirmacao
                            )
                          ]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.ds_sitio_eletronico"
                          label="Sítio eletrônico do conselho"
                          append-icon="public"
                          counter
                          maxlength="250"
                          :rules="[rules.url]"
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-text-field
                          v-model="conselho.endereco.nu_cep"
                          label="*CEP"
                          append-icon="my_location"
                          placeholder="99999-999"
                          mask="#####-###"
                          :rules="[rules.required, rules.cepMin]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-text-field
                          v-model="conselho.endereco.ds_logradouro"
                          label="*Logradouro"
                          append-icon="place"
                          counter
                          maxlength="250"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-text-field
                          v-model="conselho.endereco.ds_complemento"
                          counter
                          maxlength="250"
                          label="Complemento"
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-select
                          v-model="conselho.endereco.co_ibge"
                          :items="listaUF"
                          label="*Unidade da federação da sede"
                          append-icon="place"
                          item-value="co_ibge"
                          item-text="no_uf"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm5
                      >
                        <v-select
                          v-model="conselho.endereco.co_municipio"
                          :items="listaMunicipios"
                          label="*Cidade"
                          append-icon="place"
                          item-value="co_municipio"
                          item-text="no_municipio"
                          :rules="[rules.required]"
                          :disabled="conselho.endereco.co_ibge < 1 || conselho.endereco.co_ibge == null"
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>

              <v-btn
                to="/inicio"
                flat
              >
                Cancelar
              </v-btn>
              <v-btn
                :disabled="!valid_conselho"
                color="primary"
                @click="validarIrProximaEtapa('form_conselho')"
              >
                Próximo
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="2">
              <v-form
                ref="form_representante"
                v-model="valid_representante"
                lazy-validation
              >
                <v-card flat>
                  <v-container
                    fluid
                    grid-list-xl
                  >
                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm3
                      >
                        <v-text-field
                          v-model="conselho.representante.nu_cpf"
                          label="*CPF do representante"
                          append-icon="person"
                          placeholder="999.999.999.99"
                          mask="###.###.###.##"
                          :error-messages="nomeRepresentante"
                          :rules="[rules.required, rules.cpfMin]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.representante.nu_telefone"
                          label="*Celular do representante"
                          append-icon="phone"
                          placeholder="(99) 99999-9999"
                          mask="(##) #####-####"
                          :rules="[rules.required, rules.phoneMin]"
                          required
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm8
                      >
                        <v-text-field
                          v-model="conselho.representante.no_nome"
                          :disabled="true"
                          label="*Nome do representante"
                          append-icon="perm_identity"
                          :error-messages="nomeRepresentante"
                          :rules="[rules.cpfInvalido]"
                          required
                        />
                      </v-flex>
                      <v-flex
                        xs12
                        sm4
                      >
                        <v-text-field
                          v-model="conselho.representante.nu_rg"
                          label="*RG do representante"
                          append-icon="person"
                          mask="###########"
                          counter
                          maxlength="11"
                          :rules="[rules.required]"
                          required
                        />
                      </v-flex>
                    </v-layout>

                    <v-layout
                      wrap
                      align-center
                    >
                      <v-flex
                        xs12
                        sm6
                      >
                        <v-text-field
                          v-model="conselho.representante.ds_email"
                          label="*E-mail do representante"
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
                        sm6
                      >
                        <v-text-field
                          v-model="conselho.representante.ds_email_confirmation"
                          label="*Confirmar e-mail"
                          append-icon="mail"
                          placeholder="email@exemplo.com"
                          :rules="[
                            rules.required,
                            rules.email,
                            rules.emailMatch(
                              conselho.representante.ds_email,
                              conselho.representante.ds_email_confirmation
                            )
                          ]"
                          required
                        />
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn
                flat
                @click="voltarEtapaAnterior"
              >
                Anterior
              </v-btn>
              <v-btn
                :disabled="!valid_representante"
                color="primary"
                @click="validarIrProximaEtapa('form_representante')"
              >
                Próximo
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
              <v-form
                ref="form_anexo"
                v-model="valid_anexo"
                lazy-validation
              >
                <v-card flat>
                  <v-container
                    fluid
                    grid-list-xl
                  >
                    <v-layout
                      align-center
                      justify-center
                    >
                      <v-flex sm5>
                        <div class="subheading mb-4">
                          Envie os documentos abaixo (somente formato PDF):
                        </div>
                      </v-flex>
                    </v-layout>
                    <v-layout
                      align-center
                      justify-center
                      class="mb-4"
                      wrap
                    >
                      <v-flex sm3>
                        <v-card
                          max-width="344"
                          min-height="230"
                          class="mx-auto"
                        >
                          <v-card-title class="subheading mb-1 justify-center">
                            Ato normativo que constituiu o conselho*
                          </v-card-title>
                          <v-card-text>
                            <file v-model="ato_normativo_conselho" />
                          </v-card-text>
                        </v-card>
                      </v-flex>
                      <v-flex sm3>
                        <v-card
                          max-width="344"
                          min-height="230"
                          class="mx-auto"
                        >
                          <v-card-title class="subheading mb-1 justify-center">
                            Ata da última reunião do conselho*
                          </v-card-title>
                          <v-card-text>
                            <file v-model="ata_reuniao_conselho" />
                          </v-card-text>
                        </v-card>
                      </v-flex>
                      <v-flex sm3>
                        <v-card
                          max-width="344"
                          class="mx-auto"
                        >
                          <v-card-title class="subheading mb-1 justify-center">
                            Documento de identificação do representante com CPF*
                          </v-card-title>
                          <v-card-text>
                            <file v-model="documento_identificacao_responsavel" />
                          </v-card-text>
                        </v-card>
                      </v-flex>
                      <v-flex
                        v-if="conselho.tp_governamental === 'c'"
                        sm3
                      >
                        <v-card
                          max-width="344"
                          class="mx-auto"
                        >
                          <v-card-title class="subheading mb-1 justify-center">
                            Declaração de Impossibilidade de Participação do Conselho Estadual de Cultura*
                          </v-card-title>
                          <v-card-text>
                            <file v-model="declaracao_ciencia_orgao_gestor" />
                          </v-card-text>
                        </v-card>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-form>
              <v-btn
                flat
                @click="voltarEtapaAnterior"
              >
                Anterior
              </v-btn>
              <v-btn
                color="primary"
                @click="salvar"
              >
                Enviar
              </v-btn>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import File from '@/core/components/upload/File';
import { eventHub } from '@/event';
import Validate from '../../shared/util/validate';

export default {
  components: { File },
  data: () => ({
    nomeConselhoError: '',
    nomeRepresentante: '',
    etapaFormulario: 1,
    listaUF: [],
    listaMunicipios: [],
    valid_conselho: false,
    valid_representante: false,
    valid_anexo: false,
    conselho: {
      no_conselho: '',
      st_inscricao: 'e',
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
        no_nome: '',
        nu_rg: '',
        nu_cpf: '',
        nu_telefone: '',
        ds_email_confirmation: '',
      },
      ds_sitio_eletronico: '',
      anexos: [],
    },
    ata_reuniao_conselho: {},
    ato_normativo_conselho: {},
    documento_identificacao_responsavel: {},
    declaracao_ciencia_orgao_gestor: {},
    steps: [
      {
        title: 'Conselho de Cultura',
        id: 1,
      },
      {
        title: 'Representante',
        id: 2,
      },
      {
        title: 'Anexos',
        id: 3,
      },
    ],
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
    'conselho.endereco.co_ibge': function (coIBGE) {
      this.obterMunicipios(coIBGE);
    },
    'conselho.nu_cnpj': function (value) {
      const self = this;
      self.conselho.no_orgao_gestor = '';
      this.nomeConselhoError = 'CNPJ inválido';
      if (value.length === 14 && Validate.isCnpjValido(value)) {
        this.consultarCNPJ(value).then((response) => {
          const { data } = response.data;
          self.conselho.no_orgao_gestor = data.nmRazaoSocial;
        });
        this.nomeConselhoError = '';
      }
    },
    'conselho.representante.nu_cpf': function (value) {
      const self = this;
      self.conselho.representante.no_nome = '';
      this.nomeRepresentante = 'CPF inválido';
      if (value.length === 11 && Validate.isCpfValido(value)) {
        this.consultarCPF(value).then((response) => {
          const { data } = response.data;
          self.conselho.representante.no_nome = data.nmPessoaFisica;
        });
        this.nomeRepresentante = '';
      }
    },
  },
  mounted() {
    if (Object.keys(this.conselhoGetter).length > 0) {
      this.conselho = this.conselhoGetter;
    }
    this.obterEstados();
  },
  computed: {
    ...mapGetters({
      estadosGetter: 'localidade/estados',
      municipiosGetter: 'localidade/municipios',
      conselhoGetter: 'conselho/conselho',
    }),
  },
  methods: {
    ...mapActions({
      obterEstados: 'localidade/obterEstados',
      obterMunicipios: 'localidade/obterMunicipios',
      confirmarConselho: 'conselho/confirmarConselho',
      consultarCNPJ: 'pessoa/consultarCNPJ',
      consultarCPF: 'pessoa/consultarCPF',
    }),
    validarIrProximaEtapa(formRef) {
      if (this.$refs[formRef].validate()) {
        this.etapaFormulario = this.etapaFormulario + 1;
      }
    },
    salvar() {
      let erro = false;
      this.conselho.anexos = [];
      const anexos = [
        'ata_reuniao_conselho',
        'ato_normativo_conselho',
        'documento_identificacao_responsavel',
        'declaracao_ciencia_orgao_gestor',
      ];
      if (this.conselho.tp_governamental !== 'c') {
        const index = anexos.indexOf('declaracao_ciencia_orgao_gestor');
        if (index > -1) {
          anexos.splice(index, 1);
        }
      }
      try {
        anexos.forEach((nomeAnexo) => {
          this.conselho.anexos.push({
            tp_arquivo: nomeAnexo,
            no_extensao: this[nomeAnexo].fileExtension,
            no_mime_type: this[nomeAnexo].fileType,
            no_arquivo: this[nomeAnexo].filename,
            arquivoCodificado: this[nomeAnexo].getFileEncodeBase64String(),
          });
        });
      } catch (e) {
        erro = true;
        eventHub.$emit('eventoErro', 'Todos os anexos são obrigatórios!');
      }
      if (!erro) {
        this.confirmarConselho(this.conselho).then(() => {
          this.$router.push('/conselho/revisao-conselho');
        });
      }
    },
    voltarEtapaAnterior() {
      this.etapaFormulario = this.etapaFormulario - 1;
    },
  },
};
</script>
