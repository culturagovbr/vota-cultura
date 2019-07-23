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
              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="conselho.cpf"
                    disabled
                    label="CPF"
                    append-icon="account_circle"
                    mask="###.###.###-##"
                  />
                </v-flex>
              </v-layout>
              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="conselho.nomeCompleto"
                    disabled
                    label="Nome completo"
                    append-icon="perm_identity"
                  />
                </v-flex>
              </v-layout>
              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="conselho.rg"
                    disabled
                    label="RG"
                    append-icon="account_circle"
                    mask="##.###.###-#"
                  />
                </v-flex>
              </v-layout>

              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-text-field
                    v-model="conselho.email"
                    disabled
                    label="E-mail"
                    append-icon="mail"
                    placeholder="email@exemplo.com"
                  />
                </v-flex>
              </v-layout>

              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-select
                    v-model="conselho.nacionalidade"
                    disabled
                    :items="['Brasileiro','Outros']"
                    label="Nacionalidade"
                    append-icon="place"
                  />
                </v-flex>
              </v-layout>
              <v-layout
                wrap
                align-center
              >
                <v-flex>
                  <v-select
                    v-model="conselho.uf"
                    disabled
                    :items="['DF','GO']"
                    label="Unidade da Federação"
                    append-icon="place"
                  />
                </v-flex>
              </v-layout>
              <v-layout
                wrap
                align-center
              >
                <v-flex offset-xs4>
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
      cpf: '04752796112',
      nomeCompleto: 'Pedro Philipe',
      rg: '3291634',
      email: 'pedro.oliveira@basis.com',
      emailConfirmacao: 'pedro.oliveira@basis.com',
      nacionalidade: 'Brasileiro',
      uf: 'GO',
    },
  }),

};
</script>
