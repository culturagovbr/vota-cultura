<template>
  <v-container>
    <v-data-table
      :headers="headers"
      :items="historico"
      class="elevation-1"
    >
      <template
        slot="items"
        slot-scope="props"
      >
        <td class="text-md-center">{{ props.item.data_avaliacao_formatada }}</td>
        <td class="text-md-center">{{ props.item.usuarioAvaliador.no_nome }}</td>
        <td class="text-md-center">{{ props.item.nu_nova_pontuacao }}</td>
        <td class="text-md-center">{{ props.item.situacao_avaliacao }}</td>
        <td class="text-md-center">
          <v-btn outline color="indigo" small fab @click="detalharParecer(props.item.ds_parecer)">
            <v-icon>remove_red_eye</v-icon>
          </v-btn>
        </td>
      </template>
    </v-data-table>
    <v-dialog
      v-model="dialog"
      transition="dialog-bottom-transition"
      width="600"
    >
      <v-card>
        <v-toolbar
          dark
          color="primary"
        >
          <v-btn
            icon
            dark
            @click="dialog = false"
          >
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>
            Detalhamento do parecer
          </v-toolbar-title>
          <v-spacer />
        </v-toolbar>
        <v-card-text>
          <v-container>
            {{textoParecer}}
          </v-container>
        </v-card-text>
      </v-card>

    </v-dialog>
  </v-container>
</template>

<script>
export default {
  name: 'OrganizacaoListaHabilitacaoHistorico',
  props: {
    historico: {
      type: Array,
      default: () => [],
    },
  },
  data: () => ({
    dialog: false,
    textoParecer: '',
    headers: [
      {
        text: 'Data',
        value: 'dh_avaliacao',
        align: 'center',
      },
      {
        text: 'Avaliador',
        value: 'usuarioAvaliador.no_nome',
        align: 'center',
      },
      {
        text: 'Pontuação após análise',
        value: 'nu_nova_pontuacao',
        align: 'center',
      },
      {
        text: 'Resultado da habilitação',
        value: 'situacao_avaliacao',
        align: 'center',
      },
      {
        text: 'Parecer',
        value: 'ds_parecer',
        align: 'center',
      },
    ],
  }),
  methods: {
    detalharParecer(textoParecer) {
      this.dialog = true;
      this.textoParecer = textoParecer;
    },
  },
};
</script>
