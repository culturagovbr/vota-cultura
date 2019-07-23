<template>
  <v-container>
    <v-layout wrap>
      <v-flex
        offset-xs3
        xs6
      >
        <v-card
          max-width="900"
        >
          <v-toolbar
            dark
            color="primary"
          >
            <v-toolbar-title>Confirmação dos dados</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-container>
              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.cnpj"
                    label="CNPJ"
                    append-icon="people"
                    mask="##.###.###/####-##"
                    disabled
                  />
                </v-flex>
              </v-layout>


              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.nomeOrganizacao"
                    label="Nome da Organização/Entidade"
                    append-icon="perm_identity"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                  v-model="organizacao.telefone"
                  label="Telefone"
                  append-icon="phone"
                  mask="(##) #####-####"
                  disabled
                />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.email"
                    label="E-mail"
                    append-icon="mail"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.sitioEletronico"
                    label="Sítio eletrônico da Organização/Entidade"
                    append-icon="public"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.cep"
                    label="CEP"
                    append-icon="my_location"
                    mask="#####-###"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.logradouro"
                    label="Logradouro"
                    append-icon="place"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.complemento"
                    label="Complemento"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    v-model="organizacao.uf"
                    :items="['DF','GO']"
                    label="Unidade da Federação da Sede"
                    append-icon="place"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.cidade"
                    label="Cidade"
                    append-icon="place"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.nomeResponsavel"
                    label="Nome do Responsável"
                    append-icon="perm_identity"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.celularResponsavel"
                    label="Celular do Responsável"
                    append-icon="phone"
                    mask="(##) #####-####"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.cpf"
                    label="CPF"
                    append-icon="person"
                    placeholder="999.999.999.99"
                    mask="###.###.###.##"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.rg"
                    label="RG"
                    append-icon="person"
                    placeholder="99.999.999-9"
                    mask="##.###.###-#"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="organizacao.emailResponsavel"
                    label="E-mail do Responsável"
                    append-icon="mail"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-radio-group
                    v-model="organizacao.segmento"
                    label="Informe o segmento no qual pretende concorrer">
                    <v-radio
                      label="Técnico-artístico"
                      value="radio-1"
                      disabled
                    />
                    <v-radio
                      label="Patrimônio cultural"
                      value="radio-2"
                      disabled
                    />
                    <v-radio
                      label="Culturas populares"
                      value="radio-3"
                      disabled
                    />
                    <v-radio
                      label="Culturas dos povos indígenas"
                      value="radio-4"
                      disabled
                    />
                    <v-radio
                      label="Expressões culturais afro-brasileiras"
                      value="radio-5"
                      disabled
                    />
                  </v-radio-group>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    :items="['']"
                    label="Abrangência Nacional"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    :items="['']"
                    label="Abrangência Estadual"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    :items="['']"
                    label="Tempo de Funcionamento"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    :items="['']"
                    label="Nº de Associados ou Filiados"
                    disabled
                  />
                </v-flex>
              </v-layout>


              <v-layout>
                <v-flex>
                  <v-select
                    :items="['']"
                    label="Nº Atividades/projetos realizados no campo cultural a partir de 2016"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    :items="['']"
                    label="Nº Participação em instâncias de formulação de política cultural"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    :items="['']"
                    label="Abrangência de projetos realizados no campo cultural a partir de 2016"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    :items="['']"
                    label="Projetos na área de pesquisa ou produção do conhecimento no campo da cultura a partir de 2016"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-checkbox
                :rules="[v => !!v || 'É necessário concordar para enviar!']"
                label=" Declaro ser representante da organização ou entidade cultural inscrita neste edital e designado (a) para o fornecimento das informações solicitadas e que assumo total responsabilidade pela veracidade das informações apresentadas.

Declaro estar ciente de que qualquer inexatidão nos itens informados me sujeitará às penalidades previstas no Art. 299 do Código Penal brasileiro, sem prejuízo de outras medidas administrativas e legais cabíveis."
                required
              ></v-checkbox>

              <v-layout
                wrap
                align-center
              >
                <v-flex offset-xs4>
                  <v-btn
                    to="/inscricao/eleitor"
                  >
                    Cancelar
                  </v-btn>
                  <v-btn
                    color="primary"
                  >
                    Confirmar
                  </v-btn>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  export default {
    name: 'RevisaoEleitor',
    data: () => ({
      organizacao: {
        cnpj: '78857057000107',
        nomeOrganizacao: 'Nome de teste',
        telefone: '6192964545',
        email: 'organizao.teste@gmail.com ',
        sitioEletronico: 'www.google.com.br',
        cep: '728456987',
        logradouro: 'Bairro do teste',
        complemento: 'Complemento de teste',
        uf: 'DF',
        cidade: 'Brasília',
        nomeResponsavel: 'Responsável da Silva',
        celularResponsavel: '61992955454',
        cpf: '01457789563',
        rg: '3258745',
        emailResponsavel: 'responsavel.oliveira@gmail.com',
        segmento: 'radio-1',
      },
    }),

  };
</script>
