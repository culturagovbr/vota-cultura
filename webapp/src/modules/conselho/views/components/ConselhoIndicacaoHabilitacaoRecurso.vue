<template>
	<div>
		<v-container v-if="Object.keys((((formulario || {}).avaliacaoHabilitacao || {}).recurso || {})).length <= 0">
			<span class="subheading grey--text">Não existe recurso cadastrado</span>
		</v-container>
		<div v-else>
			<v-container>

				<v-card class="elevation-1 pa-2">
					<v-card-text class="layout column subheading grey--text">
						<v-layout>
							<v-flex xs12 sm12>
								Ilmo Sr. Secretário da Diversidade Cultural,
								<div class="mt-4">
									Com base no item 6 desta CHAMADA PÚBLICA PARA COMPOSIÇÃO DO CONSELHO NACIONAL DE POLÍTICA
									CULTURAL <br/> (CNPC) NO TRIÊNIO 2019/2022, venho interpor recurso em face do resultado
									na
									etapa de habilitação do indicado, pelos motivos abaixo<br/> descritos:
								</div>

								<v-flex class="mt-2">
									<v-textarea
										:readonly="readonly"
										v-model="(((formulario || {}).avaliacaoHabilitacao || {}).recurso || {}).ds_recurso"
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
													e-mail votacultura@cidadania.gov.br informando no assunto: Recurso
													de indicaço, o nome indicado e o nome do conselho.
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

						<v-layout>
							<v-flex mt-4>
								<v-alert :value="true" color="#FCF8E3" style="color: #B79F28;border: 0">
									<strong>Atenção!</strong> Os dados básicos podem ser alterados, exceto o CPF e o nome.
								</v-alert>
							</v-flex>
						</v-layout>

						<v-container grid-list-md fluid>
							<v-layout row wrap>
								<v-flex xs5>
									<v-flex mt-2>
										<span class="font-weight-bold">CPF:</span> {{formulario.cpf_indicado_formatado}}
									</v-flex>

									<v-flex mt-2>
										<span class="font-weight-bold">Nome:</span> {{formulario.no_indicado}}
									</v-flex>

									<v-flex mt-2>
										<span class="font-weight-bold">Unidade da federação em que reside:</span>
										<v-select
											v-model="formulario.endereco.co_ibge"
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

								<v-flex xs4>
									<v-flex mt-2>&nbsp;</v-flex>

									<v-flex mt-2>
										<span class="font-weight-bold">Data de nascimento:</span> {{formulario.dt_nascimento_indicado}}
									</v-flex>

									<v-flex mt-2>
										<span class="font-weight-bold">Cidade em que reside:</span>
										<v-select
											v-model="formulario.endereco.co_municipio"
											:items="listaMunicipios"
											label="*Cidade em que reside"
											append-icon="place"
											item-value="co_municipio"
											item-text="no_municipio"
											box
											:readonly="readonly"
											:disabled="readonly"
											:rules="[rules.required]"
										/>
									</v-flex>
								</v-flex>

								<v-flex xs3>
									<div v-if="(formulario || {}).foto_indicado || ((formulario || {}).foto_indicado && readonly)">
										<img
											class="ml-xl-6"
											width="150px"
											height="170px"
											style="border-radius:10px;margin-left: 40px;"
											:src="(formulario || {}).foto_indicado"
										>
									</div>
									<file
										v-else
										label-idle="Clique aqui para alterar a foto"
										:readonly="readonly"
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
										label="Currículo resumido para a candidatura"
										auto-grow
										:counter="1000"
										:rules="[rules.required, rules.tamanhoMaximoCaracteres]"
										:readonly="readonly"
									/>
								</v-flex>
							</v-layout>

							<v-layout mt-2>
								<v-flex md12 text-xs-center v-if="readonly">
									Atenção, O texto do currículo resumido ficará disponível na plataforma de votação e será
									a defesa da candidatura do indicado.
								</v-flex>
							</v-layout>
						</v-container>
					</v-card-text>
				</v-card>

			</v-container>
		</div>

	</div>
</template>

<script>
    import File from '@/core/components/upload/File';

    export default {
        components: {File},
        props: {
            indicacao: {
                type: Object,
                default: () => {
                },
            },
            readonly: {
                type: Boolean,
                default: false,
            },
	        listaMunicipios: {
	            type: Array,
	            default: [],
	        },
	        listaUF: {
	            type: Array,
	            default: [],
	        },
        },
        watch: {
            indicacao(valor) {
                this.formulario = valor;
            },
            listaUf(value) {
                this.listaUF = value;
            },
            listaMunicipios(valor) {
                this.listaMunicipios = valor;
            },
        },
        data() {
            return {
                formulario : {},
                rules: {
                    required: value => !!value || 'Este campo é obrigatório',
                    minCaracter: value => value.length >= 8 || 'Mínimo 8 caracteres',
                    tamanhoMaximoCaracteres: value => (!!value && value.length <= 3000) || 'Máximo 3000 caracteres',
                },
            }
        }
    }
</script>