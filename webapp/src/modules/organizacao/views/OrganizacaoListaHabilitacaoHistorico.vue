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
        <td class="text-md-center">{{ props.item.ds_parecer }}</td>
      </template>
    </v-data-table>
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
};
</script>
