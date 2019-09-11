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
            <v-container v-if="Object.keys(conselhoGetter).length > 0">
              <v-layout>
                <v-flex>
                  <v-radio-group
                    v-model="conselho.tp_governamental"
                    disabled
                    row
                  >
                    <v-radio
                      label="Estadual"
                      value="e"
                    />
                    <v-radio
                      label="Capital"
                      value="c"
                    />
                  </v-radio-group>
                </v-flex>
              </v-layout>


              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.nu_cnpj"
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
                    v-model="conselho.no_orgao_gestor"
                    label="Nome do órgão gestor de cultura"
                    append-icon="people"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.no_conselho"
                    label="*Nome do conselho de cultura"
                    append-icon="people"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.nu_telefone"
                    label="Telefone do Conselho"
                    append-icon="phone"
                    mask="(##) #####-####"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.ds_email"
                    label="E-mail do Conselho"
                    append-icon="mail"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.ds_sitio_eletronico"
                    label="Sítio eletrônico do conselho"
                    append-icon="public"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.endereco.nu_cep"
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
                    v-model="conselho.endereco.ds_logradouro"
                    label="Logradouro"
                    append-icon="place"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.endereco.ds_complemento"
                    label="Complemento"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    v-model="conselho.endereco.co_ibge"
                    :items="listaUF"
                    label="Unidade da Federação da Sede"
                    item-value="co_ibge"
                    item-text="no_uf"
                    append-icon="place"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    v-model="conselho.endereco.co_municipio"
                    :items="listaMunicipios"
                    label="Cidade"
                    append-icon="place"
                    item-value="co_municipio"
                    item-text="no_municipio"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.representante.no_pessoa"
                    label="Nome do representante"
                    append-icon="perm_identity"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.representante.nu_telefone"
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
                    v-model="conselho.representante.nu_cpf"
                    label="CPF"
                    append-icon="person"
                    mask="###.###.###-##"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="conselho.representante.nu_rg"
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
                    v-model="conselho.representante.ds_email"
                    label="E-mail do representante"
                    append-icon="mail"
                    disabled
                  />
                </v-flex>
              </v-layout>

              <v-checkbox
                v-model="confirmacaoDadosDeInscricao"
                :rules="[v => !!v || 'É necessário concordar para enviar!']"
                label=" Declaro ser representante do órgão coordenador do conselho, vinculado ao órgão gestor de cultura do ente federado, designado (a) para o fornecimento das informações apresentadas e que assumo total responsabilidade pela veracidade das informações apresentadas.

Declaro estar ciente de que qualquer inexatidão nos itens informados me sujeitará às penalidades previstas no Art. 299 do código penal brasileiro, sem prejuízo de outras medidas administrativas e legais cabíveis."
                required
              />

              <v-layout
                wrap
                align-center
              >
                <v-flex offset-xs4>
                  <v-btn
                    @click="voltar"
                  >
                    <!--to="/conselho/inscricao"-->
                    Voltar
                  </v-btn>
                  <v-btn
                    :disabled="!confirmacaoDadosDeInscricao"
                    color="primary"
                    @click="abrirDialogo"
                  >
                    Confirmar
                  </v-btn>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-layout justify-center>
        <v-dialog
          v-model="dialog"
          max-width="290"
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
                @click="fecharDialogo"
              >
                Não
              </v-btn>

              <v-btn
                color="green darken-1"
                text
                flat
                :loading="loading"
                :disabled="loading"
                @click="salvar"
              >
                Sim
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-layout>
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { eventHub } from '@/event';

export default {
  name: 'RevisaoConselho',
  data: () => ({
    loading: false,
    confirmacaoDadosDeInscricao: false,
    dialog: false,
    listaUF: [],
    listaMunicipios: [],
    conselho: {},
  }),
  computed: {
    ...mapGetters({
      conselhoGetter: 'conselho/conselho',
      estadosGetter: 'localidade/estados',
      municipiosGetter: 'localidade/municipios',
    }),
  },
  watch: {
    conselhoGetter(value) {
      this.conselho = value;
      this.obterMunicipios(this.conselho.co_ibge);
    },
    estadosGetter() {
      this.listaUF = this.estadosGetter;
    },
  },
  methods: {
    ...mapActions({
      enviarDadosConselho: 'conselho/enviarDadosConselho',
      obterMunicipios: 'localidade/obterMunicipios',
    }),
    voltar() {
      this.$router.push({ name: 'Conselho' });
    },
    salvar() {
      this.loading = true;
      this.enviarDadosConselho(this.conselhoGetter).then(() => {
        eventHub.$emit(
          'eventoSucesso',
          'Enviado com sucesso! Um email será enviado com os dados da inscrição.',
        );
        this.conselho = Object.assign({});
        this.$router.push('/');
      }).catch((response) => {
        eventHub.$emit(
          'eventoErro',
          response.response.data.message,
        );
        this.$router.push('/');
      }).finally(() => {
        this.loading = false;
        this.fecharDialogo();
      });
    },
    abrirDialogo() {
      this.dialog = true;
    },
    fecharDialogo() {
      this.dialog = false;
    },
  },
  mounted() {
    this.listaUF = this.estadosGetter;
    this.conselho = this.conselhoGetter;
    this.listaMunicipios = this.municipiosGetter;
  },
};
</script>
