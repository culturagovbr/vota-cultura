<template>
    <v-container>
        <v-card>
            <v-toolbar
              dark
              color="primary">
                <v-toolbar-title>Confirmação dos dados</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                <v-layout md9>
                    <v-flex md9 xm12 sm12 lg12>

                            <v-container fluid grid-list-xl>

                                <h2>Dados do Eleitor</h2>

                                <v-layout wrap align-center>
                                    <v-flex xs12 sm4>
                                        <v-text-field
                                          readonly
                                          v-model="cpf"
                                          label="*CPF"
                                          append-icon="account_circle"
                                          readonly
                                          mask="###.###.###-##"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field
                                          readonly
                                          v-model="nomeCompleto"
                                          label="*Nome completo"
                                          append-icon="perm_identity"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm2>
                                        <v-text-field
                                          readonly
                                          v-model="rg"
                                          label="*RG"
                                          append-icon="account_circle"
                                          mask="##.###.###-#"
                                        ></v-text-field>
                                    </v-flex>
                                </v-layout>

                                <v-layout wrap align-center>
                                    <v-flex xs12 sm6>
                                        <v-text-field
                                          readonly
                                          v-model="email"
                                          label="*E-mail"
                                          append-icon="mail"
                                          placeholder="email@exemplo.com"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field
                                          readonly
                                          v-model="emailConfirmacao"
                                          label="*Confirmar e-mail"
                                          append-icon="mail"
                                          placeholder="email@exemplo.com"
                                        ></v-text-field>
                                    </v-flex>
                                </v-layout>

                                <v-layout wrap align-center>
                                    <v-flex xs12 sm4>
                                        <v-select
                                          readonly
                                          :items="['Brasileiro','Outros']"
                                          label="*Nacionalidade"
                                          append-icon="place"
                                        ></v-select>
                                    </v-flex>
                                    <v-flex xs12 sm4>
                                        <v-select
                                          readonly
                                          v-model="uf"
                                          :items="['DF','GO']"
                                          label="*Unidade da Federação"
                                          append-icon="place"
                                        ></v-select>
                                    </v-flex>
                                </v-layout>

                                <v-btn>
                                    sdfsdf
                                </v-btn>

                                <v-checkbox
                                  v-validate="'required'"
                                  :error-messages="errors.collect('checkbox')"
                                  value="1"
                                  label="Option"
                                  data-vv-name="checkbox"
                                  type="checkbox"
                                  required
                                ></v-checkbox>

                            </v-container>

                    </v-flex>
                </v-layout>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        name: 'RevisaoEleitor',
        data: () => ({
          cpf: '04752796112',
          nomeCompleto: 'Pedro Philipe',
          rg: '3291634',
          email: 'pedro.oliveira@basis.com',
          emailConfirmacao: 'pedro.oliveira@basis.com',
          nacionalidade: 'Brasileiro',
          uf: 'GO'
    }),

    };
</script>
