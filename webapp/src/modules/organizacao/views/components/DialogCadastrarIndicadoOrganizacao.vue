<template>
	<v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
		<v-card>
			<v-toolbar
				dark
				color="primary"
			>
				<v-btn
					icon
					dark
					@click="dialog = false"
				>
					<v-icon>close</v-icon>
				</v-btn>
				<v-toolbar-title>
					<v-layout>
						<v-flex class="text-md-center title">Indicação - Organização/entidade cultural</v-flex>
					</v-layout>
				</v-toolbar-title>
				<v-spacer/>
			</v-toolbar>
			<v-card-text xs8 md8 sm8>
				<v-container fluid subheading grey--text mt-2 text-xs-left>
					<v-form
						ref="form"
						v-model="valid"
						lazy-validation
					>
						<v-layout class="v-card">
							<v-flex>
								<v-card-title class="v-tabs__bar theme--dark grey darken-3  ">
									<div class="v-tabs__div v-tabs__item v-tabs__item--active">INDICAÇÃO</div>
								</v-card-title>
								<v-card-text>
									<v-layout xs12 mt-2>
										<v-flex xs4>
											<v-select
												v-model="formulario.organizacao.co_organizacao"
												:items="organizacoesGetter"
												item-value="co_organizacao"
												item-text="no_organizacao"
												label="*Organização/entidade cultural"
												required
												box
												:rules="[rules.required]"
												@change="preencherDadosOrganizacao"
											>
											</v-select>
										</v-flex>
									</v-layout>

									<v-layout xs12 mt-2 font-weight-bold>
										<v-flex xs6 md6 sm12>
											Pontuação final: {{formulario.organizacao.nu_pontuacao_final}}
										</v-flex>

										<v-flex xs6 md6 sm12>
											CNPJ: {{formulario.organizacao.nu_cnpj_formatado}}
										</v-flex>
									</v-layout>

									<v-layout xs12 mt-2 font-weight-bold>
										<v-flex xs6 md6 sm12>
											Resultado final da habilitação: <span
											:class="formulario.organizacao.avaliacao.color">{{ (formulario.organizacao.avaliacao.text) }}</span>
										</v-flex>

										<v-flex xs6 md6 sm12>
											Segmento cultural: {{formulario.organizacao.ds_segmento}}
										</v-flex>
									</v-layout>

									<v-layout xs12 mt-5>
										<v-flex>
											DADOS DO INDICADO
										</v-flex>
									</v-layout>

									<v-layout xs12 mt-2>
										<v-radio-group v-model="formulario.indicado.tp_indicado" row :rules="[rules.required]">
											<v-radio
												label="Titular"
												value="t"
											></v-radio>
											<v-radio
												label="Suplente"
												value="s"
											></v-radio>
										</v-radio-group>
									</v-layout>

									<v-layout xs12 mt-2>
										<v-flex xs4 md6 sm6>
											<v-text-field
												v-model="formulario.indicado.nu_cpf_indicado"
												label="*CPF"
												append-icon="person"
												placeholder="999.999.999.99"
												mask="###.###.###.##"
												:rules="[rules.required, rules.cpfMin]"
												required
											/>
										</v-flex>
										<v-flex xs2 md3 sm3></v-flex>
										<v-flex xs4 md6 sm6>
											<v-text-field
												v-model="formulario.indicado.dt_nascimento_indicado"
												label="*Data de nascimento"
												append-icon="event"
												placeholder="ex: 01/12/2019"
												return-masked-value
												mask="##/##/####"
												required
												:rules="[rules.required, rules.dataAniversario]"
											/>
										</v-flex>
									</v-layout>

									<v-layout mt-2 xs12>
										<v-flex>
											<v-text-field
												v-model="formulario.indicado.no_indicado"
												:disabled="true"
												label="*Nome completo"
												append-icon="perm_identity"
												:rules="[rules.cpfInvalido]"
												required
											/>
										</v-flex>
									</v-layout>
									<v-layout xs12>
										<v-flex ma-2>
											<v-textarea
												v-model="formulario.indicado.ds_curriculo"
												name="input-7-1"
												box
												solo
												label="*Mini currículo"
												placeholder="*Mini currículo"
												:counter="1000"
												:rules="[rules.required, rules.tamanhoMaximoCaracteres]"
											/>
										</v-flex>
									</v-layout>

									<v-layout xs12 mt-5 text-xs-center>
										<v-flex>
											<v-btn @click="dialog = false">
												Cancelar
											</v-btn>
											<v-btn
												color="primary"
												@click="validate"
											>
												Salvar
											</v-btn>
										</v-flex>
									</v-layout>

									<v-dialog
										v-model="dialogSalvarIndicado"
										max-width="360"
									>
										<v-card>
											<v-card-title class="headline">
												Deseja realmente enviar?
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
													@click="dialogSalvarIndicado = false"
												>
													Não
												</v-btn>
												<v-btn
													color="green darken-1"
													text
													flat
													@click="salvarIndicado"
												>
													Sim
												</v-btn>
											</v-card-actions>
										</v-card>
									</v-dialog>

								</v-card-text>
							</v-flex>
						</v-layout>
					</v-form>
				</v-container>
			</v-card-text>
		</v-card>
	</v-dialog>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
	import moment from 'moment';
    export default {
        name: 'DialogCadastrarIndicadoOrganizacao',
        data: () => ({
            dialogSalvarIndicado: false,
	        valid : false,
            menu: false,
            dialog: false,
            listaOrganizacoes: [],
	        formulario : {
                organizacao: {
                    avaliacao: {
                        text: '',
                        class: ''
                    },
                    co_organizacao: null,
                    nu_pontuacao_final: ' - ',
                    st_avaliacao: ' - ',
                    nu_cnpj_formatado: ' - ',
                    ds_segmento: ' - ',
                },
                indicado: {
                    tp_indicado: 't',
                    nu_cpf_indicado: '',
                    dt_nascimento_indicado: '',
                    no_indicado: '',
                    ds_curriculo: ''
                }
            },
            formularioInicial: {
                organizacao: {
                    avaliacao: {
                        text: '',
                        class: ''
                    },
                    co_organizacao: null,
                    nu_pontuacao_final: ' - ',
                    st_avaliacao: ' - ',
                    nu_cnpj_formatado: ' - ',
                    ds_segmento: ' - ',
                },
                indicado: {
                    tp_indicado: 't',
                    nu_cpf_indicado: '',
                    dt_nascimento_indicado: '',
                    no_indicado: '',
                    ds_curriculo: ''
                }
            },
            rules: {
                required: v => !!v || "Campo não preenchido",
                tamanhoMaximoCaracteres: value => (!!value && value.length <= 1000) || "Máximo 1000 caracteres",
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
                cpfInvalido: v => !!v || 'CPF não encontrado',
                cpfMin: v => (v && v.length === 11) || 'Mínimo de 11 caracteres',
            }
        }),
        methods: {
            salvarIndicado() {
                let postData = this.formulario.indicado;
                postData.co_organizacao = this.formulario.organizacao.co_organizacao;
                this.salvarOrganizacaoIndicacao(postData)
	                    .then(response => {
                            this.definirMensagemSucesso(response.data.message);
                            this.$parent.obterDadosOrganizacaoIndicacao();
                            this.dialog = false;
                            this.dialogSalvarIndicado = false;
	                    }).catch(error => {
                            this.definirMensagemErro(error.response.data.message);
                            this.dialogSalvarIndicado = false;
                        });

            },
            formatDate(data) {
                if (data.length === 0 || !data.trim()) {
                    return false;
                }
                const [dia, mes, ano] = data.split('/');
                return `${ano}-${mes}-${dia}`;
            },
            preencherDadosOrganizacao(coOrganizacao) {
                let organizacoes = this.organizacoesGetter;
                for (let x in organizacoes) {
                    let organizacao = organizacoes[x];
                    if (organizacao.co_organizacao === coOrganizacao) {
                        this.formulario.organizacao = {
                            co_organizacao: organizacao.co_organizacao,
                            nu_pontuacao_final: this.obterPontuacaoFinal(organizacao),
                            avaliacao: this.obterSituacaoAvaliacao(organizacao),
                            nu_cnpj_formatado: organizacao.cnpj_formatado,
                            ds_segmento: organizacao.segmento.ds_detalhamento,
                        }
                    }
                }

            },
            obterSituacaoAvaliacao(item) {
                if (Object.keys((item.habilitacaoRecurso || {})).length > 0) {
                    return this.mapCodeResultadoAvaliacaoToString(item.habilitacaoRecurso.st_parecer);
                }

                return this.mapCodeResultadoAvaliacaoToString(item.organizacaoHabilitacao.st_avaliacao);
            },
            obterPontuacaoFinal(item) {
                if ((item.habilitacaoRecurso || {}).nu_pontuacao) {
                    return parseInt(item.habilitacaoRecurso.nu_pontuacao, 10);
                }

                return parseInt(parseInt((item.organizacaoHabilitacao || {}).nu_nova_pontuacao) >= 0 ?
                    (item.organizacaoHabilitacao || {}).nu_nova_pontuacao :
                    item.pontuacao, 10);
            },
            mapCodeResultadoAvaliacaoToString(stParecer) {
                let parecer = {};
                switch (parseInt(stParecer)) {
                    case 0:
                        parecer = {
                            text: 'Inabilitada',
                            color: "red--text"
                        };
                        break;
                    case 1:
                        parecer = {
                            text: 'Habilitada e desclassificada',
                            color: 'orange--text'
                        };
                        break;
                    case 2:
                        parecer = {
                            text: 'Habilitada e classificada',
                            color: 'green--text'
                        };
                        break;
                    case 3:
                        parecer = {
                            text: 'Habilitada',
                            color: 'green--text'
                        };
                        break;
                    default:
                        parecer = {text: ' - ', color: ''};
                        break;
                }

                return parecer;
            },
            carregarCPF(valor) {
                const self = this;
                this.consultarCPF(valor).then((response) => {
                    const {data} = response.data;
                    self.formulario.indicado.no_indicado = data.nmPessoaFisica;
                });
            },
            validate() {
                if (this.$refs.form.validate()) {
					this.dialogSalvarIndicado = true;
                }
            },
            ...mapActions({
                definirMensagemSucesso: 'app/setMensagemSucesso',
                definirMensagemErro: 'app/setMensagemErro',
                consultarCPF: 'pessoa/consultarCPF',
                obterOrganizacoesHabilitacao: 'organizacao/obterOrganizacoesHabilitadasEClassificadas',
	            salvarOrganizacaoIndicacao: 'organizacao/salvarOrganizacaoIndicacao'
            }),
        },

        watch: {
            dialog(valor) {
                this.$emit('input', valor);
                if(!valor) {
			        this.formulario = {...this.formularioInicial};
                    this.$refs.form.reset();
                }
            },
            value(valor) {
                this.dialog = valor;
            },
            'formulario.indicado.nu_cpf_indicado': function (valor) {
                if (valor.length === 11) {
                    this.carregarCPF(valor);
                }
            },
        },
        computed: {
            ...mapGetters({
                organizacoesGetter: 'organizacao/organizacoesHabilitadasEClassificadas',
            }),
            organizacoes() {
                let organizacoes = [...this.organizacoesGetter];

                organizacoes.map((organizacao) => {
                    organizacao.pontuacao_final = this.obterPontuacaoFinal(organizacao);
                    return organizacao;
                });

                return organizacoes;
            },
        },
        props: {
            value: {
                type: Boolean,
                default: false,
            },
        },
        mounted() {
            const self = this;
            self.loading = true;
            self.obterOrganizacoesHabilitacao().then(() => {
                self.loading = false;
            });
        },
    }
</script>