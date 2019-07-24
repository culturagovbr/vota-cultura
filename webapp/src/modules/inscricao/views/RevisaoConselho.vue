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
                  <v-radio-group
                    v-model="conselho.tp"
                    row >
                    <v-radio
                      disabled
                      label="Estadual"
                      value="radio-1"
                    />
                    <v-radio
                      label="Capital"
                      value="radio-2"
                      disabled
                    />
                  </v-radio-group>

                </v-flex>
              </v-layout>


              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.cnpj"
                    label="CNPJ do Orgão Gestor do Conselho"
                    append-icon="people"
                    mask="##.###.###/####-##"
                    disabled
                  />
                </v-flex>
              </v-layout>


              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.nomeOrgaoGestor"
                  label="Nome do órgão gestor de cultura"
                  append-icon="people"
                  disabled
                />
                </v-flex>
              </v-layout>


              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.telefone"
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
                    v-model="conselho.email"
                    label="E-mail"
                    append-icon="mail"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.sitioEletronico"
                    label="Sítio eletrônico do conselho"
                    append-icon="public"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.cep"
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
                    v-model="conselho.logradouro"
                    label="Logradouro"
                    append-icon="place"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.complemento"
                    label="Complemento"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    v-model="conselho.uf"
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
                    v-model="conselho.cidade"
                    label="Cidade"
                    append-icon="place"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.nomeRepresentante"
                    label="Nome do Representante"
                    append-icon="perm_identity"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.celular"
                    label="Celular do representante"
                    append-icon="phone"
                    mask="(##) #####-####"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.cpf"
                    label="CPF"
                    append-icon="person"
                    mask="###.###.###.##"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.rg"
                    label="RG"
                    append-icon="person"
                    mask="##.###.###-#"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.email"
                    label="E-mail do representante"
                    append-icon="mail"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-checkbox
                :rules="[v => !!v || 'É necessário concordar para enviar!']"
                label=" Declaro ser representante do órgão coordenador do conselho, vinculado ao órgão gestor de cultura do ente federado, designado (a) para o fornecimento das informações apresentadas e que assumo total responsabilidade pela veracidade das informações apresentadas.

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
    conselho: {
      tp: 'radio-1',
      cnpj: '78857057000107',
      nomeOrgaoGestor: 'Teste de Nome',
      telefone: '6136232853',
      email: 'pedrophilipe.ti@gmail.com ',
      sitioEletronico: 'www.google.com.br',
      cep: '72853034',
      logradouro: 'Jardim do Ingá ',
      complemento: 'Rua 34 Quadra 34',
      uf: 'GO',
      cidade: 'Luziânia',
      nomeRepresentante: 'Pedro Philipe Alves de Oliveira ',
      celular: '6195465254',
      cpf: '04752154874',
      rg: '3265478',
      email: 'pedro.teste@gmail.com'
    },
  }),

};
</script>
