<template>
  <v-container>
    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>Enviar documentação</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-form
          ref="form_anexo"
          v-model="organizacao.anexos.valid_anexo"
          lazy-validation
        >
          <v-container
            fluid
            grid-list-xl
          >
            <v-layout
              align-center
              justify-center
              class="mb-4"
              wrap
            >
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    a.    Cópia de documento de identificação do representante legal responsável pela inscrição da organização ou entidade cultural (conforme item 2.5.2 deste edital) e CPF:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="organizacao.anexos.documento_identificacao_representante" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    b.    Cópia do Cadastro Nacional da Pessoa Jurídica (CNPJ) que comprove a existência da entidade há pelo menos três anos:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="organizacao.anexos.cartao_cnpj" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    c.     Cópia do documento de constituição da atual diretoria e da presidência, ou cargo equivalente, da organização ou entidade cultural
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="organizacao.anexos.constituicao_diretoria" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    d.    Cópia do documento de identificação (conforme item 2.5.2 deste edital) e CPF do presidente, diretor executivo ou cargo equivalente
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="organizacao.anexos.documento_identificacao_presidente" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    e.    Cópia do atual estatuto social ou contrato social, conforme o caso, devidamente registrado no órgão competente, de modo a comprovar o caráter cultural da entidade e seu ano de criação
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="organizacao.anexos.contrato_social" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    f.      Relatório anual das atividades culturais no último triênio (2016, 2017 e 2018), com ações realizadas em cada um dos três anos, contendo, minimamente: o resumo de cada atividade, o local, o período de realização e o número de participantes
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="organizacao.anexos.relatorio_anual_atividades" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    g.    Comprovação efetiva de que possui projetos ou atividades culturais realizados em ao menos 5 estados de 2 macrorregiões brasileiras, a partir do exercício de 2016, por meio de: portfólio, folders, publicações, listas de presença, revistas, jornais, conteúdos de divulgação, links de vídeos, registros fotográficos ou outros materiais que permitam, minimamente, a identificação de data e local de realização das atividades e a aferição da veracidade das informações apresentadas
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="organizacao.anexos.comprovacao_projetos_atividades" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    h.    Lista de associados ou filiados atestada pelo dirigente da organização ou entidade cultural
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="organizacao.anexos.lista_associados" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    i.      Documentação que comprove a atuação da organização ou entidade cultural em instâncias colegiadas do setor cultural, tais como conselhos, comissões ou câmaras, se houver, por meio de termo de posse ou portaria de designação de representante;
                  </v-card-title>
                  <v-card-text>
                    <file v-model="organizacao.anexos.comprovante_instancia_colegiada" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="260"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    j.      Documentação que comprove a realização de projetos na área de pesquisa ou produção do conhecimento no campo da cultura a partir de 2016, tais como: publicações, pesquisa de campo e artigos científicos, se houver.
                  </v-card-title>
                  <v-card-text>
                    <file v-model="organizacao.anexos.comprovante_realizacao_projetos" />
                  </v-card-text>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-form>
        <v-layout
          align-center
          justify-center
          row
          fill-height
        >
          <v-btn

            @click="voltarEtapaAnterior"
          >
            Cancelar
          </v-btn>
          <v-btn
            color="primary"
            @click="salvar"
          >
            Enviar
          </v-btn>
        </v-layout>
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
    organizacao: {
      anexo: {
        valid_anexo: '',
        documento_identificacao_representante: '',
        cartao_cnpj: '',
        constituicao_diretoria: '',
        documento_identificacao_presidente: '',
        contrato_social: '',
        relatorio_anual_atividades: '',
        comprovacao_projetos_atividades: '',
        lista_associados: '',
        comprovante_instancia_colegiada: '',
        comprovante_realizacao_projetos: '',
      },
    },
    ata_reuniao_conselho: {},
    ato_normativo_conselho: {},
    documento_identificacao_responsavel: {},
    declaracao_ciencia_orgao_gestor: {},
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
    'organizacao.endereco.co_ibge': function (coIBGE) {
      this.obterMunicipios(coIBGE);
    },
    'organizacao.nu_cnpj': function (value) {
      const self = this;
      self.organizacao.no_orgao_gestor = '';
      this.nomeConselhoError = 'CNPJ inválido';
      if (value.length === 14 && Validate.isCnpjValido(value)) {
        this.consultarCNPJ(value).then((response) => {
          const { data } = response.data;
          self.organizacao.no_orgao_gestor = data.nmRazaoSocial;
        });
        this.nomeConselhoError = '';
      }
    },
    'organizacao.representante.nu_cpf': function (value) {
      const self = this;
      self.organizacao.representante.no_nome = '';
      this.nomeRepresentante = 'CPF inválido';
      if (value.length === 11 && Validate.isCpfValido(value)) {
        this.consultarCPF(value).then((response) => {
          const { data } = response.data;
          self.organizacao.representante.no_nome = data.nmPessoaFisica;
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
      perfil: 'conta/perfil',
    }),
  },
  methods: {
    ...mapActions({
      mensagemErro: 'app/setMensagemErro',
      obterEstados: 'localidade/obterEstados',
      obterMunicipios: 'localidade/obterMunicipios',
      confirmarConselho: 'conselho/confirmarConselho',
      consultarCNPJ: 'pessoa/consultarCNPJ',
      consultarCPF: 'pessoa/consultarCPF',
      obterFases: 'fase/obterFases',
    }),
    validarIrProximaEtapa(formRef) {
      if (this.$refs[formRef].validate()) {
        this.etapaFormulario = this.etapaFormulario + 1;
      }
    },
    salvar() {
      let erro = false;
      this.organizacao.anexos = [];
      const anexos = [
        'documento_identificacao_representante',
        'cartao_cnpj',
        'constituicao_diretoria',
        'documento_identificacao_presidente',
        'contrato_social',
        'relatorio_anual_atividades',
        'comprovacao_projetos_atividades',
        'lista_associados',
      ];
      if (this.organizacao.tp_governamental !== 'c') {
        const index = anexos.indexOf('declaracao_ciencia_orgao_gestor');
        if (index > -1) {
          anexos.splice(index, 1);
        }
      }
      try {
        anexos.forEach((nomeAnexo) => {
          this.organizacao.anexos.push({
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
