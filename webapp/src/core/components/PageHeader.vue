<template>
  <v-layout
    row
    class="align-center layout app--page-header">
    <v-spacer />
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
    };
  },
  watch: {
    /* eslint-disable func-names */
    '$route.path': function (val) {
        console.log(val)
    },
  },
  created() {
  },
  methods: {
  },
};
</script>
<style lang="stylus" scoped>
  .disabled
    color: grey
    pointer-events: none
    text-decoration: blink
</style>
