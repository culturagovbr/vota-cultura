<template>
  <v-app class="primary split-bg">
    <v-content>
      <v-container
        fluid
        fill-height
      >
        <v-layout
          align-center
          justify-center
        >
          <v-flex
            xs12
            sm8
            md4
            lg4
          >
            <v-slide-y-reverse-transition
              leave-absolute
              hide-on-leave
            >
              <router-view :key="$route.path" />
            </v-slide-y-reverse-transition>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    transitionName: 'slide-right',
  }),
  methods: {},
};
</script>
<style scoped lang="css">
.split-bg {
  height: 50%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  content: "";
  z-index: 0;
}
</style>
