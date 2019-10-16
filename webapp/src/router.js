import Vue from 'vue';
import Router from 'vue-router';
import NProgress from 'nprogress';
import store from './store';
import appRoutes from './routerConfig';
import 'nprogress/nprogress.css';
import coreRoutes from '@/core/router';

const routes = coreRoutes.concat(appRoutes);

Vue.use(Router);

const router = new Router({
  mode: 'history',
  linkActiveClass: 'active',
  routes,
});

router.beforeEach((to, from, next) => {
  NProgress.start();

  const authRequired = !to.meta.public || to.meta.public === false;

  store.dispatch('conta/tratarUsuarioLogado').then((response) => {
    let proximaPagina = true;
    const { conta } = store.state;
    const usuarioLogado = Object.keys(conta.usuario).length > 0;

    if (authRequired && !usuarioLogado) {
      const error = 'Autenticação requerida para acessar essa funcionalidade.';
      throw error;
    }

    if (usuarioLogado && to.fullPath === '/conta/autenticar') {
      proximaPagina = '/inicio';
    }

    next(proximaPagina);
  }).catch((Exception) => {
    store.dispatch('app/setMensagemErro', { text: `Erro: ${Exception}` }, { root: true });
    return next('/conta/autenticar');
  });
});

router.afterEach(() => {
  NProgress.done();
});

export default router;
