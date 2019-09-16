<template>
  <v-menu
    ref="menu"
    v-model="menu"
    lazy
    transition="scale-transition"
    :close-on-content-click="false"
    offset-y
    full-width
    min-width="290px"
  >
    <template v-slot:activator="{ on }">
      <v-text-field
        v-model="dateFormatted"
        v-bind="$attrs"
        mask="##/##/####"
        label="Data de Nascimento"
        return-masked-value
        v-on="on"
      />
    </template>
    <v-date-picker
      v-model="date"
      no-title
      scrollable
      locale="pt-BR"
      @input="menu = false"
    />
  </v-menu>
</template>


<script>

export default {
  name: 'DatePicker',
  props: {
    value: {
      type: String,
      default: '',
    },
  },
  data: () => ({
    menu: false,
    date: '',
    dateFormatted: '',
  }),
  watch: {
    value(val) {
      this.date = val.substr(0, 10);
    },
    date(val) {
      this.dateFormatted = this.formatDate(val);
      this.$emit('input', val);
    },
  },
  mounted() {
    this.date = this.value;
  },
  methods: {
    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.substr(0, 10).split('-');
      return `${day}/${month}/${year}`;
    },
  },
};
</script>
