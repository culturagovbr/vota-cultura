<template>
  <v-card>
    <v-toolbar
      card
      dense
      color="transparent"
    >
      <v-toolbar-title><h4>Message</h4></v-toolbar-title>
    </v-toolbar>
    <v-divider />
    <v-card-text class="pa-0">
      <v-list
        two-line
        class="pa-0"
      >
        <template v-for="(item, index) in items">
          <v-subheader
            v-if="item.header"
            :key="item.header"
          >
            {{ item.header }}
          </v-subheader>
          <v-divider
            v-else-if="item.divider"
            :key="index"
          />
          <v-list-tile
            v-else
            :key="item.title"
            avatar
            @click="handleClick"
          >
            <v-list-tile-avatar>
              <img :src="item.avatar">
            </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-title v-text="item.title" />
              <v-list-tile-sub-title v-text="item.subtitle" />
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
      <v-divider />
      <v-btn
        block
        flat
        class="ma-0"
      >
        All
      </v-btn>
      <v-divider />
    </v-card-text>
  </v-card>
</template>
<script>
import messages from '@/api/message';

export default {
  data: () => ({
    items: messages,
  }),
  methods: {
    handleClick: () => {},
  },
};
</script>
