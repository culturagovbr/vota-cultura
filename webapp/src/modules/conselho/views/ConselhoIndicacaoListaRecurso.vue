<template>
	<v-container>
		<v-card>
			<v-card-title>
				<div class="layout column align-center">
					<h2 class="flex my-2 primary--text">
					    Recurso da indicação
					</h2>
				</div>
			</v-card-title>
			<v-tabs	color="white" centered icons-and-text>
				<v-tabs-slider />
				<v-tab href="#conselho">
					Conselho
					<v-icon>group</v-icon>
				</v-tab>
			</v-tabs>
			<v-tabs-items>
				<v-tab-item value="conselho">
					<v-card>
						<v-card-text>
							<v-card>
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
								<v-card-text class="pa-0">
									<v-data-table
										:headers="headers"
										:items="listaIndicados"
										:pagination.sync="pagination_conselho"
										:total-items="totalItems"
										:loading="loading"
										:search="pesquisar"
										item-key="co_indicado"
										class="elevation-1"
									>
										<template
											slot="items"
											slot-scope="props"
										>
											<td />
											<td>{{ props.item.nu_cpf_formatado }}</td>
											<td>{{ props.item.no_indicado }}</td>
											<td>
												<v-chip
													dark
													color="primary"
												>
													{{ props.item.no_uf }}
												</v-chip>
											</td>
											<td>
												{{ props.item.no_conselho }}
											</td>
											<td>
												<v-chip v-if="!!props.item.st_avaliacao"
												        dark
												        :color="props.item.st_avaliacao  ? 'primary' : 'error'"
												>
													{{ props.item.st_avaliacao ? 'Habilitado' : 'Inabilitado'}}
												</v-chip>
												<span v-else>-</span>
											</td>
											<td>
												<v-tooltip bottom>
													<template v-slot:activator="{ on }">
														<v-btn
															depressed
															outline
															icon
															fab
															dark
															color="primary"
															small
															v-on="on"
															@click="abrirDialogIndicacaoRecurso(props.item)"
														>
															<v-icon>
																remove_red_eye
															</v-icon>
														</v-btn>
													</template>
													<span v-if="props.item.conselhoHabilitacao === null">Avaliar</span>
													<span v-else>Visualizar</span>
												</v-tooltip>
											</td>
										</template>
									</v-data-table>
								</v-card-text>
							</v-card>
						</v-card-text>
					</v-card>
				</v-tab-item>
			</v-tabs-items>
		</v-card>
		<v-container>
			<v-layout>
				<conselho-indicacao-recurso-dialog
					v-model="dialogConselhoIndicacaoRecurso"
					:dados="itemEditado"
					:readonly="true"
				/>
			</v-layout>
		</v-container>
	</v-container>

</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import ConselhoIndicacaoRecursoDialog from "./ConselhoIndicacaoRecursoDialog";
	export default {
	    name : 'ConselhoIndicacaoListaRecurso',
		components : {ConselhoIndicacaoRecursoDialog},
	    data: () => ({
		    listaIndicados : [],
		    dialogConselhoIndicacaoRecurso : false,
		    itemEditado : {},
            totalItems : null,
		    loading : false,
            pesquisar: '',
            pagination_conselho: {
                page: 1,
                    rowsPerPage: 10,
                    sortBy: 'no_indicado',
                    descending: false,
            },
            headers: [
                {
                    text: '',
                    sortable: false,
                },
                {
                    text: 'CPF',
                    value: 'nu_cpf_formatado',
                },
                {
                    text: 'Nome',
                    value: 'no_indicado',
                },
                {
                    text: 'UF em que reside',
                    value: 'no_uf',
                },
                {
                    text: 'Nome do conselho',
                    value: 'no_conselho',
                },
                {
                    text: 'Resultado da habilitação',
                    value: 'st_avaliacao',
                },
            ],
		}),
        computed: {
            ...mapGetters({
                listarIndicacaoRecursoConselho: 'conselho/listarIndicacaoRecursoConselho',
            }),
        },
		watch: {
            listarIndicacaoRecursoConselho(valor) {
                this.listaIndicados = valor.map(indicado => {
                    return {
                        nu_cpf_formatado : indicado.indicacaoHabilitacao[0].nu_cpf_formatado,
                        no_indicado : indicado.indicacaoHabilitacao[0].indicado.no_indicado,
                        no_uf : indicado.indicacaoHabilitacao[0].endereco.municipio.uf.no_uf,
                        no_conselho : indicado.indicacaoHabilitacao[0].indicado.conselho.no_conselho,
                        st_avaliacao : indicado.indicacaoHabilitacao[0].st_avaliacao,
                    }
                });
            }
		},
        methods: {
            abrirDialogIndicacaoRecurso(item){
                this.itemEditado = {...item};
                this.dialogConselhoIndicacaoRecurso = true;
            },
            ...mapActions({
                obterRecursoIndicacao: 'conselho/obterRecursoIndicacao',
            }),
        },

		mounted() {
            this.loading = true;
            this.headers.push({
                text: 'Ações',
                sortable: false,
            });

            this.obterRecursoIndicacao().finally(() => {
                this.loading = false;
            });
        }
    }
</script>