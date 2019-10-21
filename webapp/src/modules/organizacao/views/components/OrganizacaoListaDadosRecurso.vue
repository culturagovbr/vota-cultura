<template>
  <v-container fluid subheading grey--text mt-2 text-xs-left font-weight-bold>
    <v-layout row wrap>
      <v-flex xs6>Nome da organização/entidade cultural: Organização teste 123</v-flex>
      <v-flex xs6>CNPJ: 11.222.333/0001-10</v-flex>
    </v-layout>

    <v-layout row wrap mt-2>
      <v-flex xs6>Pontuação inicial: 12</v-flex>
      <v-flex xs6>Segmento cultural: Povos indígenas.</v-flex>
    </v-layout>

    <v-layout row wrap mt-2>
      <v-flex xs6>Pontuação após análise: 20</v-flex>
      <v-flex xs6>
        Resultado parcial da habilitação:
        <span class="red--text">Inabilitada</span>
      </v-flex>
    </v-layout>

    <v-layout row wrap mt-2>
      <v-flex xs6>Pontuação final: 20</v-flex>
      <v-flex xs6>
        Resultado final da habilitação:
        <span class="red--text"></span>
      </v-flex>
    </v-layout>

    <v-container fluid subheading mt-2 text-xs-left>
      <v-layout row wrap>
        <v-flex>
          <v-card>
            <v-card-text>
              <div class="grey--text">
                Ilmo Sr. Secretário da Diversidade Cultural.
                <div class="mt-4 p4">
                  Com base no item 6 desta CHAMADA PÚBLICA PARA COMPOSIÇÃO DO CONSELHO NACIONAL DE POLÍTICA CULTURAL
                  <br />(CNPC) NO TRIÊNIO 2019/2022, venho interpor recurso em face do resultado, na etapa de habilitaçãp, pelos motivos abaixo descritos:
                </div>
                <div class="mt-4">
                  <v-textarea
                    v-model="formulario.dsRecurso"
                    placeholder="Venho por meio deste interpor recurso referente à habilitação da Organização XPTO"
                    rows="13"
                    row-height="28"
                    :counter="1000"
                    box
                    auto-grow
                    :rules="[rules.required, rules.tamanhoMaximoCaracteres]"
                  />
                </div>
              </div>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>

    <v-container fluid subheading mt-2 text-xs-left>
      <v-layout row wrap>
        <v-flex>
          <v-card>
            <v-card-text>
              <div class="grey--text">
                Avaliação
                <div mt-2 md12>
                  <v-select
                    v-model="formulario.resultadoHabilitacao"
                    :items="itemsResultadoHabilitacao"
                    label="*Resultado final da habilitação"
                    append-icon="place"
                    required
                    box
                    :rules="[rules.required]"
                  />
                </div>

                <div class="mt-2">
                  <v-textarea
                    v-model="formulario.dsParecer"
                    placeholder="*Parecer"
                    rows="13"
                    row-height="28"
                    :counter="15000"
                    box
                    auto-grow
                    :rules="[rules.required, rules.tamanhoMaximoCaracteres]"
                  />
                </div>

                <div class="mt-2">
                  <v-textarea
                    v-model="formulario.dsParecer"
                    placeholder="*Parecer"
                    rows="13"
                    row-height="28"
                    :counter="15000"
                    box
                    auto-grow
                    :rules="[rules.required, rules.tamanhoMaximoCaracteres]"
                  />
                </div>

                <v-flex class="mt-2" sm2>
                  <v-text-field
                    v-model="formulario.pontuacaoFinal"
                    type="number"
                    min="0"
                    max="99"
                    step="1"
                    mask="##"
                    onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
                    label="Pontuação Final"
                  />
                </v-flex>
              </div>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>

    </v-container>
      <v-container fluid subheading mt-2 text-xs-left>
        <v-layout>
          <v-flex>
            <v-card>
              <v-card-text class="grey--text">
                Anexo
                <div mt-2 class='text-xs-center'>
                  <span mt-2 >Caso seja necessário, anexe o documento no formato PDF</span>
                  <v-flex mt-2>
                    <file
                      v-model="formulario.anexo"
                      :accepted-file-types="['application/pdf']"
                    />
                  </v-flex>
                </div>
              </v-card-text>

            </v-card>
          </v-flex>
        </v-layout>

        <v-layout
          mt-4
          align-center
          justify-center
          row
          fill-height
        >
          <v-btn
            href="/"
          >
            Cancelar
          </v-btn>
          <v-btn
            color="primary"
            :loading="loading"
            @click="handleDialogConcluirAvaliacao"
          >
          Avaliar
        </v-btn>
      </v-layout>
      </v-container>
    </v-container>

</template>

<script>
import File from '@/core/components/upload/File';
export default {
  components : {
    File
  },
  methods: {
    handleDialogConcluirAvaliacao(value) {
        console.log('------------------------------------');
        console.log(value);
        console.log('------------------------------------');
    }
  },
  data: () => ({
    loading : false,
    formulario: {
      dsRecurso: "",
      dsParecer: "",
      resultadoHabilitacao: 0,
      pontuacaoFinal : 0,
      anexo : {}
    },
    itemsResultadoHabilitacao: [
      { value: 0, text: "Inabilitada" },
      { value: 1, text: "Habilitada e desclassificada" },
      { value: 2, text: "Habilitada e classificada" }
    ],
    rules: {
      required: v => !!v || "Campo não preenchido",
      tamanhoMaximoCaracteres: value =>
        (!!value && value.length <= 1000) || "Máximo 1000 caracteres",
      dataAniversario: value => {
        if (value.length === 0 || !value.trim()) {
          return false;
        }
        // eslint-disable-next-line
        var padraoDataValida = /^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])      [\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/;

        if (!value.match(padraoDataValida)) {
          return "Data inválida";
        }

        let [dia, mes, ano] = value.split("/");

        const hoje = new Date();
        const dataAniversario = new Date(ano, mes - 1, dia);

        ano = hoje.getFullYear() - dataAniversario.getFullYear();
        mes = hoje.getMonth() - dataAniversario.getMonth();
        if (
          mes < 0 ||
          (mes === 0 && hoje.getDate() < dataAniversario.getDate())
        ) {
          ano--;
        }

        if (ano > 100 || ano < 18) {
          return "É necessário ser maior de 18 anos";
        }
        return true;
      }
    }
  })
};
</script>
