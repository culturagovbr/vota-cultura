<template>
  <v-app class="split-bg">
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
            <v-card class="elevation-1 pa-3">
              <v-card-text>
                <div class="layout column align-center">
                  <img
                    src="/static/m.png"
                    alt="Vue Material Admin"
                    width="120"
                    height="120"
                  >
                  <h1 class="flex my-4 primary--text">
                    Material Admin Template
                  </h1>
                </div>
                <v-form>
                  <v-text-field
                    v-model="model.username"
                    append-icon="person"
                    name="login"
                    label="Login"
                    type="text"
                  />
                  <v-text-field
                    id="password"
                    v-model="model.password"
                    append-icon="lock"
                    name="password"
                    label="Password"
                    type="password"
                  />
                </v-form>
              </v-card-text>
              <div class="login-btn">
                <v-btn icon>
                  <v-icon color="blue">
                    fa fa-facebook-square fa-lg
                  </v-icon>
                </v-btn>
                <v-btn icon>
                  <v-icon color="red">
                    fa fa-google fa-lg
                  </v-icon>
                </v-btn>
                <v-btn icon>
                  <v-icon color="light-blue">
                    fa fa-twitter fa-lg
                  </v-icon>
                </v-btn>
                <v-spacer />
                <v-btn
                  block
                  color="primary"
                  :loading="loading"
                  @click="login"
                >
                  Login
                </v-btn>
              </div>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    loading: false,
    model: {
      username: 'admin@isocke.com',
      password: 'password',
    },
  }),

  methods: {
    login() {
      this.loading = true;
      setTimeout(() => {
        this.$router.push('/');
      }, 1000);
    },
  },
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
