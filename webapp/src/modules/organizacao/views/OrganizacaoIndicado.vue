<template>
	<v-container fluid>
		<v-layout text-xs-center>
			<v-flex>
				<v-card-title>
					<h2 class="flex primary--text">
						{{ $route.meta.title }}
					</h2>
				</v-card-title>
			</v-flex>
		</v-layout>

		<v-card>

			<v-tabs
				color="white"
				centered
				icons-and-text
			>
				<v-tabs-slider/>
				<v-tab href="#organizacao">
					Organização ou Entidade
					<v-icon>color_lens</v-icon>
				</v-tab>
			</v-tabs>

			<v-card-title>
				<v-spacer />
				<v-text-field
					v-model="pesquisar"
					append-icon="search"
					label="Pesquisar"
					single-line
					hide-details
				/>
				<v-spacer />
			</v-card-title>

			<v-tabs-items>
				<v-tab-item value="organizacao">

					<v-layout>
						<v-flex text-xs-right v-if="showConcluirIndicacao">
							<v-btn round outline color="primary" dark @click="dialogCadastrarIndicado = true">
								+ Indicar
							</v-btn>
						</v-flex>
					</v-layout>

					<v-layout mt-4>
						<v-flex>
							<v-data-table
								:pagination.sync="pagination_conselho"
								:headers="headers"
								:items="organizacaoGetter"
								:expand="expand"
								item-key="no_indicado"
								:loading="loading"
								:search="pesquisar"
							>
								<template
									slot="items"
									slot-scope="props"
								>
									<tr @click="props.expanded = !props.expanded">
										<td>{{ props.item.nu_cpf_indicado }}</td>
										<td>{{ props.item.no_indicado }}</td>
										<td>{{ props.item.dt_nascimento_indicado }}</td>
										<td>{{ props.item.tp_indicado }}</td>
										<td>{{ props.item.organizacao.no_organizacao }}</td>
										<td>{{ props.item.segmento.ds_detalhamento }}</td>
										<td>
											<v-btn
												depressed
												outline
												icon
												fab
												dark
												color="primary"
												small
											>
												<v-icon>remove_red_eye</v-icon>
											</v-btn>

										</td>
										<td>
											<v-btn
												v-if="showConcluirIndicacao"
												depressed
												outline
												icon
												fab
												dark
												color="error"
												small
												@click="abrirDialogoConfirmacaoExclusao(props.item.co_organizacao_indicacao)"
											>
												<v-icon>delete</v-icon>
											</v-btn>
										</td>
									</tr>
								</template>
								<template v-slot:expand="props">
									<v-card flat color="#eee">
										<v-card-text>{{ props.item.ds_curriculo }}</v-card-text>
									</v-card>
								</template>
							</v-data-table>
						</v-flex>
					</v-layout>
					<v-layout text-xs-center>
						<v-flex>
							<v-btn small color="primary" @click="dialogConcluirIndicacao" v-if="showConcluirIndicacao">
								CONCLUIR
							</v-btn>
						</v-flex>
					</v-layout>

					<dialog-cadastrar-indicado-organizacao v-model="dialogCadastrarIndicado"/>

					<v-dialog
						v-model="dialogoConfirmacaoExclusao"
						max-width="360"
					>
						<v-card>
							<v-card-title class="headline">
								Deseja realmente excluir o indicado?
							</v-card-title>

							<v-card-text>
								Ao excluir não será possível recuperar os dados posteriormente.
							</v-card-text>

							<v-card-actions>
								<v-spacer/>

								<v-btn
									color="red darken-1"
									text
									flat
									@click="dialogoConfirmacaoExclusao = false"
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

					<v-dialog
						v-model="dialogConfirmarConclusao"
						max-width="360"
					>
						<v-card>
							<v-card-title class="headline">
								Deseja realmente concluir a indicação?
							</v-card-title>

							<v-card-text>
								Atenção! <br/>
								Ao concluir não será possível alterar os dados ou cadastrar novo indicado.
							</v-card-text>

							<v-card-actions>
								<v-spacer/>
								<v-btn
									color="red darken-1"
									text
									flat
									@click="dialogConfirmarConclusao = false"
								>
									Não
								</v-btn>

								<v-btn
									color="green darken-1"
									text
									flat
									@click="concluirIndicacao"
								>
									Sim
								</v-btn>
							</v-card-actions>
						</v-card>
					</v-dialog>
				</v-tab-item>
			</v-tabs-items>
		</v-card>


	</v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import DialogCadastrarIndicadoOrganizacao from './components/DialogCadastrarIndicadoOrganizacao';

    export default {
        name: 'OrganizacaoIndicacao',
        components: {DialogCadastrarIndicadoOrganizacao},
        data() {
            return {
                pesquisar : '',
                pagination_conselho: {
                    page: 1,
                    rowsPerPage: 25,
                    sortBy: 'organizacao.no_organizacao',
                    descending: false,
                },
                co_fase: null,
                dialogConfirmarConclusao: false,
                showConcluirIndicacao: false,
                dialogoConfirmacaoExclusao: false,
                itemParaExclusao: {},
                loading: true,
                dialogCadastrarIndicado: false,
                expand: true,
                headers: [
                    {text: 'CPF', value: 'nu_cpf_indicado'},
                    {text: 'Nome', value: 'no_indicado'},
                    {text: 'Data de nascimento', value: 'dt_nascimento_indicado'},
                    {text: 'Posição', value: 'tp_indicado'},
                    {text: 'Organização/entidade', value: 'organizacao.no_organizacao'},
                    {text: 'Segmento', value: 'organizacao.segmento.ds_detalhamento'},
                    {text: 'Mini-currículo', sortable : false}
                ]
            }
        },
        watch: {
            dialogCadastrarIndicado(value) {
                if (!value) {
                    this.obterDadosOrganizacaoIndicacao();
                }
            },
            fases(value) {
                this.validarConclusaoIndicacao(value);
            }
        },
        computed: {
            ...mapGetters({
                usuario: "conta/usuario",
                organizacaoGetter: "organizacao/organizacaoIndicacao",
                fases: 'fase/fases'
            })
        },
        methods: {
            dialogConcluirIndicacao() {
                this.dialogConfirmarConclusao = true;
            },
            concluirIndicacao() {
                this.concluirOrganizacaoIndicacao(this.co_fase)
                    .then(() => {
                        this.definirMensagemSucesso("Indicação concluída com sucesso");
                        this.showConcluirIndicacao = false;
                        this.dialogConfirmarConclusao = false;
                        this.headers = this.headers.filter(header => {
                            return header.text !== 'Ações' ? header : null;
                        });
                    })
                    .finally(() => {
                        this.obterFases();
                    })
                ;
            },
            deletarIndicado() {
                this.deletarOrganizacaoIndicacao(this.itemParaExclusao).then(() => {
                    this.dialogoConfirmacaoExclusao = false;
                    this.definirMensagemSucesso('Indicado removido com sucesso.');
                }).finally(() => {
                    this.obterDadosOrganizacaoIndicacao();
                })
            },
            abrirDialogoConfirmacaoExclusao(itemParaExclusao) {
                this.dialogoConfirmacaoExclusao = true;
                this.itemParaExclusao = itemParaExclusao;
            },
            ...mapActions({
                obterDadosOrganizacaoIndicacao: "organizacao/obterDadosOrganizacaoIndicacao",
                deletarOrganizacaoIndicacao: "organizacao/deletarOrganizacaoIndicacao",
                definirMensagemSucesso: "app/setMensagemSucesso",
                definirMensagemErro: "app/setMensagemErro",
                concluirOrganizacaoIndicacao: "fase/concluirOrganizacaoIndicacao",
                obterFases: 'fase/obterFases',
            }),
            validarConclusaoIndicacao(value) {
                value.forEach(fase => {
                    if (fase.tp_fase === 'abertura_inscricoes_indicados_organizacao') {
                        this.co_fase = fase.co_fase;
                        this.showConcluirIndicacao = true;

                        this.headers.push({
	                        text: 'Ações', sortable: false
	                    });
                    }
                })
            },
        },
        mounted() {
            const self = this;
            self.loading = true;
            self.obterDadosOrganizacaoIndicacao()
                .finally(() => {
                    self.loading = false;
                });
            this.validarConclusaoIndicacao(this.fases);

        }
    }
</script>