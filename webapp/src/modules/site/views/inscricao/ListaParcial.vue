<template>
  <v-container>
    <v-card class="elevation-1 pa-4 login-card">
      <v-card-title>
        <div class="layout column align-center">
          <h2 class="flex my-2 primary--text">
            {{ $route.meta.title }}
          </h2>
        </div>
      </v-card-title>
      <v-card-text>
        <lista-inscritos></lista-inscritos>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import ListaInscritos from './ListaInscritos';

export default {
  components: { ListaInscritos },
  name: 'ListaParcial',
};
</script>
