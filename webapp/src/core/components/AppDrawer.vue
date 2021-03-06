<template>
  <v-navigation-drawer
    :value="exibirGaveta"
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
      default: '300',
    },
  },
  data() {
    return {
      mini: false,
      menus: [],
      scrollSettings: {
        maxScrollbarLength: 160,
      },
      exibirGaveta: false,
      menuInscrivaseAtivo: false,
      usuarioLogado: {},
      menuAPI: [
        {
          title: 'Início',
          group: 'apps',
          icon: 'home',
          name: 'Inicio',
        },
        {
          title: 'Lista final de inscritos',
          group: 'apps',
          icon: 'list',
          name: 'inscricao-lista-parcial-route',
        },
        {
          title: 'Lista da etapa de habilitação',
          group: 'apps',
          icon: 'list',
          name: 'inscricao-lista-parcial-habilitacao-route',
        },
        {
          title: 'Votação',
          group: 'apps',
          icon: 'list',
          name: 'votacao-route',
        },
        {
          title: 'Lista final dos indicados',
          group: 'apps',
          icon: 'list',
          name: 'inscricao-lista-parcial-indicados-route',
        },
        {
          title: 'Resultado da votação',
          group: 'apps',
          icon: 'list',
          name: 'resultado-votacao-route',
        },
        {
            title: 'Resultado final - organizações',
            group: 'apps',
            icon: 'list',
            name: 'OrganizacaoResultadoFinalIndicadosRoute',
        },
      ],
    };
  },
  computed: {
    ...mapGetters({
      listaFinalRankingGetter: 'votacao/listaFinalRanking',
      ativarInscricaoConselho: 'fase/ativarInscricaoConselho',
      ativarInscricaoOrganizacao: 'fase/ativarInscricaoOrganizacao',
      ativarInscricaoEleitor: 'fase/ativarInscricaoEleitor',
      usuario: 'conta/usuario',
      perfil: 'conta/perfil',
    }),
  },
  watch: {
    value(val) {
      this.exibirGaveta = val;
    },
    usuario(valor) {
      this.usuarioLogado = valor;
    },
    usuarioLogado() {
      this.menus = this.menuAPI;
      this.carregarMenusUsuarioLogado();
    },
    listaFinalRankingGetter(listaFinal) {
      const jaExisteMenuPublicacaoResultadoFinal = this.menuAPI.find(
        opcaoMenu => opcaoMenu.name === 'administrador-gerar-resultado-final-route',
      );

      if (!Object.keys(listaFinal).length && !jaExisteMenuPublicacaoResultadoFinal && this.perfil.no_perfil === 'administrador') {
        this.definirItemMenu({
          title: 'Publicar ranking final',
          group: 'apps',
          name: 'administrador-gerar-resultado-final-route',
          icon: 'publish',
        }, 'Administração');
      }
    },
  },
  mounted() {
    this.obterFases();
    this.usuarioLogado = this.usuario;
    this.obterListaFinalRanking();
  },
  methods: {
    ...mapActions({
      obterListaFinalRanking: 'votacao/obterListaFinalRanking',
      obterFases: 'fase/obterFases',
    }),

    carregarMenusUsuarioLogado() {
      if (Object.keys(this.usuario).length < 1) {
        return false;
      }

      this.carregarMenusConselho();
      this.carregarMenusOrganizacao();
      this.carregarMenusEleitor();
      this.carregarMenuHabilitacao();
      this.carregarMenuAdministrador();

      return true;
    },
    carregarMenusEleitor() {
      const grupoValidacoes = [
        !!this.usuario.co_eleitor,
        this.usuario.co_eleitor > 0,
      ];
      const souValido = grupoValidacoes.indexOf(false) === -1;

      if (souValido) {
        this.definirItemMenu({
          title: 'Detalhes da inscrição',
          group: 'apps',
          name: 'EleitorDetalhesInscricaoRoute',
          icon: 'group',
        }, 'Eleitor');
      }
    },
    carregarMenusConselho() {
      const grupoValidacoes = [
        !!this.usuario.co_conselho,
        this.usuario.co_conselho > 0,
      ];
      const souValido = grupoValidacoes.indexOf(false) === -1;

      if (souValido) {
        this.definirItemMenu({
          title: 'Detalhes da inscrição',
          group: 'apps',
          name: 'ConselhoDetalhesInscricaoRoute',
          icon: 'group',
        }, 'Conselho');
        this.definirItemMenu({
          title: 'Indicação',
          group: 'apps',
          name: 'ConselhoIndicacaoRoute',
          icon: 'person_pin',
        }, 'Conselho');
      }
    },
    carregarMenusOrganizacao() {
      const grupoValidacoes = [
        !!this.usuario.co_organizacao,
        this.usuario.co_organizacao > 0,
      ];
      const souValido = grupoValidacoes.indexOf(false) === -1;

      if (souValido) {
        this.definirItemMenu({
          title: 'Detalhes da inscrição',
          group: 'apps',
          name: 'OrganizacaoDetalhesInscricaoRoute',
          icon: 'group',
        }, 'Organizacao');

        this.definirItemMenu({
          title: 'Recurso da habilitação',
          group: 'apps',
          name: 'OrganizacaoHabilitacaoRecursoRoute',
          icon: 'gavel',
        }, 'Organizacao');
      }
    },
    carregarMenuAdministrador() {
      if (this.perfil.no_perfil === 'administrador') {
        this.definirItemMenu({
          title: 'Usuários',
          group: 'apps',
          name: 'administrador-lista-usuarios-route',
          icon: 'group',
        }, 'Administração');

        this.definirItemMenu({
          title: 'Recursos',
          group: 'apps',
          name: 'lista-recurso-route',
          icon: 'gavel',
        }, 'Administração');

        this.definirItemMenu({
          title: 'Inscritos',
          group: 'apps',
          name: 'administrador-lista-inscritos-route',
          icon: 'list',
        }, 'Administração');
        this.definirItemMenu({
          title: 'Ranking parcial dos indicados',
          group: 'apps',
          name: 'administrador-ranking-indicados-route',
          icon: 'list',
        }, 'Administração');
        this.definirItemMenu({
          title: 'Indicados das organizações',
          group: 'apps',
          name: 'OrganizacaoIndicacaoRoute',
          icon: 'person_pin',
        }, 'Administração');
      }
    },
    carregarMenuHabilitacao() {
      const grupoValidacoes = [
        this.perfil.no_perfil === 'administrador',
        this.perfil.no_perfil === 'avaliador',
      ];
      const souValido = grupoValidacoes.indexOf(true) !== -1;
      if (souValido) {
        this.definirItemMenu({
          title: 'Habilitação de organização',
          group: 'apps',
          name: 'OrganizacaoListaHabilitacaoRoute',
          icon: 'list',
        }, 'Habilitação');
        this.definirItemMenu({
          title: 'Habilitação de conselhos',
          group: 'apps',
          name: 'ConselhoListaHabilitacaoRoute',
          icon: 'list',
        }, 'Habilitação');
        this.definirItemMenu({
          title: 'Habilitação de indicados',
          group: 'apps',
          name: 'ConselhoIndicacaoHabilitacaoRoute',
          icon: 'list',
        }, 'Habilitação');
        this.definirItemMenu({
          title: 'Recurso da Habilitação',
          group: 'apps',
          name: 'AdministradorAvaliadorHabilitacaoRecursoRoute',
          icon: 'gavel',
        }, 'Recurso');

        this.definirItemMenu({
          title: 'Recurso da indicação',
          group: 'apps',
          name: 'ConselhoIndicacaoListaRecursoRoute',
          icon: 'gavel',
        }, 'Recurso');
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
