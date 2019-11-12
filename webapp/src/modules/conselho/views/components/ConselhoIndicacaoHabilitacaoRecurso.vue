<template>
	<div>
		<v-container
			v-if="Object.keys(formulario).length <= 0 && readonly">
			<span class="subheading grey--text">Não existe recurso cadastrado</span>
		</v-container>
		<div v-else>
			<v-form
				ref="formConselhoIndicacaoHabilitacao"
				v-model="isValidForm"
				lazy-validation
			>
				<v-container>
					<v-card class="elevation-1 pa-2">
						<v-card-text class="layout column subheading grey--text">
							<v-layout>
								<v-flex xs12 sm12>
									Ilmo Sr. Secretário da Diversidade Cultural,
									<div class="mt-4">
										Com base no item 6 desta CHAMADA PÚBLICA PARA COMPOSIÇÃO DO CONSELHO NACIONAL DE
										POLÍTICA CULTURAL (CNPC) NO TRIÊNIO 2019/2022, venho interpor recurso em face do
										resultado na etapa de habilitação do indicado, pelos motivos abaixo descritos:
									</div>

									<v-flex class="mt-2">

										<v-textarea
											:readonly="readonly"
											v-model="formulario.ds_recurso"
											name="input-7-1"
											box
											solo
											label="Descrição do recurso"
											auto-grow
											:placeholder="'Digite seu recurso aqui.'"
											:counter="3000"
											:rules="[rules.required, rules.tamanhoMaximoCaracteres]"
										/>
									</v-flex>

									<v-layout class="mt-2">
										<v-flex>
											<v-card class="elevation-1 text-md-center">
												<v-card-text>
													<div class="grey--text">
														Caso seja necessário o envio de documentos, encaminhar para o
														e-mail votacultura@cidadania.gov.br informando no assunto:
														Recurso
														de indicação, o nome indicado e o nome do conselho.
													</div>
												</v-card-text>
											</v-card>
										</v-flex>
									</v-layout>
								</v-flex>
							</v-layout>
						</v-card-text>
					</v-card>
				</v-container>
				<v-container>
					<v-card class="elevation-1 pa-2">
						<v-card-text class="layout column subheading grey--text">
							<v-layout>
								<v-flex>
									<v-toolbar dark color="primary">
										<v-toolbar-title>
											DADOS BÁSICOS
										</v-toolbar-title>
										<v-spacer/>
									</v-toolbar>
								</v-flex>
							</v-layout>

							<v-layout v-if="!readonly">
								<v-flex mt-4>
									<v-alert :value="true" color="#FCF8E3" style="color: #B79F28;border: 0">
										<strong>Atenção!</strong> Os dados básicos podem ser alterados, exceto o CPF e o
										nome.
									</v-alert>
								</v-flex>
							</v-layout>

							<v-container>
								<v-layout>
									<v-flex xs4>
										<v-flex mt-2>
											<v-text-field
												label="CPF"
												v-model="formulario.cpf_indicado_formatado"
												:readonly="true"
												:disabled="true"
											/>
										</v-flex>

										<v-flex mt-2>
											<v-text-field
												label="Nome"
												v-model="formulario.no_indicado"
												:readonly="true"
												:disabled="true"
											/>
										</v-flex>

										<v-flex
											md12
											mt-2
										>
											<v-select
												v-model="municipio"
												:items="listaMunicipios"
												label="*Cidade em que reside"
												append-icon="place"
												item-value="co_municipio"
												item-text="no_municipio"
												box
												:disabled="readonly"
												:rules="[rules.required]"
											/>
										</v-flex>
									</v-flex>

									<v-flex mt-2 xs1>&nbsp;</v-flex>

									<v-flex xs3>
										<v-flex mt-2>
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
															v-model="formulario.dt_nascimento_indicado"
															label="*Data de nascimento"
															append-icon="event"
															placeholder="ex: 01/12/2019"
															return-masked-value
															mask="##/##/####"
															required
															:rules="[rules.required, rules.dataAniversario]"
															v-on="on"
															:readonly="readonly"
															:disabled="readonly"
														/>
													</template>
													<v-date-picker
														v-model="date"
														locale="pt-BR"
														scrollable
														:readonly="readonly"
														:disabled="readonly"
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

										<v-flex mt-2>
											<v-select
												v-model="uf"
												:items="listaUF"
												label="*Unidade da federação em que reside"
												append-icon="place"
												item-value="co_ibge"
												item-text="no_uf"
												required
												box
												:rules="[rules.required]"
												:readonly="readonly"
												:disabled="readonly"
											/>
										</v-flex>
									</v-flex>

									<v-flex xs3 style="margin-left: 85px;" shrink>
										<div v-if="(formulario || {}).foto_indicado && showFilePond  || readonly"
										     style="margin-left: 50px;">
											<img
												class="ml-xl-6"
												width="150px"
												height="170px"
												style="border-radius:10px;"
												:src="(formulario || {}).foto_indicado"
											>
										</div>
										<file
											ref="indicado_foto_rosto"
											v-model="anexo"
											v-if="!readonly"
											label-idle="Clique aqui para alterar a foto"
											:accepted-file-types="['image/jpeg']"
										/>
									</v-flex>
								</v-layout>

								<v-layout mt-2>
									<v-flex xs12>
										<v-textarea
											v-model="(formulario || {}).ds_curriculo"
											name="input-7-1"
											box
											solo
											placeholder="Currículo resumido para a candidatura"
											label="Currículo resumido para a candidatura"
											auto-grow
											:counter="1000"
											:rules="[rules.required, rules.tamanhoMaximoCaracteresCurriculo]"
											:readonly="readonly"
										/>
									</v-flex>
								</v-layout>

								<v-layout mt-2 mb-4>
									<v-flex md12 text-xs-center v-if="!readonly">
										Atenção, O texto do currículo resumido ficará disponível na plataforma de
										votação e será
										a defesa da candidatura do indicado.
									</v-flex>
								</v-layout>
								<v-layout v-if="!readonly">
									<v-flex align-center text-xs-center>
										<v-btn color="primary" @click="abrirDialogoConfirmacao">
											Enviar
										</v-btn>
									</v-flex>
								</v-layout>
							</v-container>
						</v-card-text>
					</v-card>
					<v-layout justify-center>
						<v-dialog
							v-model="dialogEnviar"
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
										@click="fecharDialog()"
									>
										Não
									</v-btn>

									<v-btn
										color="green darken-1"
										text
										flat
										@click="salvar"
									>
										Sim
									</v-btn>
								</v-card-actions>
							</v-card>
						</v-dialog>
					</v-layout>
				</v-container>
			</v-form>
		</div>

	</div>
