<template>
  <v-btn
    outline
    color="indigo"
    small
    @click="$emit('input', !value)"
  >
    <v-tooltip
      v-if="value"
      top
    >
      <template v-slot:activator="{ on }">
        Filtros
        <v-icon
          class="ml-2"
          small
          v-on="on"
        >
          close
        </v-icon>
      </template>
      <span>Fechar pesquisa</span>
    </v-tooltip>
    <v-tooltip
      v-else
      top
    >
      <template v-slot:activator="{ on }">
        Filtros
        <v-icon
          class="ml-2"
          small
          v-on="on"
        >
          filter_list
        </v-icon>
      </template>
      <span>Abrir pesquisa</span>
    </v-tooltip>
  </v-btn>
</template>

<script>
export default {
  name: 'BotaoFiltros',
  props: {
    value: {
      type: Boolean,
      default: false,
    },
  },
};
</script>
