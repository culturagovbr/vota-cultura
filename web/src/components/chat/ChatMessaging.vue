<template>
  <v-container
    id="messaging"
    class="fill-height pa-0 ma-0 messaging fluid"
  >
    <template v-if="!$vuetify.breakpoint.smAndDown">
      <v-layout row>
        <v-flex
          lg3
          class="white"
        >
          <chat-history />
        </v-flex>
        <v-flex lg9>
          <chat-window />
        </v-flex>
      </v-layout>
    </template>
    <template v-else>
      <v-layout column>
        <v-flex
          v-if="showSidebar"
          sm12
          class="white"
        >
          <chat-history />
        </v-flex>
        <v-flex
          v-if="showWindow"
          sm12
        >
          <chat-window />
        </v-flex>
      </v-layout>
    </template>
  </v-container>
</template>
<script>
import ChatHistory from './ChatHistory';
import ChatWindow from './ChatWindow';

export default {
  components: {
    ChatHistory,
    ChatWindow,
  },
  data() {
    return {};
  },
  computed: {
    showSidebar() {
      return this.$route.params.uuid === undefined;
    },
    showWindow() {
      return this.$route.params.uuid !== undefined;
    },
  },
};
</script>
