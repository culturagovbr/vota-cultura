<template>
  <v-container class="fill-height pa-0 ma-0 chat-drawer-container fluid">
    <template v-if="!$vuetify.breakpoint.smAndDown">
      <v-layout row>
        <v-flex
          lg3
          class="chat-contact--sidebar white"
        >
          <chat-contact-list />
        </v-flex>
        <v-flex lg9>
          <chat-contact-profile />
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
          <chat-contact-list />
        </v-flex>
        <v-flex
          v-if="showWindow"
          sm12
        >
          <chat-contact-profile />
        </v-flex>
      </v-layout>
    </template>
  </v-container>
</template>
<script>
import ChatContactList from './ChatContactList';
import ChatContactProfile from './ChatContactProfile';

export default {
  components: {
    ChatContactList,
    ChatContactProfile,
  },
  data() {
    return {
      chat: null,
      selectedTab: null,
    };
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
