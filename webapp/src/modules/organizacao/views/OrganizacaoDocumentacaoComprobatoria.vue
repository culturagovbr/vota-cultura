<template>
  <v-container>
    <v-card v-if="!!documentacaoComprobatoria.length">
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>Documentação enviada</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-container
          grid-list-md
          text-xs-center
        >
          <v-layout
            row
            wrap
          >
            <v-flex
              v-for="documento in documentacaoComprobatoria"
              :key="documento.co_arquivo"
              xs4
            >
              <v-card
                color="blue-grey lighten-5"
              >
                <v-card-title primary-title>
                  <div>
                    <div class="headline">
                      {{ texto[documento.rl_representante_arquivo.tp_arquivo] }} {{ documento.no_arquivo }}
                    </div>
                  </div>
                </v-card-title>
                <v-card-actions />
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card-text>
    </v-card>

    <v-card v-else>
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>Enviar documentação</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-form
          ref="form_anexo"
          v-model="valid_anexo"
          lazy-validation
        >
          <v-container
            fluid
            grid-list-xl
          >
            <div class="text-md-center grey--text title mb-9">
              Envie os documentos no formato PDF (preferencialmente), JPEG, <br>
              ZIP ou RAR para enviar mais de um arquivo.<br>

              <br>
              <b>ATENÇÃO</b>
              <br>
              Anexe arquivos com tamanho até 40MB
            </div>

            <v-layout
              align-center
              justify-center
              class="mb-4"
              wrap
            >
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    a.    Cópia de documento de identificação do representante legal responsável pela inscrição da organização ou entidade cultural (conforme item 2.5.2 deste edital) e CPF:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="documento_identificacao_representante" />
                    <v-input
                      v-if="anexoComErro.documento_identificacao_representante"
                      :error-messages="['Documento obrigatório!']"
                      error
                      disabled
                    />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class="mb-1 justify-center">
                    b.    Cópia do Cadastro Nacional da Pessoa Jurídica (CNPJ) que comprove a existência da entidade há pelo menos três anos:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="comprovante_cnpj" />
                    <v-input
                      v-if="anexoComErro.comprovante_cnpj"
                      :error-messages="['Documento obrigatório!']"
                      error
                      disabled
                    />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    c.     Cópia do documento de constituição da atual diretoria e da presidência, ou cargo equivalente, da organização ou entidade cultural:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="constituicao_diretoria" />
                    <v-input
                      v-if="anexoComErro.constituicao_diretoria"
                      :error-messages="['Documento obrigatório!']"
                      error
                      disabled
                    />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    d.    Cópia do documento de identificação (conforme item 2.5.2 deste edital) e CPF do presidente, diretor executivo ou cargo equivalente:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="documento_identificacao_presidente" />
                    <v-input
                      v-if="anexoComErro.documento_identificacao_presidente"
                      :error-messages="['Documento obrigatório!']"
                      error
                      disabled
                    />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class="mb-1 justify-center">
                    e.    Cópia do atual estatuto social ou contrato social, conforme o caso, devidamente registrado no órgão competente, de modo a comprovar o caráter cultural da entidade e seu ano de criação:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="contrato_social" />
                    <v-input
                      v-if="anexoComErro.contrato_social"
                      :error-messages="['Documento obrigatório!']"
                      error
                      disabled
                    />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    f.      Relatório anual das atividades culturais no último triênio (2016, 2017 e 2018), com ações realizadas em cada um dos três anos, contendo, minimamente: o resumo de cada atividade, o local, o período de realização e o número de participantes:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="relatorio_anual_atividades" />
                    <v-input
                      v-if="anexoComErro.relatorio_anual_atividades"
                      :error-messages="['Documento obrigatório!']"
                      error
                      disabled
                    />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    g.    Comprovação efetiva de que possui projetos ou atividades culturais realizados em ao menos 5 estados de 2 macrorregiões brasileiras, a partir do exercício de 2016, por meio de: portfólio, folders, publicações, listas de presença, revistas, jornais, conteúdos de divulgação, links de vídeos, registros fotográficos ou outros materiais que permitam, minimamente, a identificação de data e local de realização das atividades e a aferição da veracidade das informações apresentadas:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="comprovacao_projetos_atividades" />
                    <v-input
                      v-if="anexoComErro.comprovacao_projetos_atividades"
                      :error-messages="['Documento obrigatório!']"
                      error
                      disabled
                    />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    h.    Lista de associados ou filiados atestada pelo dirigente da organização ou entidade cultural:
                  </v-card-title>
                  <v-card-text>
                    <span class="grey--text">Obrigatório *</span>
                    <file v-model="lista_associados" />
                    <v-input
                      v-if="anexoComErro.lista_associados"
                      :error-messages="['Documento obrigatório!']"
                      error
                      disabled
                    />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    i.      Documentação que comprove a atuação da organização ou entidade cultural em instâncias colegiadas do setor cultural, tais como conselhos, comissões ou câmaras, se houver, por meio de termo de posse ou portaria de designação de representante:
                  </v-card-title>
                  <v-card-text>
                    <file v-model="comprovante_instancia_colegiada" />
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm6>
                <v-card
                  max-width="344"
                  min-height="322"
                  min-width="500"
                  class="mx-auto"
                >
                  <v-card-title class=" mb-1 justify-center">
                    j.      Documentação que comprove a realização de projetos na área de pesquisa ou produção do conhecimento no campo da cultura a partir de 2016, tais como: publicações, pesquisa de campo e artigos científicos, se houver:
                  </v-card-title>
                  <v-card-text>
                    <file v-model="comprovante_realizacao_projetos" />
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
            href="/"
          >
            Cancelar
          </v-btn>
          <v-btn
            color="primary"
            :loading="loading"
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

