<template>
	<v-dialog
		v-model="dialog"
		fullscreen
		hide-overlay
		transition="dialog-bottom-transition"
	>
		<v-card>
			<v-toolbar dark color="primary">
				<v-btn icon dark @click="dialog = false">
					<v-icon>close</v-icon>
				</v-btn>

				<v-toolbar-title>
					Recurso da indicação - Conselho de cultura
				</v-toolbar-title>

				<v-spacer/>
			</v-toolbar>

			<v-card-text>
				<v-container>
					<v-card>
						<v-tabs v-model="activeTab" centered :color="'grey darken-3'" dark slider-color="yellow">
							<v-tab href='#dados-conselho'>DADOS DO CONSELHO</v-tab>
							<v-tab href='#recurso'>RECURSO</v-tab>
						</v-tabs>
						<v-tabs-items class="white elevation-1" v-model="activeTab">
							<v-tab-item value="dados-conselho">
								<v-card
									flat
									class="pa-4"
								>
									<conselho-detalhes-inscricao-visualizacao />
								</v-card>
							</v-tab-item>
							<v-tab-item value="recurso">
								<conselho-indicacao-habilitacao-recurso
									:indicacao="formulario.recurso"
									:readonly="readonly"
								/>
							</v-tab-item>
						</v-tabs-items>
					</v-card>

					<v-layout mt-4>
						<v-flex md12 text-xs-center>
							<v-btn
								@click="dialog = false"
							>
								<v-icon left>
									undo
								</v-icon>
								Voltar
							</v-btn>
						</v-flex>
					</v-layout>
				</v-container>
			</v-card-text>

		</v-card>
	</v-dialog>
</template>
<script>
    import {mapGetters, mapActions} from 'vuex';
    import {documentosIndicacao} from '../api/documentosIndicacao';
    import ConselhoIndicacaoHabilitacaoRecurso from "./components/ConselhoIndicacaoHabilitacaoRecurso";
    import ConselhoDetalhesInscricaoVisualizacao from "./ConselhoDetalhesInscricaoVisualizacao";
    import Vue from 'vue';
    import CKEditor from '@ckeditor/ckeditor5-vue';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import '@ckeditor/ckeditor5-build-classic/build/translations/pt-br';

    Vue.use(CKEditor);

    export default {
        name: 'ConselhoIndicacaoRecursoDialog',
        components: {ConselhoIndicacaoHabilitacaoRecurso, ConselhoDetalhesInscricaoVisualizacao},
        props: {
            value: {
                type: Boolean,
                default: false,
            },
            dados: {
                type: Object,
                default: () => {
                },
            },
            readonly: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                coConselho : null,
                listaUF: [],
                listaMunicipios: [],
                editor: ClassicEditor,
                editorConfig: {
                    placeholder: 'Parecer',
                    toolbar: [],
                    language: 'pt-br',
                },
                activeTab: 'recurso',
                dialog: false,
                formularioInicial: {
                    ds_recurso: '',
                    ds_curriculo: '',
                    anexo: [],
                    conselhoHabilitacao: {
                        co_conselho_habilitacao: null,
                        co_conselho: null,
                        st_avaliacao: null,
                        ds_parecer: null,
                    },
                },
                formulario: {},
                rules: {
                    required: value => !!value || 'Este campo é obrigatório',
                    minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
                    tamanhoMaximo3000Caracteres: value => (!!value && value.length <= 3000) || 'Máximo 3000 caracteres',
                    tamanhoMaximo500Caracteres: value => (!!value && value.length <= 500) || 'Máximo 500 caracteres',
                },
                usuarioLogado: {},
                fotoIndicado: {},
            };
        },
        computed: {
            ...mapGetters({
                perfis: 'conta/perfis',
                perfisInscricao: 'conta/perfisInscricao',
                estadosGetter: 'localidade/estados',
                municipiosGetter: 'localidade/municipios',
            }),
        },
        watch: {
            coConselho(valor) {
                this.obterDadosConselho(valor);
            },
            estadosGetter() {
                this.listaUF = [
                    ...this.estadosGetter
                ]
            },
            municipiosGetter() {
                this.listaMunicipios = [
                    ...this.municipiosGetter
                ];
            },
            value(valor) {
                this.dialog = valor;
                if(!valor){
                    this.formulario = {};
                }
            },
            dialog(valor) {
                this.$emit('input', valor);
            },
            dados(valor) {
                let avaliacaoHabilitacao = valor.indicacaoHabilitacao[0];
                let recurso = avaliacaoHabilitacao.recurso;
                let indicado = avaliacaoHabilitacao.indicado;
                let endereco = avaliacaoHabilitacao.endereco;

                this.formulario = {...valor};
                this.formulario.recurso = {
                    ds_recurso : recurso.ds_recurso,
                    cpf_indicado_formatado : indicado.nu_cpf_indicado,
                    no_indicado : indicado.no_indicado,
                    dt_nascimento_indicado : indicado.dt_nascimento_indicado.replace(' 00:00:00.000000', '').split('-').reverse().join('/'),
                    foto_indicado : avaliacaoHabilitacao.foto_indicado,
                    ds_curriculo : indicado.ds_curriculo,
	                endereco :  endereco
                };

                this.formulario.avaliacaoHabilitacao = {
                    st_avaliacao : avaliacaoHabilitacao.st_avaliacao,
                    ds_parecer : avaliacaoHabilitacao.ds_parecer,
                };

                this.coConselho = avaliacaoHabilitacao.conselho.co_conselho;
            },
        },
        methods: {
            mapCodeResultadoAvaliacaoToString(stParecer) {
                let strParecer = {};
                switch (stParecer) {
                    case false:
                        strParecer = {
                            text: "Inabilitado",
                            color: "red--text"
                        };
                        break;
                    case true:
                        strParecer = {
                            text: "Habilitado",
                            color: "green--text"
                        };
                        break;
                    default:
                        strParecer = {text: " - ", color: ""};
                        break;
                }

                return strParecer;
            },
            ...mapActions({
                downloadArquivo: 'shared/downloadArquivo',
                obterMunicipios: 'localidade/obterMunicipios',
                obterDadosConselho: 'conselho/obterDadosConselho',
            }),
            obterDescricaoDocumento(tpArquivo) {
                const indiceDocumento = documentosIndicacao.findIndex(elemento => (elemento || {}).slug === tpArquivo);
                if (indiceDocumento === -1) {
                    return 'Documento inválido';
                }
                return documentosIndicacao[indiceDocumento].descricao;
            },
        },
        mounted() {
            this.usuarioLogado = this.usuario;
        },
    };
</script>
