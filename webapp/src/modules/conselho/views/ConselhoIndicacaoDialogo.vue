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
					Indicação - Conselho de cultura
				</v-toolbar-title>

				<v-spacer/>
			</v-toolbar>

			<v-card-text>
				<v-container>
					<v-card>
						<v-tabs v-model="activeTab" centered :color="'grey darken-3'" dark slider-color="yellow">
							<v-tab href='#dados-indicado'>DADOS DO INDICADO</v-tab>
							<v-tab href='#resultado-habilitacao'>RESULTADO DA HABILITAÇÃO</v-tab>
							<v-tab href='#recurso'>RECURSO</v-tab>
						</v-tabs>
						<v-tabs-items class="white elevation-1" v-model="activeTab">
							<v-tab-item value="dados-indicado">
								<v-card>
									<v-card-text>
										<v-container>
											<v-container grid-list-md>
												<v-layout row wrap>
													<v-flex>
														<v-card>
															<v-toolbar color="white elevation-1">
																<v-toolbar-title>Dados básicos</v-toolbar-title>
															</v-toolbar>
															<v-card-text>
																<v-container
																	grid-list-md
																>
																	<v-layout>
																		<v-flex md8>
																			<v-layout>
																				<v-flex md12>
																					<v-text-field
																						v-model="formulario.nu_cpf_indicado"
																						placeholder="999.999.999-99"
																						append-icon="person"
																						name="login"
																						label="*CPF"
																						mask="###.###.###-##"
																						validate-on-blur
																						type="text"
																						disabled
																					/>
																				</v-flex>
																			</v-layout>
																			<v-layout>
																				<v-flex md12>
																					<v-text-field
																						v-model="formulario.no_indicado"
																						append-icon="person_outline"
																						name="login"
																						label="*Nome completo"
																						validate-on-blur
																						type="text"
																						:disabled="true"
																					/>
																				</v-flex>
																			</v-layout>
																			<v-layout>
																				<v-flex md12>
																					<v-text-field
																						v-model="formulario.dt_nascimento_indicado"
																						label="*Data de Nascimento"
																						append-icon="event"
																						placeholder="ex: 01/12/2019"
																						return-masked-value
																						mask="##/##/####"
																						disabled
																					/>
																				</v-flex>
																			</v-layout>

																			<v-layout>
																				<v-flex md12>
																					<v-text-field
																						v-model="(((formulario.endereco || {}).municipio || {}).uf || {}).no_uf"
																						label="Unidade da federação em que reside"
																						append-icon="place"
																						disabled
																						box
																					/>
																				</v-flex>
																			</v-layout>
																			<v-layout>
																				<v-flex md12>
																					<v-text-field
																						v-model="((formulario.endereco || {} ).municipio || {}).no_municipio"
																						label="Cidade em que reside"
																						append-icon="place"
																						box
																						disabled
																					/>
																				</v-flex>
																			</v-layout>

																			<v-layout>
																				<v-flex md12>
																					<v-textarea
																						v-model="formulario.ds_curriculo"
																						label="* Currículo resumido para a candidatura"
																						rows="13"
																						row-height="28"
																						:counter="1000"
																						box
																						auto-grow
																						disabled
																					/>
																				</v-flex>
																			</v-layout>
																		</v-flex>
																		<v-flex
																			md4
																			class="text-md-center"
																		>
																				<img
																					width="260"
																					style="border-radius:10px;"
																					:src="(formulario || {}).foto_indicado"
																				>
																		</v-flex>
																	</v-layout>
																</v-container>
															</v-card-text>
														</v-card>
													</v-flex>

													<v-flex v-if="(formulario.arquivos || []).length > 0">
														<v-container
															grid-list-md
														>
															<div class="ma-4 text-justify">
																<v-toolbar color="white darken-3 title">
																	Documentação
																</v-toolbar>
																<v-card class="elevation-1">
																	<v-container
																		fluid
																		grid-list-xl
																	>
																		<v-layout>
																			<v-flex class="pa-3">
																				<v-list
																					two-line
																				>
																					<template>
																						<v-layout
																							v-for="(documento, index) in formulario.arquivos"
																							:key="index"
																						>
																							<v-flex
																								class="text-md-left"
																								sm10
																							>
																		<span
																			v-html="obterDescricaoDocumento(documento.tp_arquivo)"/>
																							</v-flex>
																							<v-flex sm1>
																								<v-icon
																									right
																									size="32px"
																									color="blue darken-4"
																									@click="downloadArquivo(documento.co_arquivo)"
																								>
																									cloud_download
																								</v-icon>
																							</v-flex>
																						</v-layout>
																					</template>
																				</v-list>
																			</v-flex>
																		</v-layout>
																	</v-container>
																</v-card>
															</div>
														</v-container>
													</v-flex>
												</v-layout>
											</v-container>
											<v-footer
												height="auto"
												color="white lighten-1 justify-center"
											>
											</v-footer>
										</v-container>
									</v-card-text>
								</v-card>
							</v-tab-item>
							<v-tab-item value="resultado-habilitacao">
								<v-flex class="pa-3 grey--text subheading">
									<v-container>
										<v-layout>
											<v-flex class="font-weight-bold">
												<span>Resultado da habilitação:</span>
												<span
													:class="mapCodeResultadoAvaliacaoToString((formulario.avaliacaoHabilitacao || {}).st_avaliacao).color"> {{mapCodeResultadoAvaliacaoToString((formulario.avaliacaoHabilitacao || {}).st_avaliacao).text }}</span>
											</v-flex>
										</v-layout>
										<v-layout class="mt-2">
											<v-flex>
												<span class="font-weight-bold">Parecer:</span>
<!--												<v-textarea-->
<!--													class="mt-2"-->
<!--													v-html="(formulario.avaliacaoHabilitacao || {}).ds_parecer"-->
<!--													name="input-7-1"-->
<!--													solo-->
<!--													label="Descrição do parecer"-->
<!--													rows="13"-->
<!--													row-height="28"-->
<!--													box-->
<!--													disabled-->
<!--													auto-grow-->
<!--													:readonly="true"-->
<!--												/>-->
												<ckeditor
													:disabled="true"
													:editor="editor"
													v-model="(formulario.avaliacaoHabilitacao || {}).ds_parecer"
													:config="editorConfig">

												</ckeditor>
											</v-flex>
										</v-layout>
									</v-container>

								</v-flex>
							</v-tab-item>
							<v-tab-item value="recurso">
								<conselho-indicacao-habilitacao-recurso
									:indicacao="formulario"
									:readonly="readonly"
									:listaUF="this.listaUF"
									:listaMunicipios="this.listaMunicipios"
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
    import Vue from 'vue';
    import CKEditor from '@ckeditor/ckeditor5-vue';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import '@ckeditor/ckeditor5-build-classic/build/translations/pt-br';

    Vue.use(CKEditor);

    export default {
        name: 'ConselhoIndicacaoDialogo',
        components: {ConselhoIndicacaoHabilitacaoRecurso},
        props: {
            value: {
                type: Boolean,
                default: false,
            },
            conselho: {
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
            conselho(valor) {
                this.formulario = {...valor};
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