export default {
  name: 'OrganizacaoDocumentacaoComprobatoria',
  components: { File },
  data: () => ({
    texto: {
      documento_identificacao_representante: 'A)',
      comprovante_cnpj: 'B)',
      constituicao_diretoria: 'C)',
      documento_identificacao_presidente: 'D)',
      contrato_social: 'E)',
      relatorio_anual_atividades: 'F)',
      comprovacao_projetos_atividades: 'G)',
      lista_associados: 'H)',
      comprovante_instancia_colegiada: 'I)',
      comprovante_realizacao_projetos: 'J)',
    },
    loading: false,
    valid_anexo: true,
    documento_identificacao_representante: Object(),
    comprovante_cnpj: Object(),
    constituicao_diretoria: Object(),
    documento_identificacao_presidente: Object(),
    contrato_social: Object(),
    relatorio_anual_atividades: Object(),
    comprovacao_projetos_atividades: Object(),
    lista_associados: Object(),
    comprovante_instancia_colegiada: Object(),
    comprovante_realizacao_projetos: Object(),
    anexoComErro: {
      documento_identificacao_representante: false,
      comprovante_cnpj: false,
      constituicao_diretoria: false,
      documento_identificacao_presidente: false,
      contrato_social: false,
      relatorio_anual_atividades: false,
      comprovacao_projetos_atividades: false,
      lista_associados: false,
    },
    organizacao: {
      anexos: [],
    },
  }),
  computed: {
    ...mapGetters({
      usuarioGetter: 'conta/usuario',
      documentacaoComprobatoria: 'organizacao/documentacaoComprobatoria',
    }),
  },
  watch: {
    documento_identificacao_representante(pond) {
    },
  },
  methods: {
    ...mapActions({
      notificarErro: 'app/setMensagemErro',
      notificarSucesso: 'app/setMensagemSucesso',
      enviarDocumentacaoComprobatoria: 'organizacao/enviarDocumentacaoComprobatoria',
      obterDocumentacaoComprobatoria: 'organizacao/obterDocumentacaoComprobatoria',
    }),
    salvar() {
      const self = this;
      this.loading = true;
      this.valid_anexo = true;
      this.organizacao.anexos = [];
      const anexos = [
        'documento_identificacao_representante',
        'comprovante_cnpj',
        'constituicao_diretoria',
        'documento_identificacao_presidente',
        'contrato_social',
        'relatorio_anual_atividades',
        'comprovacao_projetos_atividades',
        'lista_associados',
      ];
      const anexosNaoObrigatorios = [
        'comprovante_realizacao_projetos',
        'comprovante_instancia_colegiada',
      ];

      anexosNaoObrigatorios.forEach((nomeAnexo) => {
        if (Object.keys(this[nomeAnexo]).length) {
          this.organizacao.anexos.push({
            binario: this[nomeAnexo].file,
            slug: nomeAnexo,
          });
        }
      });

      anexos.forEach((nomeAnexo) => {
        if (!Object.keys(this[nomeAnexo]).length) {
          this.anexoComErro[nomeAnexo] = true;
          self.valid_anexo = false;
          return false;
        }
        this.organizacao.anexos.push({
          binario: this[nomeAnexo].file,
          slug: nomeAnexo,
        });
        return true;
      });

      if (!this.valid_anexo) {
        this.notificarErro('Anexe os documentos obrigatórios!');
        this.loading = false;
        return false;
      }

      this.enviarDocumentacaoComprobatoria(this.organizacao).then((response) => {
        const { data } = response;
        self.notificarSucesso(data.message);
        window.location.reload();
      }).catch((error) => {
        self.notificarErro(error);
        this.loading = false;
      });
      return true;
    },
  },
  mounted() {
    this.definirMensagemErro('O prazo de recurso expirou!');
    this.$router.push('/');

    if (this.usuarioGetter.co_organizacao === null) {
      this.notificarErro('Acesso restrito para organização e entidades culturais.');
      this.$router.push('/');
    }

    this.obterDocumentacaoComprobatoria(this.usuarioGetter.co_organizacao);
  },
};
</script>
