<template>
	<v-container>
		<v-card>
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
										:items="listarIndicacaoConselhoGetter"
										:pagination.sync="pagination_conselho"
										:total-items="totalItems"
										:loading="loading"
										:search="pesquisar"
										item-key="co_usuario"
										class="elevation-1"
									>
										<template
											slot="items"
											slot-scope="props"
										>
											<td />
											<td>{{ props.item.cpf_indicado_formatado }}</td>
											<td>{{ props.item.no_indicado }}</td>
											<td>
												<v-chip
													dark
													color="primary"
												>
													{{ props.item.endereco.municipio.uf.no_uf }}
												</v-chip>
											</td>
											<td>
												<v-chip>
													{{ props.item.conselho.no_conselho }}
												</v-chip>
											</td>
											<td>
												<v-chip v-if="!!(props.item || {}).avaliacaoHabilitacao"
												        dark
												        :color="props.item.avaliacaoHabilitacao.st_avaliacao ? 'primary' : 'error'"
												>
													{{ props.item.avaliacaoHabilitacao.st_avaliacao ? 'Habilitiado' : 'Inabilitado' }}
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
															@click="editarItemModal(props.item);"
														>
															<v-icon v-if="props.item.conselhoHabilitacao === null">
																gavel
															</v-icon>
															<v-icon v-else>
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
	</v-container>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
	export default {
	    name : 'ConselhoIndicacaoListaRecurso',
	    data: () => ({
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
                    value: 'nu_cpf_indicado',
                },
                {
                    text: 'Nome',
                    value: 'no_indicado',
                },
                {
                    text: 'Unidade da federação em que reside',
                    value: 'endereco.municipio.uf.no_uf',
                },
                {
                    text: 'Nome do conselho',
                    value: 'conselho.no_conselho',
                },
                {
                    text: 'Resultado final da habilitação',
                    value: 'avaliacaoHabilitacao.st_avaliacao',
                },
            ],
		}),
        computed: {
            ...mapGetters({
                listarIndicacaoConselhoGetter: 'conselho/listarIndicacaoConselho',
            }),
        },
        methods: {
            ...mapActions({
                obterListaIndicacaoConselho: 'conselho/obterListaIndicacaoConselho',
            }),
        },

		mounted() {
            this.loading = true;
            this.headers.push({
                text: 'Ações',
                sortable: false,
            });

            this.obterListaIndicacaoConselho().finally(() => {
                this.loading = false;
            });
        }
    }
</script>