import Vue from 'vue';
import Router from 'vue-router';
import NProgress from 'nprogress';
import store from './store';
import appRoutes from './routerConfig';
import { tokenValida } from '@/modules/shared/service/helpers/jwt';
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
  const userToken = localStorage.getItem('user_token');

  try {
    if (authRequired && !tokenValida(userToken)) {
      const error = 'Acesso expirado!';
      localStorage.removeItem('user_token');
      throw error;
    }

    return next();
  } catch (Exception) {
    store.dispatch('app/setMensagemErro', `Erro: ${Exception}`, { root: true });
    return next('/conta/autenticar');
  }
});

router.afterEach(() => {
  NProgress.done();
});

export default router;
