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

		<v-layout>
			<v-flex text-xs-right>
				<v-btn round outline color="primary" dark @click="dialogCadastrarIndicado = true">
					+ Indicar
				</v-btn>
			</v-flex>
		</v-layout>

		<v-layout mt-4>
			<v-flex>
				<v-data-table
					:headers="headers"
					:items="organizacaoGetter"
					:expand="expand"
					item-key="no_indicado"
					:loading="loading"
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
							<td>&nbsp;</td>
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
				<v-btn small color="primary">CONCLUIR</v-btn>
			</v-flex>
		</v-layout>

		<dialog-cadastrar-indicado-organizacao v-model="dialogCadastrarIndicado" />

	</v-container>
</template>

<script>
    import { mapActions, mapGetters } from "vuex";
	import DialogCadastrarIndicadoOrganizacao from './components/DialogCadastrarIndicadoOrganizacao';
	export default {
	    components: {DialogCadastrarIndicadoOrganizacao},
        data () {
            return {
                loading : true,
                dialogCadastrarIndicado : false,
                expand: true,
                headers: [
                    { text: 'CPF', value: 'nu_cpf_indicado' },
                    { text: 'Nome', value: 'no_indicado' },
                    { text: 'Data de nascimento', value: 'dt_nascimento_indicado' },
                    { text: 'Posição', value: 'tp_indicado' },
                    { text: 'Organização/entidade', value: 'organizacao.no_organizacao' },
                    { text: 'Segmento', value: 'organizacao.segmento.ds_detalhamento' },
                    { text: 'Ações', sortable:  false},
                ]
            }
        },
        computed: {
            ...mapGetters({
                usuario: "conta/usuario",
                organizacaoGetter: "organizacao/organizacaoIndicacao"
            })
        },
        methods: {
            ...mapActions({
                obterDadosOrganizacaoIndicacao:
                    "organizacao/obterDadosOrganizacaoIndicacao",
                definirMensagemSucesso: "app/setMensagemSucesso",
                definirMensagemErro: "app/setMensagemErro",
            }),
        },
        mounted() {
            const self = this;
            self.loading = true;
            self
                .obterDadosOrganizacaoIndicacao()
                .finally(() => {
                    self.loading = false;
                });
        }

	}
</script>