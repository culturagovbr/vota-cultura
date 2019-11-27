<template>
	<v-container>
		<v-layout>
			<v-flex>
				<v-card>
					<v-card-text>
						<v-data-table
							:headers="headers"
							:items="historico"
							:total-items="totalItems"
							item-key="co_conselho_indicacao_habilitacao_historico"
							class="elevation-1"
						>
							<template
								slot="items"
								slot-scope="props"
							>
								<td>{{ props.item.dh_avaliacao }}</td>
								<td>{{ props.item.usuario_avaliador.no_nome }}</td>
								<td><span :class="mapCodeResultadoAvaliacaoToString(props.item.st_avaliacao).color">{{ mapCodeResultadoAvaliacaoToString(props.item.st_avaliacao).text }}</span></td>
								<td>
									<v-btn
										depressed
										outline
										icon
										fab
										dark
										color="primary"
										small
										@click="showDialogParecer(props.item.ds_parecer)"
									>
										<v-icon>
											remove_red_eye
										</v-icon>
									</v-btn>
								</td>
							</template>
						</v-data-table>
					</v-card-text>
				</v-card>
			</v-flex>
		</v-layout>

		<v-layout justify-center>
			<v-dialog
				v-model="dialogParecer"
				max-width="720"
			>
				<v-card>
					<v-toolbar
						dark
						color="primary"
					>
						<h3><span class="font-weight-bold font">Parecer</span></h3>
					</v-toolbar>

					<v-card-text>
						{{ dsParecer }}
					</v-card-text>

					<v-card-actions>
						<v-spacer />

						<v-btn
							color="red darken-1"
							text
							flat
							@click="hideDialogParecer"
						>
							Fechar
						</v-btn>
					</v-card-actions>
				</v-card>
			</v-dialog>
		</v-layout>
	</v-container>
</template>

<script>
    export default {
        name: 'ConselhoIndicacaoHistoricoAlteracao',
        props: {
            historico: {
                type: Array,
                default: () => [],
            },
        },
	    methods : {
            showDialogParecer(text) {
                this.dialogParecer = true;
				this.dsParecer = text;
            },
		    hideDialogParecer() {
                this.dialogParecer = false;
                this.dsParecer = '';
		    },
            mapCodeResultadoAvaliacaoToString(stParecer) {
                let parecer = {};
                switch (parseInt(stParecer)) {
                    case 0:
                        parecer = {
                            text: 'Inabilitado',
                            color: "red--text"
                        };
                        break;
                    case 1:
                        parecer = {
                            text: 'Habilitado',
                            color: 'green--text'
                        };
                        break;
                    default:
                        parecer = { text: ' - ' , color: '' };
                        break;
                }
                return parecer;
            },
	    },
        data() {
            return {
                dialogParecer : false,
                dsParecer : '',
                totalItems: 0,
	            listaHistorico : [],
                headers: [
                    {
                        text: 'Data',
                        value: 'dh_avaliacao',
                    },
                    {
                        text: 'Avaliador',
                        value: 'no_avaliador',
                    },
                    {
                        text: 'Resultado da habilitação',
                        value: 'st_avaliacao',
                    },
                    {
                        text: 'Parecer',
                        sortable : false
                    }
                ],
            }
        }
    }
</script>