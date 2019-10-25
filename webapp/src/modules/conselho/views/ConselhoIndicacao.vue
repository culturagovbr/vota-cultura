<template>
  <v-container>
    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-toolbar-title>{{ $route.meta.title }}</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-layout class="pl-4">
          <v-flex
            xs12
            sm6
          >
            <div class="ma-12 text-justify subheading grey--text">
              <span class="font-weight-bold">Nome do conselho:</span>
              <span
                style="margin-left: 4px"
                v-html="conselhoGetter.no_conselho"
              />
            </div>
          </v-flex>
        </v-layout>


        <v-layout class="pa-4">
          <v-flex
            md12
            subheading
            grey--text
            mt-2
            d-inline-flex
          >
            <div class="md6">
              <span class="font-weight-bold">CNPJ do órgão gestor do conselho:</span>
              <span> {{ conselhoGetter.cnpj_formatado }}</span>
            </div>
            <div class="md6">
              <span class="font-weight-bold">Nome do órgão gestor do conselho:</span>
              <span
                style="margin-left: 4px"
                v-html="conselhoGetter.no_orgao_gestor"
              />
            </div>
          </v-flex>
        </v-layout>

        <v-card>
          <v-card-text>
            <v-container
              grid-list-md
            >
              <b>Critérios para as indicações de acordo com o item 5.3 do edital:</b>
              <div class="mt-3">
                <p>
                  5.3.1 - Os conselhos de cultura habilitados estarão aptos a indicar de <b>três a cinco
                    representantes</b> da sociedade civil, membros ou não do respectivo conselho, para
                  concorrer às vagas descritas no subitem 2.2.2. do edital.
                </p>
              </div>

              <div>
                5.3.2 - Os indicados deverão cumprir os seguintes requisitos:
                <br>
                <p class="ma-3">
                  a. mínimo de 3 anos de atuação comprovada no campo cultural;
                  <br>
                  b. ser maior de 18 anos;
                  <br>
                  c. residir na unidade da federação ou macrorregião do conselho de cultura que
                  o indicou; e
                  <br>
                  d. não ser ocupante de função de confiança ou cargo comissionado no setor
                  público.
                </p>
              </div>
              <v-alert
                :value="true"
                icon="warning"
                color="yellow lighten-3"
                class="black--text"
              >
                Atenção!
                <ol
                  style="list-style-type:number;"
                  type="1"
                >
                  <li>
                    Faça o cadastro de cada indicado (no mínimo 3 e no máximo 5);
                  </li>
                  <li>
                    Conclua a indicação até o prazo final estabelecido no cronograma do edital.
                    Somente após a conclusão que as indicações serão efetivadas;
                  </li>
                  <li>
                    Confira o recebimento do e-mail de confirmação na caixa de entrada do
                    representante e/ou do conselho. Caso não localize, verifique a caixa de spam.
                  </li>
                </ol>
              </v-alert>
              <v-card>
                <v-toolbar
                  color="white elevation-0"
                >
                  <v-toolbar-title>Lista dos indicados</v-toolbar-title>
                </v-toolbar>
                <v-card-text class="pa-0">
                  <v-data-table
                    :headers="headers"
                    :items="listarIndicacaoConselhoGetter"
                    :pagination.sync="pagination_conselho"
                    :total-items="totalItems"
                    hide-actions
                    :loading="loading"
                    item-key="co_usuario"
                    class="elevation-1"
                  >
                    <template
                      slot="items"
                      slot-scope="props"
                    >
                      <td>&nbsp;</td>
                      <td>{{ props.item.cpf_indicado_formatado }}</td>
                      <td>{{ props.item.no_indicado }}</td>
                      <td class="text-md-center">
                        <v-chip
                          dark
                          color="primary"
                        >
                          {{ props.item.endereco.municipio.uf.no_uf }}
                        </v-chip>
                      </td>
                      <td>
                        <v-chip>
                          {{ props.item.data_indicacao_formatada }}
                        </v-chip>
                      </td>
                      <td class="text-md-center">
                        <v-btn
                          depressed
                          outline
                          icon
                          fab
                          dark
                          color="primary"
                          small
                          @click="abrirDialogoVisualizacao(props.item)"
                        >
                          <v-icon>remove_red_eye</v-icon>
                        </v-btn>
                        <!--@click="deletarIndicacaoConselho(props.item.co_conselho_indicacao)"-->

                        <v-btn
                          v-if="(conselhoGetter || {}).st_indicacao === 'a'"
                          depressed
                          outline
                          icon
                          fab
                          dark
                          color="error"
                          small
                          @click="abrirDialogoConfirmacaoExclusao(props.item.co_conselho_indicacao)"
                        >
                          <v-icon>delete</v-icon>
                        </v-btn>
                      </td>
                    </template>
                  </v-data-table>
                </v-card-text>
              </v-card>
            </v-container>
          </v-card-text>
        </v-card>
      </v-card-text>
      <v-layout
        v-if="(conselhoGetter || {}).st_indicacao === 'a'"
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
      </v-layout>
    </v-card>

    <v-layout justify-center>

      <v-dialog
        v-model="dialogConfirmarConcluirIndicacao"
        max-width="360"
      >
        <v-card>
          <v-card-title class="headline">
            Deseja realmente concluir a indicação?
          </v-card-title>

          <v-card-text>
            Os dados enviados não poderão ser alterados posteriormente.
          </v-card-text>

          <v-card-actions>
            <v-spacer />

            <v-btn
              color="red darken-1"
              text
              flat
              @click="handleDialogConfirmarConcluirIndicacao"
            >
              Não
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              flat
              @click="enviarConcluirIndicacao(conselhoGetter.co_conselho)"
            >
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-dialog
        v-model="dialogoConfirmacaoExclusao"
        max-width="360"
      >
        <v-card>
          <v-card-title class="headline">
            Deseja realmente excluir?
          </v-card-title>

          <v-card-text>
            Os dados excluídos não poderão ser recuperados posteriormente.
          </v-card-text>

          <v-card-actions>
            <v-spacer />

            <v-btn
              color="red darken-1"
              text
              flat
              @click="fecharDialogoConfirmacaoExclusao"
            >
              Não
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              flat
              @click="deletarIndicado"
            >
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>


    <v-dialog
      v-model="dialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-toolbar
          dark
          color="primary"
        >
          <v-btn
            icon
            dark
            @click="fecharDialogo"
          >
            <v-icon>close</v-icon>
          </v-btn>

          <v-toolbar-title>
            Cadastrar indicado - Conselho de cultura
          </v-toolbar-title>

          <v-spacer />
        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-container
              grid-list-md
            >
              <v-layout
                row
                wrap
              >
                <v-flex>
                  <v-card>
                    <v-toolbar
                      color="white elevation-0"
                    >
                      <v-toolbar-title>Dados básicos</v-toolbar-title>
                    </v-toolbar>
                    <v-form
                      id="formulario"
                      ref="form"
                      v-model="formulario_valido"
                      lazy-validation
                    >
                      <v-card-text>
                        <v-container>
                          <v-layout>
                            <v-flex md8>
                              <v-layout>
                                <v-flex md6>
                                  <v-text-field
                                    v-model="indicado.nu_cpf_indicado"
                                    placeholder="999.999.999-99"
                                    append-icon="person"
                                    name="login"
                                    label="*CPF"
                                    mask="###.###.###-##"
                                    :error-messages="nomeIndicadoErros"
                                    validate-on-blur
                                    type="text"
                                    :rules="[rules.required]"
                                  />
                                </v-flex>
                                <v-flex md6>
                                  <template activator="{ on }">
                                    <v-menu
                                      ref="menu"
                                      v-model="menu"
                                      lazy
                                      transition="scale-transition"
                                      :close-on-content-click="false"
                                      offset-y
                                      full-width
                                      min-width="290px"
                                    >
                                      <template v-slot:activator="{ on }">
                                        <v-text-field
                                          v-model="indicado.dt_nascimento_indicado"
                                          label="*Data de nascimento"
                                          append-icon="event"
                                          placeholder="ex: 01/12/2019"
                                          return-masked-value
                                          mask="##/##/####"
                                          required
                                          :rules="[rules.required, rules.dataAniversario]"
                                          v-on="on"
                                        />
                                      </template>
                                      <v-date-picker
                                        v-model="date"
                                        locale="pt-BR"
                                        scrollable
                                      >
                                        <v-spacer />
                                        <v-btn
                                          flat
                                          color="primary"
                                          @click="menu = false"
                                        >
                                          Cancel
                                        </v-btn>
                                        <v-btn
                                          flat
                                          color="primary"
                                          @click="$refs.menu.save(date)"
                                        >
                                          OK
                                        </v-btn>
                                      </v-date-picker>
                                    </v-menu>
                                  </template>
                                </v-flex>
                              </v-layout>
                              <v-layout>
                                <v-flex md12>
                                  <v-text-field
                                    v-model="indicado.no_indicado"
                                    append-icon="person_outline"
                                    name="login"
                                    label="*Nome completo"
                                    :error-messages="nomeIndicadoErros"
                                    validate-on-blur
                                    type="text"
                                    :disabled="true"
                                    :rules="[rules.required]"
                                  />
                                </v-flex>
                              </v-layout>

                              <v-layout>
                                <v-flex md12>
                                  <v-select
                                    v-model="indicado.endereco.co_ibge"
                                    :items="listaUF"
                                    label="*Unidade da federação em que reside"
                                    append-icon="place"
                                    item-value="co_ibge"
                                    item-text="no_uf"
                                    required
                                    box
                                    :rules="[rules.required]"
                                  />
                                </v-flex>
                              </v-layout>

                              <v-layout>
                                <v-flex
                                  md12
                                  ma3
                                >
                                  <v-select
                                    v-model="indicado.endereco.co_municipio"
                                    :items="listaMunicipios"
                                    label="*Cidade em que reside"
                                    append-icon="place"
                                    item-value="co_municipio"
                                    item-text="no_municipio"
                                    box
                                    :disabled="indicado.endereco.co_ibge < 1 || indicado.endereco.co_ibge == null"
                                    :rules="[rules.required]"
                                  />
                                </v-flex>
                              </v-layout>
                            </v-flex>
                            <v-flex md4>
                              <file
                                ref="indicado_foto_rosto"
                                v-model="indicado_foto_rosto"
                                label-idle="Clique aqui para anexar foto do rosto (JPEG/JPG)"
                                :accepted-file-types="['image/jpeg']"
                              />
                            </v-flex>
                          </v-layout>
                          <v-layout>
                            <v-flex md12>
                              <v-textarea
                                v-model="indicado.ds_curriculo"
                                label="* Currículo resumido para a candidatura"
                                rows="13"
                                row-height="28"
                                :counter="1000"
                                box
                                auto-grow
                                :rules="[rules.required, rules.tamanhoMaximoCaracteres]"
                              />
                              <v-alert
                                :value="true"
                                icon="warning"
                                color="yellow lighten-3"
                                class="black--text"
                              >
                                Atenção! O texto do currículo resumido ficará disponível na
                                plataforma de votação e será a defesa da candidatura do indicado.
                              </v-alert>
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card-text>
                    </v-form>
                  </v-card>
                </v-flex>

                <v-flex>
                  <v-card>
                    <v-toolbar
                      color="white elevation-0"
                    >
                      <v-toolbar-title>Documentação</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                      <v-container
                        grid-list-md
                      >
                        <v-alert
                          :value="true"
                          icon="warning"
                          color="yellow lighten-3"
                          class="black--text"
                        >
                          Atenção! Anexe arquivos com tamanho até 40MB.
                          <br>
                          Envie os documentos no formato <b>PDF</b> (preferencialmente), <b>JPEG</b>,
                          <b>ZIP</b> ou <b>RAR</b> para enviar mais de um arquivo.
                        </v-alert>

                        <div class="ma-4 text-justify">
                          <v-container
                            fluid
                            grid-list-xl
                          >
                            <v-layout>
                              <v-flex class="pa-3">
                                <v-list two-line>
                                  <template
                                    v-for="documento in documentos"
                                  >
                                    <v-list-tile
                                      avatar
                                      @click=""
                                    >
                                      <v-list-tile-content>
                                        <v-list-tile-title
                                          v-html="`
                                              ${!!(documento.obrigatorio) ? '*' : ''} ${documento.descricao}`"
                                        />
                                      </v-list-tile-content>
                                      <v-list-tile-action />
                                    </v-list-tile>
                                    <file
                                      v-if="!documento.multiplo"
                                      :ref="documento.slug"
                                      v-model="anexos[documento.slug]"
                                    />
                                    <file
                                      v-else
                                      :ref="documento.slug"
                                      v-model="anexos[documento.slug]"
                                      :allow-multiple="true"
                                      label-idle="Clique aqui para anexar até 5 arquivos"
                                      :max-files="5"
                                    />
                                  </template>
                                </v-list>
                              </v-flex>
                            </v-layout>
                          </v-container>
                        </div>
                      </v-container>
                    </v-card-text>
                  </v-card>
                </v-flex>
              </v-layout>
              <v-footer
                color="white"
                class="justify-center ma-3"
              >
                <v-btn
                  @click="dialog = false"
                >
                  <v-icon left>
                    undo
                  </v-icon>
                  Voltar
                </v-btn>
                <v-btn
                  :loading="loading"
                  color="primary"
                  @click="salvar"
                >
                  <v-icon left>
                    send
                  </v-icon>
                  Salvar
                </v-btn>
              </v-footer>
            </v-container>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>
    <conselho-indicacao-dialogo
      v-model="dialogVisualizar"
      :conselho="itemSelecionado"
    />
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import File from '@/core/components/upload/File';
import Validate from '../../shared/util/validate';
import ConselhoIndicacaoDialogo from './ConselhoIndicacaoDialogo';
import { documentosIndicacao } from '../api/documentosIndicacao';

export default {
  name: 'ConselhoIndicacao',
  components: { ConselhoIndicacaoDialogo, File },
  data: () => ({
    rules: {
      required: v => !!v || 'Campo não preenchido',
      tamanhoMaximoCaracteres: value => (!!value && value.length <= 1000) || 'Máximo 1000 caracteres',
      dataAniversario: (value) => {
        if (value.length === 0 || !value.trim()) {
          return false;
        }
        // eslint-disable-next-line
        var padraoDataValida = /^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])      [\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/;

        if (!value.match(padraoDataValida)) {
          return 'Data inválida';
        }

        let [dia, mes, ano] = value.split('/');

        const hoje = new Date();
        const dataAniversario = new Date(ano, mes - 1, dia);

        ano = hoje.getFullYear() - dataAniversario.getFullYear();
        mes = hoje.getMonth() - dataAniversario.getMonth();
        if (mes < 0 || (mes === 0 && hoje.getDate() < dataAniversario.getDate())) {
          ano--;
        }

        if (ano > 100 || ano < 18) {
          return 'É necessário ser maior de 18 anos';
        }
        return true;
      },
    },
    documentos: documentosIndicacao,
    dialogoConfirmacaoExclusao: false,
    formulario_valido: false,
    menu: false,
    date: '',
    indicado_foto_rosto: {},
    anexos: {},
    nomeIndicadoErros: '',
    listaUF: [],
    loading: false,
    dialog: false,
    dialogVisualizar: false,
    pagination_conselho: {
      page: 1,
      rowsPerPage: 10,
      sortBy: 'no_conselho',
      descending: false,
    },
    totalItems: 0,
    headers: [
      {
        text: '',
        sortable: false,
      },
      {
        text: 'CPF',
        value: 'cpf_indicado_formatado',
        align: 'left',
        sortable: false,

      },
      {
        text: 'Nome',
        value: 'no_conselho',
        align: 'left',
        sortable: false,

      },
      {
        text: 'UF em que reside',
        value: 'endereco.municipio.uf.no_uf',
        align: 'center',
        sortable: false,

      },
      {
        text: 'Data do cadastro',
        value: 'endereco.municipio.uf.regiao.no_regiao',
        sortable: false,
      },
      {
        text: 'Ações',
        value: 'endereco.municipio.uf.regiao.no_regiao',
        sortable: false,
        align: 'center',
      },
    ],
    listaMunicipios: [],
    itemSelecionado: {},
    indicado: {
      dt_nascimento_indicado: '',
      nu_cpf_indicado: '',
      no_indicado: '',
      ds_curriculo: '',
      endereco: {
        co_ibge: '',
        co_municipio: '',
      },
      anexos: [],
    },
    arquivos: {
      anexos: [],
    },
    listaIndicados: [],
    usuarioLogado: {},
    dialogConfirmarConcluirIndicacao: false,
  }),
  computed: {
    ...mapGetters({
      estadosGetter: 'localidade/estados',
      municipiosGetter: 'localidade/municipios',
      listarIndicacaoConselhoGetter: 'conselho/listarIndicacaoConselho',
      conselhoGetter: 'conselho/conselho',
      usuario: 'conta/usuario',
    }),
  },
  watch: {
    dialog(valor) {
      if (!valor) {
        this.$refs.form.reset();
        this.$refs.form.resetValidation();
        this.nomeIndicadoErros = '';
        this.$refs.indicado_foto_rosto.reset();
        documentosIndicacao.forEach((documento) => {
          this.$refs[documento.slug][0].reset();
        });
      }
    },
    date() {
      this.indicado.dt_nascimento_indicado = this.formatDate(this.date);
    },
    estadosGetter() {
      this.listaUF = this.estadosGetter;
    },
    municipiosGetter() {
      this.listaMunicipios = this.municipiosGetter;
    },
    'indicado.endereco.co_ibge': function (coIBGE) {
      this.obterMunicipios(coIBGE);
    },
    'indicado.nu_cpf_indicado': function (value) {
      const self = this;
      self.indicado.no_indicado = '';
      this.nomeIndicadoErros = 'CPF inválido';
      if (value.length === 11 && Validate.isCpfValido(value)) {
        this.consultarCPF(value).then((response) => {
          const { data } = response.data;
          self.indicado.no_indicado = data.nmPessoaFisica;
        });
        this.nomeIndicadoErros = '';
      }
    },
    usuario(valor) {
      this.usuarioLogado = valor;
    },
    usuarioLogado(usuario) {
      if (usuario.co_conselho) {
        this.obterDadosConselho(usuario.co_conselho);
      }
    },
  },
  methods: {
    ...mapActions({
      consultarCPF: 'pessoa/consultarCPF',
      obterEstados: 'localidade/obterEstados',
      obterMunicipios: 'localidade/obterMunicipios',
      obterDadosConselho: 'conselho/obterDadosConselho',
      enviarIndicacaoConselho: 'conselho/enviarIndicacaoConselho',
      enviarIndicacaoConselhoArquivo: 'conselho/enviarIndicacaoConselhoArquivo',
      obterListaIndicacaoConselho: 'conselho/obterListaIndicacaoConselho',
      deletarIndicacaoConselho: 'conselho/deletarIndicacaoConselho',
      notificarErro: 'app/setMensagemErro',
      definirMensagemSucesso: 'app/setMensagemSucesso',
      concluirIndicacao: 'conselho/concluirIndicacao',
    }),
    handleDialogConfirmarConcluirIndicacao() {
        this.dialogConfirmarConcluirIndicacao = !this.dialogConfirmarConcluirIndicacao;
    },
    enviarConcluirIndicacao(coConselho) {
        this.concluirIndicacao(coConselho).then(() => {
            this.handleDialogConfirmarConcluirIndicacao();
            this.loading = false;
        })
    },
    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.split('-');
      return `${day}/${month}/${year}`;
    },
    abrirDialogo() {
      this.dialog = true;
    },
    fecharDialogo() {
      this.dialog = false;
    },
    salvar() {
      this.loading = true;
      if (!Object.keys(this.indicado_foto_rosto).length || this.$refs.indicado_foto_rosto.fileHasError()) {
        this.loading = false;
        this.$refs.form.validate();
        this.notificarErro('A foto de rosto é obrigatória.');
        return;
      }

      if (!this.$refs.form.validate()) {
        this.loading = false;
        return;
      }

      this.indicado.anexos = [];

      const erro = this.validarEnvioAnexosObrigatorios();

      if (erro) {
        this.loading = false;
        this.notificarErro('Preencha todos os anexos obrigatórios corretamente.');
        return;
      }

      Object.keys(this.anexos).forEach((slug) => {
        if (Array.isArray(this.anexos[slug])) {
          this.anexos[slug].forEach((arquivo) => {
            this.arquivos.anexos.push({
              binario: arquivo.file,
              slug,
            });
          });
          return true;
        }
        this.arquivos.anexos.push({
          binario: this.anexos[slug].file,
          slug,
        });
        return true;
      });

      const indicadoPayload = this.indicado;
      indicadoPayload.dt_nascimento_indicado = this.formatarDataCarbon(this.indicado.dt_nascimento_indicado);
      indicadoPayload.indicado_foto_rosto = this.indicado_foto_rosto.file;
      this.enviarIndicacaoConselho(indicadoPayload).then((response) => {
        const { co_conselho_indicacao } = response.data.data;
        const promises = [];
        this.arquivos.anexos.forEach((anexo) => {
          anexo = Object.assign(anexo, { co_conselho_indicacao });
          promises.push(this.enviarIndicacaoConselhoArquivo(anexo));
        });

        Promise.all(promises).then(() => {
          this.definirMensagemSucesso('Operação realizada com sucesso');
          this.loading = false;
          window.location.reload();
          this.fecharDialogo();
        });
      }).catch(() => {
        this.loading = false;
        this.fecharDialogo();
      });
    },
    validarEnvioAnexosObrigatorios() {
      let erro = false;
      documentosIndicacao.forEach((arquivo) => {
        if (arquivo.obrigatorio) {
          if (
            this.anexos[arquivo.slug] == null
              || !(!!Object.keys(this.anexos[arquivo.slug]).length || !!(this.anexos[arquivo.slug]).length)
          ) {
            erro = true;
          }
        }
        if (this.$refs[arquivo.slug][0].error) {
          erro = true;
        }
      });
      return erro;
    },
    formatarDataCarbon(data) {
      const [dia, mes, ano] = data.split('/');

      return `${ano}-${(`0${mes}`).slice(-2)}-${(`0${dia}`).slice(-2)}`;
    },
    abrirDialogoVisualizacao(valor) {
      this.itemSelecionado = valor;
      this.dialogVisualizar = true;
    },
    abrirDialogoConfirmacaoExclusao(itemParaExclusao) {
      this.dialogoConfirmacaoExclusao = true;
      this.itemParaExclusao = itemParaExclusao;
    },
    fecharDialogoConfirmacaoExclusao() {
      this.dialogoConfirmacaoExclusao = false;
    },
    deletarIndicado() {
      this.deletarIndicacaoConselho(this.itemParaExclusao);
      this.dialogoConfirmacaoExclusao = false;
    },
  },
  mounted() {
    this.loading = true;
    this.obterListaIndicacaoConselho().finally(() => {
      this.loading = false;
    });
    this.obterEstados();
    this.usuarioLogado = this.usuario;
    this.dialogVisualizar = false;
  },
  beforeDestroy() {
    this.dialogVisualizar = false;
  },
};
</script>