</template>

<script>
    import File from '@/core/components/upload/File';
    import { mapActions, mapGetters } from 'vuex';

    export default {
        components: {File},
	    name: 'ConselhoIndicacaoHabilitacaoRecurso',
	    computed: {
            ...mapGetters({
                usuario: 'conta/usuario',
                perfil: 'conta/perfil',
                estadosGetter: 'localidade/estados',
                municipiosGetter: 'localidade/municipios',
            })
	    },
        props: {
            indicacao: {
                type: Object,
                default: () => {
                },
            },
            readonly: {
                type: Boolean,
                default: false,
            }
        },
        methods: {
            fecharDialog(){
                this.dialogEnviar = false;

            },
            formatDate(date) {
                if (!date) return null;
                const [year, month, day] = date.split('-');
                return `${day}/${month}/${year}`;
            },
            ...mapActions({
                obterEstados: 'localidade/obterEstados',
                obterMunicipios: 'localidade/obterMunicipios',
                enviarIndicacaoConselhoRecurso: 'conselho/enviarIndicacaoConselhoRecurso',
                definirMensagemSucesso: 'app/setMensagemSucesso',
                definirMensagemErro: 'app/setMensagemErro',
            }),
            formatarDataCarbon(data) {
                const [dia, mes, ano] = data.split('/');

                return `${ano}-${(`0${mes}`).slice(-2)}-${(`0${dia}`).slice(-2)}`;
            },
	        salvar() {
                let form = Object.assign({}, this.formulario);

                let formData = {
                    co_conselho_indicacao_habilitacao : form.avaliacaoHabilitacao.co_conselho_indicacao_habilitacao,
                    co_conselho_indicacao : form.co_conselho_indicacao,
                    ds_recurso : form.ds_recurso,
                    dt_nascimento_indicado : this.formatarDataCarbon(form.dt_nascimento_indicado),
                    endereco : { co_municipio : this.municipio, co_ibge : this.uf },
                    ds_curriculo : form.ds_curriculo,
                };

                if(this.anexo) {
                    formData.anexo = this.anexo.file;
                }

                this.enviarIndicacaoConselhoRecurso(formData).then((response) => {
                    this.definirMensagemSucesso(response.data.message);
                    this.dialogEnviar = false;
                    window.location.reload();
                });
	        },
            abrirDialogoConfirmacao() {
                if (
                    this.$refs.indicado_foto_rosto.fileHasError() ||
	                (Object.keys(this.anexo).length === 0 && this.formulario.foto_indicado.length === 0)
                ){
                    this.loading = false;
                    this.$refs.formConselhoIndicacaoHabilitacao.validate();
                    this.definirMensagemErro('A foto de rosto é obrigatória.');
                    return;
                }

                if (!this.$refs.formConselhoIndicacaoHabilitacao.validate()) {
                    return false;
                }


                this.dialogEnviar = true;
            }
        },
        watch: {
            indicacao(valor) {
                valor.ds_recurso =  (((valor || {}).avaliacaoHabilitacao || {}).recurso || {}).ds_recurso || valor.ds_recurso;
                this.formulario = Object.assign({}, valor);
                this.uf = (this.formulario.endereco || {}).co_ibge;
                this.municipio = (this.formulario.endereco || {}).co_municipio;
            },
            date() {
                this.formulario.dt_nascimento_indicado = this.formatDate(this.date);
            },
            'uf': function (coIBGE) {
                this.obterMunicipios(coIBGE);
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
            anexo(valor) {
                if (Object.keys(valor).length > 0) {
                    this.showFilePond = false;
                    this.formulario.foto_indicado = '';
                }
            }
        },
        data() {
            return {
                uf: '',
                municipio: '',
                formularioInicial : {},
                date: '',
                menu: false,
                listaUF: [],
                listaMunicipios: [],
                dialogEnviar : false,
                isValidForm : false,
                formulario: {},
                anexo: {},
                showFilePond: true,
                rules: {
                    required: value => !!value || 'Este campo é obrigatório',
                    minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
                    tamanhoMaximoCaracteres: value => (!!value && value.length <= 3000) || 'Máximo 3000 caracteres',
                    tamanhoMaximoCaracteresCurriculo: value => (!!value && value.length <= 1000) || 'Máximo 1000 caracteres',
                    dataAniversario: (value) => {
                        if (!value || value.length === 0 || !value.trim()) {
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
            }
        },
	    mounted() {
            if(!this.usuario.co_conselho && (this.perfil.no_perfil !== 'administrador' && this.perfil.no_perfil !== 'avaliador')) {
                this.definirMensagemErro('Acesso restrito aos conselhos de cultura');
                this.$router.push('/');
            }
            this.obterEstados();
        }
    }
</script>