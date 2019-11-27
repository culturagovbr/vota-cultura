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

			<v-card>
				<v-card-text>
					<v-layout>
						<v-flex>
							<v-alert
								:value="true"
								icon="warning"
								color="yellow lighten-3"
								class="black--text"
							>
								Não houve entidade habilitada para o segmento de culturas dos povos indígenas.
								Nesse sentido, a designação do representante da sociedade civil se dará por meio de
								lista tríplice elaborada pela área técnica correspondente na  Secretaria Especial de
								Cultura, conforme item 4.1.6 do edital.
							</v-alert>

						</v-flex>

					</v-layout>

				</v-card-text>
			</v-card>

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
				</v-tab-item>
			</v-tabs-items>
		</v-card>


	</v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import DialogCadastrarIndicadoOrganizacao from './components/DialogCadastrarIndicadoOrganizacao';

    export default {
        name: 'OrganizacaoResultadoFinalIndicado',
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
                    {text: 'Posição', value: 'tp_indicado'},
                    {text: 'Organização/entidade', value: 'organizacao.no_organizacao'},
                    {text: 'Segmento', value: 'organizacao.segmento.ds_detalhamento'},
                    {text: 'Mini-currículo', sortable : false}
                ]
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
            ...mapActions({
                obterDadosOrganizacaoIndicacao: "organizacao/obterDadosOrganizacaoIndicacao",
                deletarOrganizacaoIndicacao: "organizacao/deletarOrganizacaoIndicacao",
                definirMensagemSucesso: "app/setMensagemSucesso",
                definirMensagemErro: "app/setMensagemErro",
                concluirOrganizacaoIndicacao: "fase/concluirOrganizacaoIndicacao",
                obterFases: 'fase/obterFases',
            }),
        },
        mounted() {
            const self = this;
            self.loading = true;
            self.obterDadosOrganizacaoIndicacao()
                .finally(() => {
                    self.loading = false;
                });

        }
    }
</script>