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
              <conselho-detalhes-inscricao-visualizacao />

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
            <v-container v-else>
              <v-layout>
                <v-flex>
                  <v-alert
                    type="error"
                    :value="true"
                  >
                    É necessário preencher as informações do cadastro.
                  </v-alert>
                  <div class="mb-6">
                    <v-btn @click="voltar">
                      Voltar
                    </v-btn>
                  </div>
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
import ConselhoDetalhesInscricaoVisualizacao from './ConselhoDetalhesInscricaoVisualizacao';

export default {
  name: 'RevisaoConselho',
  components: {
    ConselhoDetalhesInscricaoVisualizacao,
  },
  data: () => ({
    confirmacaoDadosDeInscricao: false,
    dialog: false,
    conselho: {},
  }),
  computed: {
    ...mapGetters({
      conselhoGetter: 'conselho/conselho',
    }),
  },
  watch: {
    conselhoGetter(value) {
      this.conselho = value;
    },
  },
  methods: {
    ...mapActions({
      enviarDadosConselho: 'conselho/enviarDadosConselho',
    }),
    voltar() {
      this.$router.push({ name: 'Conselho' });
    },
    salvar() {
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
    this.conselho = this.conselhoGetter;
  },
};
</script>
