<template>
  <div>
    <v-btn @click="recuperarSenha({id: usuario.cod_usuario})">
      Recuperar senha
    </v-btn>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      usuario: 'usuario/getUsuario',
    }),
  },
  methods: {
    ...mapActions({
      recuperarSenha: 'usuario/recuperarSenha',
    }),
  },
};
</script>
