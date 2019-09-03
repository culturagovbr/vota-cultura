<template>
  <v-navigation-drawer
    :value="showDrawer"
    class="app--drawer"
    :mini-variant.sync="mini"
    app
    clipped
    :width="drawWidth"
    @input="$emit('input', $event)"
  >
    <vue-perfect-scrollbar
      class="drawer-menu--scroll"
      :settings="scrollSettings"
    >
      <v-list
        dense
        expand
      >
        <template v-for="item in menus">
          <!--group with subitems-->
          <v-list-group
            v-if="item.items"
            :key="item.title"
            :group="item.group"
            :prepend-icon="item.icon"
            no-action="no-action"
          >
            <v-list-tile
              slot="activator"
              ripple="ripple"
            >
              <v-list-tile-content>
                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <template v-for="subItem in item.items">
              <!--sub group-->
              <v-list-group
                v-if="subItem.items"
                :key="subItem.name"
                :group="subItem.group"
                sub-group="sub-group"
              >
                <v-list-tile
                  slot="activator"
                  ripple="ripple"
                >
                  <v-list-tile-content>
                    <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile
                  v-for="grand in subItem.children"
                  :key="grand.name"
                  :to="obterRotaFilha(item, grand)"
                  :href="grand.href"
                  ripple="ripple"
                >
                  <v-list-tile-content>
                    <v-list-tile-title>{{ grand.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </v-list-group>
              <!--child item-->
              <v-list-tile
                v-else
                :key="subItem.name"
                :to="obterRotaFilha(item, subItem)"
                :href="subItem.href"
                :disabled="subItem.disabled"
                :target="subItem.target"
                ripple="ripple"
              >
                <v-list-tile-content>
                  <v-list-tile-title>
                    <span>{{ subItem.title }}</span>
                  </v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action v-if="subItem.action">
                  <v-icon :class="[subItem.actionClass || 'success--text']">
                    {{ subItem.action }}
                  </v-icon>
                </v-list-tile-action>
              </v-list-tile>
            </template>
          </v-list-group>
          <v-subheader
            v-else-if="item.header"
            :key="item.name"
          >
            {{ item.header }}
          </v-subheader>
          <v-divider
            v-else-if="item.divider"
            :key="item.name"
          />
          <!--top-level link-->
          <v-list-tile
            v-else
            :key="item.name"
            :to="!item.href ? { name: item.name } : null"
            :href="item.href"
            ripple="ripple"
            :disabled="item.disabled"
            :target="item.target"
            rel="noopener"
          >
            <v-list-tile-action v-if="item.icon">
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ item.title }}</v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-action v-if="item.subAction">
              <v-icon class="success--text">
                {{ item.subAction }}
              </v-icon>
            </v-list-tile-action>
          </v-list-tile>
        </template>
      </v-list>
    </vue-perfect-scrollbar>
  </v-navigation-drawer>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import VuePerfectScrollbar from 'vue-perfect-scrollbar';

export default {
  name: 'AppDrawer',
  components: {
    VuePerfectScrollbar,
  },
  props: {
    value: {
      type: Boolean,
      default: true,
    },
    expanded: {
      type: Boolean,
      default: true,
    },
    drawWidth: {
      type: [Number, String],
      default: '260',
    },
  },
  data() {
    return {
      mini: false,
      menus: [],
      scrollSettings: {
        maxScrollbarLength: 160,
      },
      showDrawer: false,
      menuInscrivaseAtivo: false,
      usuarioLogado: {},
      menuAPI: [
        {
          title: 'Início',
          group: 'apps',
          icon: 'home',
          name: 'Inicio',
        },
      ],
    };
  },
  computed: {
    ...mapGetters({
      ativarInscricaoConselho: 'fase/ativarInscricaoConselho',
      ativarInscricaoOrganizacao: 'fase/ativarInscricaoOrganizacao',
      ativarInscricaoEleitor: 'fase/ativarInscricaoEleitor',
      usuario: 'conta/usuario',
      perfil: 'conta/perfil',
    }),
    computeGroupActive() {
      return true;
    },
    sideToolbarColor() {
      return this.$vuetify.options.extra.sideNav;
    },
  },
  watch: {
    value(val) {
      this.showDrawer = val;
    },
    usuario(valor) {
      this.usuarioLogado = valor;
    },
    usuarioLogado() {
      this.menus = this.menuAPI;
      this.carregarMenusUsuarioLogado();
    },
  },
  mounted() {
    this.obterFases();
    this.usuarioLogado = this.usuario;
  },
  methods: {
    ...mapActions({
      obterFases: 'fase/obterFases',
    }),

    carregarMenusUsuarioLogado() {
      if (Object.keys(this.usuario).length < 1) {
        return false;
      }

      this.carregarMenusConselho();
      this.carregarMenusOrganizacao();
      this.carregarMenusEleitor();

      return true;
    },
    carregarMenusEleitor() {
      if (this.usuario.co_eleitor && this.usuario.co_eleitor > 0) {
        this.definirItemMenu({
          title: 'Detalhes da inscrição',
          group: 'apps',
          name: 'EleitorDetalhesInscricaoRoute',
          icon: 'group',
        }, 'Eleitor');
      }
    },
    carregarMenusConselho() {
      if (this.perfil.no_perfil === 'conselho') {
        this.definirItemMenu({
          title: 'Detalhes da inscrição',
          group: 'apps',
          name: 'ConselhoDetalhesInscricaoRoute',
          icon: 'group',
        }, 'Conselho');
      }
    },
    carregarMenusOrganizacao() {
      if (this.perfil.no_perfil === 'organizacao') {
        this.definirItemMenu({
          title: 'Detalhes da inscrição',
          group: 'apps',
          name: 'OrganizacaoDetalhesInscricaoRoute',
          icon: 'group',
        }, 'Organizacao');
      }
    },
    carregarMenuAdministrador() {
      if (this.perfil.no_perfil === 'administrador') {

        this.definirItemMenu({
          title: 'Lista de usuários',
          group: 'apps',
          name: 'administrador-lista-usuarios-route',
          icon: 'group',
        }, 'Usuario');
      }

    },
    definirItemMenu(objetoMenu, nomeAgrupador) {
      this.definirAgrupadorMenu(nomeAgrupador);
      this.menus.push(objetoMenu);
    },
    definirAgrupadorMenu(nomeAgrupador) {
      const indiceAgrupadorInscricaoDeMenus = this.menus.findIndex(indice => indice.name === nomeAgrupador);
      if (indiceAgrupadorInscricaoDeMenus === -1) {
        this.menus.push({ header: nomeAgrupador, name: nomeAgrupador });
      }
    },
    obterRotaFilha(item, subItem) {
      if (subItem.href) {
        return {};
      }
      let filho = { name: `${item.group}/${subItem.name}` };
      if (subItem.component) {
        filho = { name: subItem.component };
      }
      return filho;
    },
  },
};
</script>

<style lang="stylus" scoped>

</style>
